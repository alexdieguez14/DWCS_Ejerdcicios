<?php
    function generarNumeros(int $nivel){
        $numeros = [];
        for($i=0; $i<$nivel;$i++){

            $numeros[] = rand(1,4);
        }

        return $numeros;
    }

    function comprobarNumeros($in, $goal){
        return $in === $goal;
    }

    // Numeros que introduce el usuario.
    $numsIn = $_POST['in_nums']??"";
    //Numeros generados
    $nums = $_POST['nums']??"";
    $nivel = $_POST['nivel']??0;
    
    $jugando = comprobarNumeros(explode("-",$numsIn), explode("-",$nums));
    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simón dice</title>
    <style>
        .hidden{
            display: none;
        }
    </style>

    <script>
        function ocultarNumero() {
            setTimeout(
                function(){
                    document.getElementById('numeros').classList.add('hidden');
                    document.getElementById('formulario').classList.remove('hidden');
                }
                , 3000
            );
        }
    </script>
</head>
<body onload="ocultarNumero()">
   <h1>Simón dice</h1>
   <!-- Sección de números -->
    <?php if($jugando): ?>
    <div id="numeros">
        <h2>Memoriza estos números en orden</h2>
        <?php
            $nivel++;
            $nums = generarNumeros($nivel);
            echo  implode("-",$nums);
        ?>
    </div>
    <div id="formulario" class="hidden">
        <form action="" method="post">
            <label for="in_nums">Números</label><br>
            <input type="text" name="in_nums"><br>
            <input type="hidden" name="nums" value="<?php echo  implode("-",$nums)?>">
            <input type="hidden" name="nivel" value="<?php echo $nivel;?>">
            <button type="submit">Comprobar</button>
        </form>
    </div>
    <?php else: ?>
    <div id="resultado">
        Has perdido
    </div>
    <?php endif; ?>

</body>
</html>