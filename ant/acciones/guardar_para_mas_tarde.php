<?php

include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
        $_SESSION["acc"] = $accGuardarParaMasTarde;
        $idPublicacion = $_POST["id"];
        
        
        
            
        $usuario = $_SESSION["usr"];


        $salida = guardarParaMasTarde($usuario, $idPublicacion);
        if($salida){

            echo '<img class="imagen-menus-publicacion-no-opaco" src="images/header/guardado_later.png">';
        }else{

            echo '<img class="imagen-menus-publicacion" src="images/header/guardado_later.png">';
        }

        $_SESSION["acc"] .= $idPublicacion;
        $_SESSION["exi"] = 1;
        
        
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}

?>

