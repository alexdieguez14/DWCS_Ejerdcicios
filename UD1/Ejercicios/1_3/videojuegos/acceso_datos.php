<?php
include_once "videojuego.php";
define("DB_DSN", "mysql:host=mariadb;dbname=videoteca");
define("DB_USER", "root");
define("DB_PASS", "bitnami");
function getConnection()
{
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $th) {
        die("Error de conexion con la BD" . $th->getMessage());
    }

    return $db;
}

function getVideojuego(int $id): Videojuego|false
{
    $sql = "SELECT id, anio_lanzamiento, genero, nombre, plataforma FROM videojuegos WHERE id = $id";
    $db = getConnection();
    $statement = $db->query($sql);
    $resultado = $statement->fetch();
    $videojuego = false;
    if ($resultado) {
        $videojuego = new Videojuego();
        $videojuego->setId($resultado["id"])
            ->setNombre($resultado["nombre"])
            ->setPlataforma($resultado["plataforma"])
            ->setLanzamiento($resultado["anio_lanzamiento"])
            ->setGenero($resultado["genero"]);
    }

    $statement->closeCursor();
    $db = null;
    return $videojuego;
}

function getVideojuegos($order = null): array
{
    $sql = "SELECT id, anio_lanzamiento, genero, nombre, plataforma FROM videojuegos";
    if(isset($order)){
        $sql .= " ORDER BY $order ASC";
    }
    
    $db = getConnection();
    $statement = $db->query($sql);

    $videojuegos = [];
    // while($resultado = $statement->fetch()){

    // }
    foreach ($statement as $resultado) {
        $videojuego = new Videojuego();
        $videojuego->setId($resultado["id"])
            ->setNombre($resultado["nombre"])
            ->setPlataforma($resultado["plataforma"])
            ->setLanzamiento($resultado["anio_lanzamiento"])
            ->setGenero($resultado["genero"]);
        $videojuegos[] = $videojuego;
    }


    $statement->closeCursor();
    $db = null;
    return $videojuegos;
}

function addVideojuego(Videojuego $v): bool
{
    if ($v->getGenero() != null) {
        $sql = "INSERT INTO videojuegos(nombre, plataforma, anio_lanzamiento, genero) 
                VALUES('" . $v->getNombre() . "','" . $v->getPlataforma() . "','" . $v->getLanzamiento() . "','" . $v->getGenero() . "')";
    } else {
        $sql = "INSERT INTO videojuegos(nombre, plataforma, anio_lanzamiento) 
                VALUES('" . $v->getNombre() . "','" . $v->getPlataforma() . "','" . $v->getLanzamiento() . "')";
    }

    $db = getConnection();
    $resultado = $db->exec($sql);
    $db = null;

    return $resultado != false;
}

function updateVideojuego(Videojuego $v): bool
{
    if ($v->getGenero() != null) {
        $sql = "UPDATE videojuegos 
        SET nombre='" . $v->getNombre() . "',plataforma='" . $v->getPlataforma() . "',anio_lanzamiento='" . $v->getLanzamiento() . "',genero='" . $v->getGenero() . "' WHERE id=" . $v->getId();
    } else {
         $sql = "UPDATE videojuegos 
        SET nombre='" . $v->getNombre() . "',plataforma='" . $v->getPlataforma() . "',anio_lanzamiento='" . $v->getLanzamiento() . " WHERE id=" . $v->getId();
    }

    $db = getConnection();
    $resultado = $db->exec($sql);
    $db = null;

    return $resultado != false;
}

function deleteVideojuego(int $id): bool
{
    $sql = "DELETE FROM videojuegos WHERE id = $id";

    $db = getConnection();
    $resultado = $db->exec($sql);
    $db = null;

    return $resultado != false;

}


// $v = new Videojuego();
// $v->setNombre("Modificado")
//             ->setPlataforma("test")
//             ->setLanzamiento(1923)
//             ->setGenero("test")
//             ->setId(32);
// var_dump(updateVideojuego($v));

