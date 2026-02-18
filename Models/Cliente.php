<?php

require_once __DIR__ . '/BaseModel.php';

class Cliente extends BaseModel
{
    protected string $table = 'clientes';
    protected string $primaryKey = 'usuario_id';

    // Crear cliente
    public function create(array $data): int
    {
        $sql = "
            INSERT INTO clientes 
            (usuario_id, nombre, apellidos, telefono, direccion)
            VALUES
            (:usuario_id, :nombre, :apellidos, :telefono, :direccion)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'usuario_id' => $data['usuario_id'],
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'telefono' => $data['telefono'],
            'direccion' => $data['direccion']
        ]);

        return $this->db->lastInsertId();
    }

    // Obtener perfil completo
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
