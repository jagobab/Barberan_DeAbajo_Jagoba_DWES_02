<?php 
include "usuariosCoches.php";

    //Duplico el array de POST para ir eliminando los datos que esten mal y solo imprimir los que estan bien.
    $campos = $_POST;

    //Creo un array donde guardar los fallos que vaya cometiendo el usuario para luego imprimirlos por pantalla
    $fallos = array();
    
    //Comprobar si ha metido el nombre
    if (empty($_POST["nombre"])) {
        $fallos ["nombre"] = "no has puesto nombre";
        unset($campos["nombre"]);
    }
    //Comprobar si ha metido el apellido
    if (empty($_POST["apellido"])) {
        $fallos["apellido"] = "no has puesto apellido";
        unset($campos["apellido"]);
    }

    //Funcion para validar el dni
    function validarDNI($dni) {
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $numero = substr($dni, 0, -1);
        $letra = strtoupper(substr($dni, -1));
        if (is_numeric($numero) && $letra == $letras[$numero % 23]) {
            return true;
        }
        return false;
    }
    //Comprobar si el dni es correcto o no y si no es correcto agregarlo a la lista de fallos
    $comprobarDNI = validarDNI($_POST["dni"]);
    if(!$comprobarDNI){
        $fallos["dni"] = "Has introducido un dni incorrecto";
        unset($campos["dni"]);
    }

    //Pillamos el dni del form y en principio asumimos que no existe hasta que lo comprobemos
    $usuarioDni = $_POST["dni"];
    $usuarioExiste = false;
    
    //Comprobar si el usuario existe en la base de datos
    foreach (USUARIOS as $usuario) {
        if($usuario["dni"] === $usuarioDni){
            $usuarioExiste = true;
        }
    }

    //Si no existe lo metemos a la lista de fallos
    if(!$usuarioExiste){
        $fallos["existe"] = "El usuario introducido no existe en nuestra base de datos";
        unset($campos["dni"]);
    }

    //creamos variables para las fechas para poder comprobarlas
    $fechaIntroducida = $_POST["fechaInicio"];
    $fechaActual = date("Y-m-d");

    //Si la fecha que ha metido el usuario es anterior a hoy guardamos el error. si es hoy o posterior lo damos por bueno
    if($fechaIntroducida < $fechaActual){
        $fallos["fecha"] = "La fecha introducida esta mal";
        unset($campos["fechaInicio"]);
    }

    //Comprobamos que la duracion del alquiler este entre 1 dia y 30
    if($_POST["duracion"] < 1 || $_POST["duracion"] > 30){
        $fallos["duracion"] = "La duracion del alquiler no está permitida.";
        unset($campos["duracion"]);
    }

    //Comprobamos si el coche está disponible:
    $cocheElegido = $_POST["modelo"];
    $idModelo = 0;
    $cocheDisponible = false;
    foreach($coches as $coche){
        if($coche["modelo"] == $cocheElegido){
            $cocheDisponible = $coche["disponible"];
            $idModelo = $coche["id"];
        }
    }

    if($cocheDisponible == false){
        $fallos["disponible"] = "El coche no esta disponible en estos momentos.";
        unset($campos["modelo"]);
    }

    //Compruebo si el array de los fallos tiene alguno y si tiene imprimo una cosa y si no otra.
    if(count($fallos) > 0){
        foreach($fallos as $f){
            echo "<p style='color:red'>{$f}</p>";
        }
        mostrarDatosCorrectos($campos);
    } else {
        echo " <h1> Gracias por tu reserva " .$_POST["nombre"] ." " .$_POST["apellido"] .". La reserva se ha confirmado </h1> <br>";
        echo "<p style='font-size: 20px; color: green'>El coche que has elegido es el siguiente: </p><br>";
        echo "<img src='images/{$idModelo}.jpg'>";
    }

    
function mostrarDatosCorrectos($campos){
    foreach ($campos as $c => $value) {
        $pintar = "<p style='color:green;'>";
        switch ($c) {
            case 'nombre':
                echo "{$pintar} Has puesto bien el nombre </p>";
                break;
            case 'apellido':
                echo "{$pintar} Has puesto bien el apellido </p>";
                break;
            case 'dni':
                echo "{$pintar} Has puesto bien el dni </p>";
                break;
            case 'modelo':
                echo "{$pintar} El coche que has elegido está disponible</p>";
                break;
            case 'fechaInicio':
                echo "{$pintar} La fecha introducida es correcta </p>";
                break;
            case 'duracion':
                echo "{$pintar} La duracion introducida es correcta. </p>";
                break;
        }
    }
}
?>