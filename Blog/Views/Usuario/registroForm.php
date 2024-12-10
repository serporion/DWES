
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

<div class="container">
    <h1>Registro Usuario</h1>
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error): ?> <li><?php echo htmlspecialchars($error); ?></li> <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="col-md-12 well">

        <form role="form" id="myForm" action="<?=BASE_URL?>Usuario/guardarUsuario" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" minLength="4" required="true" value="<?php echo htmlspecialchars($valores['nombre'] ?? ''); ?>">
                <?php if (isset($errores['nombre'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['nombre']); ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" aria-describedby="apellidosHelp" required="true" value="<?php echo htmlspecialchars($valores['apellidos'] ?? ''); ?>">
                <?php if (isset($errores['apellidos'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['apellidos']); ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" minLength="8" required="true" value="<?php echo htmlspecialchars($valores['email'] ?? ''); ?>">
                <?php if (isset($errores['email'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['email']); ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha" name="fecha" aria-describedby="fechaHelp" required="true" value="<?php echo htmlspecialchars($valores['fecha'] ?? ''); ?>">
                <?php if (isset($errores['fecha'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['fecha']); ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" required="true">
                <?php if (isset($errores['password'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['password']); ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="passwordrepetida" class="form-label">Repite la Password</label>
                <input type="password" class="form-control" id="passwordrepetida" name="passwordrepetida" aria-describedby="edadHelp" required="true">
                <?php if (isset($errores['passwordrepetida'])): ?> <div class="text-danger"><?php echo htmlspecialchars($errores['passwordrepetida']); ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <a class="btn btn-primary" href="<?=BASE_URL?>Dashboard/index">Cancelar</a>

        </form>

    </div>
</div>