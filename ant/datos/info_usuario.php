<?php


include_once '../config/configuracion.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/usuario.php';
include_once '../clases/amigo.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/otras.php';
include_once '../funciones/muro.php';
include_once '../clases/muro.php';
include_once '../funciones/menciones_comentarios.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/login.php';




session_start();


if(isset($_SESSION["usr"]) ){
    
    
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel==3){
        $persona = $_GET["u"];

        $elemento = new AmigoMuro($usuario, $persona);
        echo $elemento->getHTML();
    }
    
    
    
    
    
}else{
    echo '<script>document.location="index.php"</script>';
    
}







?>
