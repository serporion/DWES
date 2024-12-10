
<h1 class="title">Bienvenido al Blog Del Café</h1>

<h2>Lista de Entradas</h2>

<?php if (isset($_SESSION['correcto'])): ?>

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

<?php endif; ?>


<?php if (empty($todas_las_entradas)) : ?>
    <p>No hay entradas disponibles.</p>
    <input type="button" value="Mostrar Entradas" onclick="location.href='<?=BASE_URL?>Entrada/extraer_todos'" />
<?php else : ?>
    <div class="entradas-container">
        <?php foreach ($todas_las_entradas as $entrada): ?>
            <div class="entrada">
                <h3><?= htmlspecialchars($entrada->getTitulo()) ?></h3>
                <p><strong>Escrita por:</strong> <?= htmlspecialchars($entrada->getUsuarioId()) ?></p>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($entrada->getCategoriaId()) ?></p>
                <p><strong>Descripción:</strong> <?= htmlspecialchars($entrada->getDescripcion()) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars(date('d-m-Y', strtotime($entrada->getFecha()))) ?></p>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


