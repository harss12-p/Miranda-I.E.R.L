<?php

require_once __DIR__ . '/BaseModel.php';

class Pedido extends BaseModel
{
    protected string $table = 'pedidos';

    public function getDetalles(int $pedidoId): array
    {
        if ($pedidoId <= 0) {
            return [];
        }

        $sql = "
            SELECT
                dp.id AS detalle_id,
                dp.pedido_id,
                dp.variacion_id,
                dp.cantidad,
                dp.precio,
                v.color,
                v.material,
                p.nombre AS producto_nombre
            FROM detalle_pedido dp
            JOIN variaciones_producto v ON dp.variacion_id = v.id
            JOIN productos p ON v.producto_id = p.id
            WHERE dp.pedido_id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $pedidoId]);

        return $stmt->fetchAll();
    }
}