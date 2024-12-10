<?php

$numero_elementos_pagina = 2;

$paginacion = new Zebra_Pagination();


$paginacion->records(count($todos_los_usuarios));

$paginacion->records_per_page($numero_elementos_pagina);

$base_url = BASE_URL . "Usuario/extraer_todos/";
$paginacion->base_url($base_url);

$todos_los_usuarios = array_slice($todos_los_usuarios, (($paginacion->get_page()-1 )* $numero_elementos_pagina), $numero_elementos_pagina);

?>

<body>
<?php if (isset($_SESSION['usuario'])): ?>
    <input type="button" value="Crear Usuario" onclick="location.href='<?=BASE_URL?>Usuario/registroUsuarios'" />
    <input type="button" value="Volver" onclick="location.href='<?=BASE_URL?>Dashboard/index'" />
<?php endif; ?>


<h2>Lista de Usuarios</h2>

<?php if (empty($todos_los_usuarios)) : ?>
    <p>No hay usuarios disponibles.</p>
<?php else : ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Password</th>
            <th>Fecha de Nacimiento</th>
            <th>Rol</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($todos_los_usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario->getId()) ?></td>
                <td><?= htmlspecialchars($usuario->getNombre()) ?></td>
                <td><?= htmlspecialchars($usuario->getApellidos()) ?></td>
                <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                <td><?= htmlspecialchars($usuario->getPassword()) ?></td>
                <td><?= htmlspecialchars($usuario->getFecha()) ?></td>
                <td><?= htmlspecialchars($usuario->getRol()) ?></td>

                <td>
                    <a href="<?=BASE_URL?>Usuario/editarUsuario?id=<?=urlencode($usuario->getId())?>">Editar</a>

                </td>
                <td>
                    <a href="<?=BASE_URL?>Usuario/borrarUsuario?id=<?= urlencode($usuario->getId()) ?>"
                       onclick="return confirm('¿Estás seguro de que deseas borrar este usuario?');">
                        Borrar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;

$paginacion ->render();?>
</body>
