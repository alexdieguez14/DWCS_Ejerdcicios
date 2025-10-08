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
    <!-- Filtros de búsqueda -->
    <fieldset>
        <legend>Filtros de búsqueda</legend>
        <!-- Envio el formulario por get para que me mantenga los parametros de ordenación de la tabla. -->
        <form action="" method="get">
            <label for="fil_nombre"></label>
            <input type="text" name="fil_nombre"><br>
            <label for="fil_plataforma"></label>
            <input type="text" name="fil_plataforma"><br>
            <label for="fil_lanzamiento"></label>
            <input type="text" name="fil_lanzamiento"><br>
            <label for="fil_genero"></label>
            <input type="text" name="fil_genero"><br>
            <button type="submit">Filtrar</button>
        </form>
    </fieldset>
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
        //Si tiene un parámetro de ordenación lo recuperamos.
        $orden = $_REQUEST["order"]??null;
        //Si tiene filtros los agregamos a un array de filtros
        $filtros = [];
        foreach($_REQUES as $param=>$value){
            if(str_starts_with($param,'fil_')){
                $filtros[$param]= $value;
            }
        }
        if(isset($_REQUEST["order"])){
            $videojuegos = getVideojuegos($filtros,$_REQUEST["order"]);
        }else{
            $videojuegos = getVideojuegos($filtros);
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