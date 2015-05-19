<?php

include_once '../conf/conf.php';
include_once '../func/notificaciones.php';
include_once '../conf/sesion.php';
//include_once '../func/seguimiento.php';
include_once '../func/muro.php';
include_once '../func/usuario.php';
//session_start();

$usuario = $_SESSION["usr"];
$nivel = 1;
//if(isset($_SESSION["usr"]) ){
//        $_SESSION["acc"] = $accAceptarSolicitudAmistad;
if($usuario!=null){    

    //$usuario = $_SESSION["usr"];
    
    $idUsuario = $_POST["idU"];
    $idNotificacion = $_POST["id"];
    
    $comprobarSolicitud = comprobarIDSolicitudAmistadUsuario($idNotificacion, $usuario);
    $solicitante = getSolicitanteSolicitudAmistad($idNotificacion);
    $solicitante2 = getNombreUsuario($idUsuario);
    
    if($comprobarSolicitud AND $solicitante===$solicitante2){

        aceptarSolicitudAmistad($usuario, $solicitante, $idNotificacion);
        addAmistadMuro($usuario, $solicitante);
        addAmistadMuro($solicitante, $usuario);
        echo "Solicitud aceptada!";
        //$_SESSION["acc"] .= $solicitante;
        //$//_SESSION["exi"] = 1;
    }else{
        echo "Error.";
        //$_SESSION["exi"] = 0;
    }
}
    
   
    //registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
    //        $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>


