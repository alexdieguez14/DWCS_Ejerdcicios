<?php
include_once "acceso_datos.php";
if (isset($_GET["id"])) {
    $v = getVideojuego($_GET["id"]);
    var_dump($v);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar </title>
</head>

<body>


</body>

</html>