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
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    <div class = "col-md-12 well">

        <form role = "form" id = "myForm" action = "<?=BASE_URL?>Login/comprobarUsuario" method = "post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" aria-describedby="usuarioHelp" minLength = "5" value="<?php echo isset($usu) ? $usu : ''; ?>" required = "true" placeholder="Ingresa tu correo electrónico">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required = "true" >

            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</div>
