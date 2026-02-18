<?php

require_once __DIR__ . '/AuthMiddleware.php';

class AdminMiddleware {

    public static function handle() {

        AuthMiddleware::handle();

        if ($_SESSION['user_tipo'] !== 'admin') {
            http_response_code(403);
            echo "Acceso denegado";
            exit;
        }
    }
}