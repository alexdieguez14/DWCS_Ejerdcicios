<?php
require_once "controller.php";
if (!getJugadorActual()) {
    header("Location:access.php");
    exit;
}

if (!jugando()) {
    iniciarJuego();
} else {
    $num = $_POST['num'] ?? null;
    if (!isset($num)) {
        $error = "Falta el número.";
    } else {
        if (!filter_var($num, FILTER_VALIDATE_INT, ['options' => ["max_range" => 1000, "min_range" => 1]])) {
            $error = "Tiene que ser un número entre 1 y 1000";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego</title>
</head>
<body>
    <h1>Estoy pensando un número entre 1 y 1000</h1>
    <h2>¿Lo adivinas?</h2>

    <form action="" method="post">
        <label for="num">Número</label><br>
        <input type="number" name="num"><br>
        <?php
        if (isset($error)) {
            echo $error, "<br>";
        }
        ?>
        <button type="submit">Comprobar</button>
    </form>

    <div id="resultado">
        <?php
        if (!isset($error) && isset($num)) {
            $dif = comprobarNumero($num);
            if (getIntentos() == MAX_INTENTS && $dif !== 0) {
                echo "Has perdido! El número era: ", getNumAleatorio(), "<br>";
                echo "<a href='index.php'>Volver a empezar</a><br>";
                echo "<a href='ranking.php'>Ver ranking</a>";
                finalizarJuego();
                exit;
            }

            if ($dif === 0) {
                echo "Enhorabuena, has acertado. El número era $num y has necesitado ", getIntentos(), " intentos.<br>";
                echo "<a href='index.php'>Volver a empezar</a><br>";
                echo "<a href='ranking.php'>Ver ranking</a>";
                registrarPartida();
                finalizarJuego();
                exit;
            } else {
                $msg = $dif > 0 ? "inferior" : "superior";
                echo "El número es $msg que $num.<br> Llevas ", getIntentos(), " intentos";
            }
        }
        ?>
    </div>
</body>
</html>
