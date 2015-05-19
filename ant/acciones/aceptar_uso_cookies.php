<?php




include_once '../config/configuracion.php';
include_once '../funciones/cookies.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/otras.php';
session_start();


if(isset($_SESSION["usr"]) ){
    $_SESSION["acc"] = $accAceptarCookies;
    $usuario = $_SESSION["usr"];
    
    //ponemos la cookie para 15 dias
    crearCookieAceptarCookies($usuario);
    
    
    $_SESSION["exi"] = 1;
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
    
    
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>


