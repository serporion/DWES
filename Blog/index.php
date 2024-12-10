<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BLOG del Café</title>
</head>
<body>



<?php

    require_once "./Config/config.php";
    require_once "./vendor/autoload.php";
    
    use Controllers\FrontController;

    FrontController::main();

?>


</body>
</html>
