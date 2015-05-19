<?php


include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/muro.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accMarcarPublicacionRealizada;
    
    $id = $_POST["id"];
    

    
        
    $usuario = $_SESSION["usr"];


    $salida = marcarRealizadaPublicacion($usuario, $id);


    if($salida){
       echo '<img class="imagen-menus-publicacion-no-opaco" src="images/header/marcado_realizado.png">';
    }else{
        echo '<img class="imagen-menus-publicacion" src="images/header/marcado_realizado.png">';
    }

    $_SESSION["acc"] .= $id;
    $_SESSION["exi"] = 1;
        
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>