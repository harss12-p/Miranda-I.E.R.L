<?php

require_once __DIR__ . '/../models/Cliente.php';

class AdminClienteController {

    private Cliente $clienteModel;

    public function __construct() {
        $this->clienteModel = new Cliente();
    }

    // Listar clientes
    public function index()
        {
        $clientes = $this->clienteModel->findAll();

        require __DIR__ . '/../views/admin/clientes/index.php';
    }


    // Form crear
    public function create() {
        require __DIR__ . '/../views/admin/clientes/create.php';
    }

    // Guardar cliente
    public function store() {

        $this->clienteModel->create([
            'usuario_id' => $_POST['usuario_id'],
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'telefono' => $_POST['telefono'],
            'direccion' => $_POST['direccion']
        ]);

        header('Location: /admin/clientes');
    }

    // Eliminar cliente
    public function delete() {

        $this->clienteModel->delete($_GET['id']);

        header('Location: /admin/clientes');
    }
}