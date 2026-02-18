<?php

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // =============================
    // Obtener todos los registros
    // =============================
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->query($sql)->fetchAll();
    }

    // =============================
    // Buscar por ID
    // =============================
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();
        return $result ?: null;
    }

    // =============================
    // Eliminar registro
    // =============================
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // =============================
    // Crear registro dinámico
    // =============================
    public function create(array $data): int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int)$this->db->lastInsertId();
    }

    // =============================
    // Actualizar registro dinámico
    // =============================
    public function update(int $id, array $data): bool
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= "$key = :$key,";
        }

        $fields = rtrim($fields, ',');

        $sql = "UPDATE {$this->table}
                SET $fields
                WHERE {$this->primaryKey} = :id";

        $data['id'] = $id;

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }
}
