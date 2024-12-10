<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASE_URL?>src/css/styles.css">

 </head>

<?php
include_once "Config/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//session_start()
?>
<body>

    <header class="header">

        <div class="contenedor">
            <div class="barra">

                <a class="logo" href="<?=BASE_URL?>Dashboard/index">
                    <h1 class="logo__nombre no-margin centrar-texto">Blog<span class="logo__bold">DeCafé</span></h1>
                </a>

                <nav class="navegacion">


                    <?php
                        if (isset($_SESSION['usuario'])): ?>

                            <a href="<?=BASE_URL?>Login/logout" class="navegacion_enlace">Bienvenido!! Logout (<?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>)</a>
                        <?php else: ?>
                            <a href="<?=BASE_URL?>Login/mostrarLoginInicio" class="navegacion_enlace">Login</a>
                            <a href="<?=BASE_URL?>Usuario/registroUsuarios" class="navegacion_enlace">Registrarse</a>
                    <?php endif; ?>

                    <form action="<?=BASE_URL?>Entrada/buscarEntradas" method="get">
                        <input id="buscar" type="text" name="buscar" placeholder="Buscar entradas" class="form-control">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

                </nav>
            </div>

        </div>

        <div class="header__texto">
            <h2 class="no-margin">Blog de café con consejos</h2>
            <p class="no-margin">Aprende de los expertos con los mejores recetas y consejos</p>

        </div>

    </header>
