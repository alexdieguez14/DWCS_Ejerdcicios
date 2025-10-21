<?php
require_once "model.php";

define("COOKIE_JUEGO", "juego");

function setJuegoData(array $data)
{
    $json = json_encode($data);
    setcookie(COOKIE_JUEGO, $json, time() + 3600);
}

function getJuegoData(): ?array
{
    if (!isset($_COOKIE[COOKIE_JUEGO])) return null;
    $data = json_decode($_COOKIE[COOKIE_JUEGO], true);
    return is_array($data) ? $data : null;
}

function iniciarJuego()
{
    $data = [
        'rand' => rand(1, 1000),
        'intent' => 1,
        'inic' => time()
    ];
    setJuegoData($data);
}

function jugando(): bool
{
    $data = getJuegoData();
    return isset($data['rand'], $data['intent']);
}

function finalizarJuego()
{
    setcookie(COOKIE_JUEGO, "", time() - 3600);
}

function getIntentos()
{
    $data = getJuegoData();
    return $data['intent'] ?? false;
}

function getSegundosIniciales()
{
    $data = getJuegoData();
    return $data['inic'] ?? false;
}

function getNumAleatorio()
{
    $data = getJuegoData();
    return $data['rand'] ?? false;
}

function setIntentos($numIntentos)
{
    $data = getJuegoData();
    if (!$data) return;
    $data['intent'] = $numIntentos;
    setJuegoData($data);
}

function comprobarNumero(int $num)
{
    $rand = getNumAleatorio();
    if ($num !== $rand) {
        setIntentos(getIntentos() + 1);
    }
    return $num - $rand;
}


function registrarJugador(string $nombre)
{
    $jugador = new Jugador();
    $jugador->nombre = $nombre;
    addJugador($jugador);
    $jugador = getJugador($jugador);
    if ($jugador) {
        $data = getJuegoData() ?? [];
        $data['player'] = $jugador->id;
        setJuegoData($data);
        return true;
    }
    return false;
}

function getJugadorActual()
{
    $data = getJuegoData();
    if (!isset($data['player'])) return false;

    $jugador = new Jugador();
    $jugador->id = intval($data['player']);
    return getJugador($jugador);
}

function registrarPartida()
{
    $segundos = time() - getSegundosIniciales();
    $partida = new Partida(getNumAleatorio(), getIntentos(), $segundos, getJugadorActual());
    return addPartida($partida);
}