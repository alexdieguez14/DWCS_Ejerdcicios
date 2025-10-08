<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar </title>
</head>

<body>
    <!-- Al parametrizar el action de esta forma mantenemos el id al hacer el post. -->
    <form action="?id=<?= $v->getId() ?>" method="POST">
        <label for="nombre">Nombre</label>
        <!-- Asignamos el valor actual a todos los input -->
        <input type="text" name="nombre" required ><br>
        <label for="plataforma">Plataforma</label>
        <input type="text" name="plataforma" required ><br>
        <label for="lanzamiento">Año de lanzamiento</label>
        <input type="number" name="lanzamiento" required ><br>
        <label for="genero">Género</label>
        <input type="text" name="genero"><br>
        <button type="submit">Guardar</button>
        <a href="listar.php">Cancelar</a>
    </form>

</body>

</html>