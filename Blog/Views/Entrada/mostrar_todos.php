<?php

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


$paginacion->records(count($todas_las_entradas));

$paginacion->records_per_page($numero_elementos_pagina);

$todas_las_entradas = array_slice($todas_las_entradas, (($paginacion->get_page()-1 )* $numero_elementos_pagina), $numero_elementos_pagina);

?>


<body>

<?php if (session_status() == PHP_SESSION_NONE)
    { session_start(); }
?>

<?php if (isset($_SESSION['usuario'])): ?>
    <input type="button" value="Crear Entrada" onclick="location.href='<?=BASE_URL?>Entrada/registroEntradas'" />
    <input type="button" value="Volver" onclick="location.href='<?=BASE_URL?>Dashboard/index'" />
<?php endif; ?>


<h2>Lista de Entradas</h2>

<?php if (empty($todas_las_entradas)) : ?>
    <p>No hay entradas disponibles.</p>
<?php else : ?>
    <div class="entradas-container">
        <?php foreach ($todas_las_entradas as $entrada): ?>
            <div class="entrada">
                <h3><?= htmlspecialchars($entrada->getTitulo()) ?></h3>
                <p><strong>Escrita por:</strong> <?= htmlspecialchars($entrada->getUsuarioId()) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($entrada->getCategoriaId()) ?></p>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($entrada->getDescripcion()) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars(date('d-m-Y', strtotime($entrada->getFecha()))) ?></p>

                <div class="entrada-actions">
                    <?php

                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 7): ?>
                        <input type="button" class="boton" value="Editar" onclick="location.href='<?=BASE_URL?>Entrada/editarEntrada?id=<?=urlencode($entrada->getId())?>'" />
                        <input type="button" class="boton" value="Borrar" onclick="if (confirm('¿Estás seguro de que deseas borrar esta entrada?')) { location.href='<?= BASE_URL ?>Entrada/borrarEntrada?id=<?= urlencode($entrada->getId()) ?>'; }" />
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php $paginacion->render(); ?>
</body>
