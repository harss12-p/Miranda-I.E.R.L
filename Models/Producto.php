<?php

require_once __DIR__ . '/BaseModel.php';

class Producto extends BaseModel
{
    protected string $table = 'productos';

    public function getConCategoria(): array
    {
        $sql = "
            SELECT p.*, c.nombre AS categoria
            FROM productos p
            LEFT JOIN categorias c
            ON p.categoria_id = c.id
        ";

        return $this->db->query($sql)->fetchAll();
    }

    public function getVariaciones(int $productoId): array
    {
        $sql = "
            SELECT *
            FROM variaciones_producto
            WHERE producto_id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $productoId]);

        return $stmt->fetchAll();
    }
}
