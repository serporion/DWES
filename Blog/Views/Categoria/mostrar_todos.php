<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['correcto'])): ?>
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($_SESSION['correcto']) ?>
    </div>
    <?php unset($_SESSION['correcto']);  ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']);  ?>
<?php endif;


$numero_elementos_pagina = 6;

$paginacion = new Zebra_Pagination();


$paginacion->records(count($todas_las_categorias));


$paginacion->records_per_page($numero_elementos_pagina);
$todas_las_categorias = array_slice($todas_las_categorias, (($paginacion->get_page()-1 )* $numero_elementos_pagina), $numero_elementos_pagina);


?>


<?php if (empty($todas_las_categorias)) : ?>
    <p>No hay categorias disponibles.</p>
<?php else : ?>

    <?php if (isset($_SESSION['usuario'])): ?>
        <input type="button" value="Crear Categoría" onclick="location.href='<?=BASE_URL?>Categoria/registroCategorias'" />
        <input type="button" value="Volver" onclick="location.href='<?=BASE_URL?>Dashboard/index'" />
    <?php endif; ?>

    <h2>Lista de Categorías</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($todas_las_categorias as $categoria): ?>
            <tr>
                <td><?= htmlspecialchars($categoria->getId()) ?></td>
                <td><?= htmlspecialchars($categoria->getNombre()) ?></td>


                <td>
                    <a href="<?=BASE_URL?>Categoria/editarCategoria?id=<?=urlencode($categoria->getId())?>">Editar</a>

                </td>
                <td>
                    <a href="<?=BASE_URL?>Categoria/borrarCategoria?id=<?= urlencode($categoria->getId()) ?>"
                       onclick="return confirm('¿Estás seguro de que deseas borrar esta categoría?');">
                        Borrar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;

$paginacion ->render();?>

