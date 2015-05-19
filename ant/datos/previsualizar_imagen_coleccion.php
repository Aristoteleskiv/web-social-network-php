<?php

include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        $imagen = $_POST["imagen"];
        $dir = 'images/colecciones/';


        $salida = '<img src="' . $dir . $imagen . '">';

        echo $salida;
    }
    
    
}else{
    echo '<script>document.location="index.php"</script>';
}
