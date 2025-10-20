<?php
define("DSN", "mysql:host=mariadb;dbname=numero_secreto");
define("DB_USER", "root");
define("DB_PASS", "bitnami");

class Jugador
{
    public $id;
    public $nombre;
}

class Partida
{
    public $id;
    public $intentos;
    public $numero;
    public $segundos;
    public $jugador;
}

function getConnection()
{
    try {
        $db = new PDO(DSN, DB_USER, DB_PASS);
    } catch (PDOException $th) {
        die("Error de conexion con la BD: " . $th->getMessage());
    }

    return $db;
}

/**
 * Devuelve todas las partidas
 * @return array
 */
function getPartidas()
{
    $partidas = [];
    $sql = "SELECT p.id, 
            segundos,
            numero,
            intentos,
            jugador_id, j.nombre as jugador_nombre
            FROM partida p INNER JOIN jugador j ON p.jugador_id = j.id";

    try {
        $db = getConnection();
        $stm = $db->query($sql);

        foreach ($stm as $row) {
            $p = new Partida();
            $p->id = $row['id'];
            $p->segundos = $row['segundos'];
            $p->intentos = $row['intentos'];
            $p->numero = $row['numero'];
            $j = new Jugador();
            $j->id = $row['jugador_id'];
            $j->nombre = $row['jugador_nombre'];
            $p->jugador = $j;
            $partidas[] = $p;
        }
    } catch (PDOException $th) {
        error_log($th->getMessage());
    }finally{
        $stm->closeCursor();
        $db = null;
    }


    return $partidas;
}

/**
 * Devuelve las partidas de un jugador
 * @param mixed $jugadorId
 * @return array
 */
function getPartidasJugador(Jugador $jugador)
{
    $partidas = [];
    $sql = "SELECT p.id, 
            segundos,
            numero,
            intentos,
            jugador_id, j.nombre as jugador_nombre
            FROM partida p INNER JOIN jugador j ON p.jugador_id = j.id
            WHERE j.nombre = :nombre_jugador";
    try {
        $db = getConnection();
        $stm = $db->prepare($sql);
        //Preparar la consulta.
        $stm->bindValue('nombre_jugador',$jugador->nombre,PDO::PARAM_STR);
        $stm->execute();
        foreach ($stm as $row) {
            $p = new Partida();
            $p->id = $row['id'];
            $p->segundos = $row['segundos'];
            $p->intentos = $row['intentos'];
            $p->numero = $row['numero'];
            $j = new Jugador();
            $j->id = $row['jugador_id'];
            $j->nombre = $row['jugador_nombre'];
            $p->jugador = $j;
            $partidas[] = $p;
        }
    } catch (PDOException $th) {
        error_log($th->getMessage());
    }finally{
        $stm->closeCursor();
        $db = null;
    }


    return $partidas;
}

/**
 * Agrega, si puede, un jugador.
 * @param Jugador $jugador Jugador a dar de alta
 * @return bool Verdadero si lo inserta falso en caso contrario.
 */
function addJugador(Jugador $jugador): bool
{

    $sql = "INSERT INTO jugador (nombre) VALUES(:nombre)";
    try {
        $db = getConnection();
        $stm = $db->prepare($sql);
        $stm->bindValue('nombre', $jugador->nombre);
    } catch (\Throwable $th) {
        error_log($th->getMessage());
    }finally{
        $db = null;
    }
}