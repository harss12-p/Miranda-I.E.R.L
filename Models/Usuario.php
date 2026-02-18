<?php

require_once __DIR__ . '/BaseModel.php';
require __DIR__ . '/BaseMode.php';
class Usuario extends BaseModel
{
    protected string $table = 'usuarios';

    // Buscar por email
    public function findByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

    // Verificar contraseña
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user) return null;

        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return null;
    }

    
}