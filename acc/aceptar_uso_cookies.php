<?php




include_once '../conf/config.php';
include_once '../func/cookies.php';
include_once '../func/seguimiento.php';
include_once '../func/otras.php';
session_start();


//if(isset($_SESSION["usr"]) ){
    //$_SESSION["acc"] = $accAceptarCookies;
    $usuario = $_SESSION["usr"];
    
    //ponemos la cookie para 15 dias
    //crearCookieAceptarCookies($usuario);
    
    
    //$_SESSION["exi"] = 1;
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//    
    
    
////}else{
 //   echo '<script>document.location="../index.php"</script>';
//}
?>


