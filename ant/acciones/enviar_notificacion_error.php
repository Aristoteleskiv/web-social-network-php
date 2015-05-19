<?php

include_once '../config/configuracion.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $_SESSION["acc"] = $accEnviarNotificacionError;
    $id = $_POST["id"];
    $cadena = $estPublicacion . "pub" . $id;
    
        
    $usuario = $_SESSION["usr"];
    $descripcion = $_POST["descripcion"];
    notificacionErrorProblema($usuario, $id, $descripcion);
    echo 'Notificacion enviada! Gracias!';
    $_SESSION["exi"] = 1;
        
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
    
}else{
    echo '<script>document.location="../index.php"</script>';
}










   

?>

