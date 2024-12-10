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
    <h1>Registro Categorias</h1>
    <div class = "col-md-12 well">
        <form role = "form" id = "myForm" action = "<?=BASE_URL?>Categoria/guardarCategoria" method = "post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" minLength = "4" required = "true">
            </div>


            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="submit" class="btn btn-primary" onclick="history.back()">Cancelar</button>
        </form>
    </div>
</div>
