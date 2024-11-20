<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("pagina_inicio.html");
    exit;
} else {
    // Mostrar contenido solo visible para usuarios registrados
    echo "¡Bienvenido! " . $_SESSION["usuario"];
    setcookie("prueba","something from somewhere",time()+35,"/Vsc%20php/login_mejorado%20php/logged.php");
    echo $_COOKIE['prueba'];
    // ...
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>logged</title>
</head>
<body>

    <span> </span>
    <div class="welcome video" >
    
    </div>
    <<p><a href="controlsesiones.php">CERRAR SESION</a></p>


    
</body>
</html>




