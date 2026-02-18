<h2>Lista de Clientes</h2>

<a href="/admin/clientes/create">Nuevo Cliente</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($clientes as $c): ?>

    <tr>
        <td><?= $c['usuario_id'] ?></td>
        <td><?= $c['nombre'] ?></td>

        <td>
            <a href="/admin/clientes/delete?id=<?= $c['usuario_id'] ?>">
                Eliminar
            </a>
        </td>
    </tr>

    <?php endforeach; ?>
</table>
