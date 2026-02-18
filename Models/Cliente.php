<?php

require_once 'BaseModel.php';

class Cliente extends BaseModel
{
    protected string $table = 'clientes';
    protected string $primaryKey = 'usuario_id';

    public function getPerfilCompleto(int $usuarioId): ?array
    {
        $sql = "
            SELECT u.*, c.*
            FROM usuarios u
            JOIN clientes c ON u.id = c.usuario_id
            WHERE u.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $usuarioId]);

        return $stmt->fetch() ?: null;
    }
}