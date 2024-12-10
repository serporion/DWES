<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errores = $_SESSION['errores'] ?? [];

if(isset($_SESSION['valores'])){
    $valores = $_SESSION['valores'] ;
}

unset($_SESSION['errores'], $_SESSION['valores']); // Limpiar después de usarlos
?>

<div class = "container">
    <h1>Registra una Entrada</h1>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?> <li><?php echo htmlspecialchars($error); ?></li> <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class = "col-md-12 well">
        <form role = "form" id = "myForm" action = "<?=BASE_URL?>Entrada/guardarEntrada" method = "post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" aria-describedby="tituloHelp" minLength = "4" required = "true">
                <?php if (isset($errores['titulo'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['titulo']); ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="categoria_id">Categoría de la Entrada</label>
                <select id="categoria_id" name="categoria_id" class="form-control" aria-describedby="categoriaHelp" required="true">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= htmlspecialchars($categoria['id']) ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="descripcion" class="form-label" >Escribe tu comentario:</label>
                <textarea id="descripcion" name="descripcion" rows="4" class="form-control" aria-describedby="descripcionHelp" required = "true"></textarea>
                <?php if (isset($errores['descripcion'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['descripcion']); ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <a class="btn btn-primary" href="<?=BASE_URL?>Dashboard/index">Cancelar</a>

        </form>
    </div>
</div>
