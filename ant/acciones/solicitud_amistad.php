<!DOCTYPE html>

<?php
include_once '../config/configuracion.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/usuario.php';
include_once '../funciones/seguimiento.php';

session_start();


if(isset($_SESSION["usr"]) ){
       
        $_SESSION["acc"] = $estAmigos;
        
        $usuario = $_SESSION["usr"];
        $id = $_GET["i"];
        $amigo = getNombreUsuario($id);

        $estadoAmistad = getEstadoAmistad($usuario, $amigo);



        if($estadoAmistad==null){
            solicitudAmistad($usuario, $amigo);
            echo "Solicitud enviada!" ;
            $_SESSION["acc"] .= "$amigo";
            $_SESSION["exi"] = 1;
        }else{
            echo "Ha habido un error.";
            $_SESSION["acc"] .= "$amigo";
            $_SESSION["exi"] = 0;
        }
        
        
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
}else{
    echo '<script>document.location="../index.php"</script>';
} 
        
?>
