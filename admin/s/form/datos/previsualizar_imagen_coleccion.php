<?php

include_once '../../../../conf/conf.php';
include_once '../../../../conf/sesion.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/publicaciones.php';

//session_start();

$usuario = $_SESSION["usr"];
//if(isset($_SESSION["usr"]) ){
    
    //$usuario = $_SESSION["usr"];

$nivelUsuario = getNivelUsuario($usuario);
$nivel = $_GET["n"];
if($nivelUsuario == 3){
    $imagen = $_POST["imagen"];
    $dir = 'images/colecciones/';


    $salida = '<img src="' . $dir . $imagen . '">';
    $salida = subirImagenesDeFoolder($salida, $nivel);
    echo $salida;
}
    
    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}
