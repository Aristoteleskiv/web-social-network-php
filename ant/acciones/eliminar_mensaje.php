<?php

include_once '../config/configuracion.php';
include_once '../funciones/mensajes.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){

    $_SESSION["acc"] = $accEliminarMensaje;
        
    $id = $_GET["i"];
    $_SESSION["acc"] .= $id; 
    $usuario = $_SESSION["usr"];
    if(comprobarSiMensajeEsDeUsuario($id, $usuario)){
         eliminarMensaje($usuario, $id);
         echo 'Mensaje eliminado!';

         $_SESSION["exi"] = 1;
    }else{
        echo 'Error.';
        $_SESSION["exi"] = 0;
    }
    

        
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}


?>

