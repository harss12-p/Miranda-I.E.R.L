<?php

require_once 'BaseModel.php';

class Pedido extends BaseModel
{
    protected string $table = 'pedidos';

    public function getDetalles(int $pedidoId): array
    {
        $sql = "
            SELECT dp.*, v.color, v.material, p.nombre
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
