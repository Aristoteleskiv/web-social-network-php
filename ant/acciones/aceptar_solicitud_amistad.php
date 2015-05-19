<?php




include_once '../config/configuracion.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/muro.php';
include_once '../funciones/usuario.php';
session_start();


if(isset($_SESSION["usr"]) ){
        $_SESSION["acc"] = $accAceptarSolicitudAmistad;
    
   
    
        $usuario = $_SESSION["usr"];
        $idUsuario = $_GET["i"];
        $idNotificacion = $_GET["in"];
            
        $comprobarSolicitud = comprobarIDSolicitudAmistadUsuario($idNotificacion, $usuario);
        
        $solicitante = getSolicitanteSolicitudAmistad($idNotificacion);
        
        $solicitante2 = getNombreUsuario($idUsuario);
        
        if($comprobarSolicitud AND $solicitante==$solicitante2){
            
            
            aceptarSolicitudAmistad($usuario, $solicitante, $idNotificacion);
            addAmistadMuro($usuario, $solicitante);
            addAmistadMuro($solicitante, $usuario);
            
            echo "Solicitud aceptada!";
            $_SESSION["acc"] .= $solicitante;
            $_SESSION["exi"] = 1;
        }else{
            echo "Error.";
            $_SESSION["exi"] = 0;
        }
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>


