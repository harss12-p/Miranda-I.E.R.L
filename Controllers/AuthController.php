<?php

require_once __DIR__ . '/../services/AuthService.php';

class AuthController {

    private AuthService $authService;

    public function __construct() {
        session_start();
        $this->authService = new AuthService();
    }

    // Mostrar Login
    public function showLogin() {
        require __DIR__ . '/../views/auth/login.php';
    }

    // Procesar Login
    public function login() {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->authService->login($email, $password)) {

            // Redirigir según rol
            if ($_SESSION['user_tipo'] === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /cliente/dashboard');
            }
            exit;
        }

        $error = "Credenciales incorrectas";
        require __DIR__ . '/../views/auth/login.php';
    }

    // Mostrar Registro
    public function showRegister() {
        require __DIR__ . '/../views/auth/register.php';
    }

    // Procesar Registro Cliente
    public function register() {

        try {

            $this->authService->registrarCliente(
                $_POST['email'],
                $_POST['password'],
                $_POST['nombre'],
                $_POST['apellidos'],
                $_POST['telefono'] ?? null,
                $_POST['direccion'] ?? null
            );

            header('Location: /login');
            exit;

        } catch (Exception $e) {

            $error = $e->getMessage();
            require __DIR__ . '/../views/auth/register.php';
        }
    }

    // Logout
    public function logout() {

        $this->authService->logout();
        header('Location: /login');
        exit;
    }
}
