<?php

include_once '../config/configuracion.php';
include_once '../funciones/noticias.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/usuario.php';
session_start();


if(isset($_SESSION["usr"]) ){

    $_SESSION["acc"] = $accMarcarCerradaNoticia;
    
    $usuario = $_SESSION["usr"];
    $id = $_POST["id"];
    
    $tipo = getTipoNoticia($id);
    
    if($tipo==4){
        actualizarAceptacionTerminosYCondiciones($usuario);
    }
    $salida = marcarCerradoNoticia($id, $usuario);
   
    
    $_SESSION["acc"] .= $id ;
    $_SESSION["exi"] = 1;
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>
