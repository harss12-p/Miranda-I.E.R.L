<?php

require_once __DIR__ . '/BaseModel.php';

class Usuario extends BaseModel
{
    protected string $table = 'usuarios';

    // Buscar por email
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

        // Verificar contraseña
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return null;
    }
}