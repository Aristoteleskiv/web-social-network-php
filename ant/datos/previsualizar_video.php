<?php

include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        $ref = $_POST["referencia"];

        $url = '//www.youtube.com/embed/' . $ref;
        $salida = '<iframe width="620" height="465" src="' . $url . '" frameborder="0" allowfullscreen></iframe>';


        echo $salida;
    }

    
}else{
    echo '<script>document.location="index.php"</script>';
}


