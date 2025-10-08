<?php
include_once("acceso_datos.php");
//Si está entrando desde un enlace de eliminar realizamos la acción.
if (isset($_GET["eliminar"])) {
    $m = "El videojuego no se ha eliminado";

    if (deleteVideojuego($_GET['eliminar'])) {
        $m = "El videojuego se ha eliminado";

    }
    echo '<script>alert("', $m, '")</script>';
    //Esto es una redirección y nos sirve para que no se quede el parámetro eliminar en la URL
    header("Location: listar.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos</title>
</head>

<body>
    <h1>Videojuegos registrados</h1>
    <table>
        <tr>
            <th><a href="?order=nombre">Nombre</a></th>
            <th><a href="?order=plataforma">Plataforma</a></th>
            <th><a href="?order=anio_lanzamiento">Año</a></th>
            <th><a href="?order=genero">Género</a></th>
            <th><a href="">Acciones</a></th>
        </tr>
        <!-- Datos de ejemplo. Tiene que ser dinámico -->
        <?php
        if(isset($_REQUEST["order"])){
            $videojuegos = getVideojuegos($_REQUEST["order"]);
        }else{
            $videojuegos = getVideojuegos();
        }
        
        foreach ($videojuegos as $v) {
            echo "<tr>";
            echo "<td>", $v->getNombre(), "</td>";
            echo "<td>", $v->getPlataforma(), "</td>";
            echo "<td>", $v->getLanzamiento(), "</td>";
            echo "<td>", $v->getGenero() ?? '-', "</td>";
            echo "<td> <a href='?eliminar=", $v->getId(), "'>Eliminar</a><br><a href='modificar.php?id=", $v->getId(), "'>Modificar</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="crear.php">Nuevo videojuego</a>

</body>

</html>