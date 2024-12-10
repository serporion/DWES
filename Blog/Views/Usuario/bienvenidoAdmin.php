
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


<input type="button" value="Gestionar Categorias" onclick="location.href='<?=BASE_URL?>Categoria/extraer_todos'" />
<input type="button" value="Gestionar Usuarios" onclick="location.href='<?=BASE_URL?>Usuario/extraer_todos'" />
<input type="button" value="Gestionar Entradas" onclick="location.href='<?=BASE_URL?>Entrada/extraer_todos'" />





