<?php

include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';
include_once '../funciones/login.php';
include_once '../funciones/otras.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEnviarCorreoConfirmacion;
    
        
    $usuario = $_SESSION["usr"];
    $correo = getEmailUsuario($usuario);
    generarClaveConfirmacionEmail($usuario, $correo);
    $_SESSION["acc"] = $accEnviarCorreoConfirmacion;
    $_SESSION["exi"] = 1;
    
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}


?>

