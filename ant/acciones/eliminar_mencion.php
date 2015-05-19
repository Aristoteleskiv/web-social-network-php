<?php

include_once '../config/configuracion.php';
include_once '../funciones/menciones_comentarios.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEliminarMencion;
    
    $id = $_GET["i"];
    $usuario = $_SESSION["usr"];
    if(comprobarSiMencionEsDeUsuario($id, $usuario)){
        eliminarMencion($id, $usuario);
        echo 'Mencion eliminada!';

        $_SESSION["exi"] = 1;
    }else{

        $_SESSION["exi"] = 0;
        echo "Error. ";
    }
    
   
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}


?>

