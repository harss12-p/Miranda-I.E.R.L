<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Cliente.php';

class AuthService {

    private Usuario $usuarioModel;
    private Cliente $clienteModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
        $this->clienteModel = new Cliente();
    }

    // REGISTRO CLIENTE
    public function registrarCliente($email, $password, $nombre, $apellidos, $telefono, $direccion) {

        // Verificar si ya existe el usuario
        if ($this->usuarioModel->findByEmail($email)) {
            throw new Exception("El correo ya está registrado");
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Crear usuario
        $usuarioId = $this->usuarioModel->create([
            'email' => $email,
            'password_hash' => $passwordHash,
            'tipo' => 'cliente'
        ]);

        // Crear cliente
        $this->clienteModel->create([
            'usuario_id' => $usuarioId,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'direccion' => $direccion
        ]);

        return true;
    }

    // LOGIN
    public function login($email, $password) {

        $usuario = $this->usuarioModel->findByEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($password, $usuario['password_hash'])) {
            return false;
        }

        // Guardar sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_tipo'] = $usuario['tipo'];

        return true;
    }

    // LOGOUT
    public function logout() {
        session_destroy();
    }

    // VERIFICAR LOGIN
    public static function checkAuth() {
        return isset($_SESSION['user_id']);
    }

    // VALIDAR ROL
    public static function checkRole($rol) {
        return isset($_SESSION['user_tipo']) && $_SESSION['user_tipo'] === $rol;
    }
}
