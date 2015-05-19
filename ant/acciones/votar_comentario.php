<?php

include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/seguimiento.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accVotarComentario;
    $id = $_POST["id"];
    $voto = $_POST["voto"];
    $idPublicacion = $_POST["id"];
    $posicion = $_POST["posicion"];
    $_SESSION["acc"] .= "pu$idPublicacion|po$posicion|vo$voto";
    
    
   
        
    $usuario = $_SESSION["usr"];
    votar($usuario, $idPublicacion, $posicion, $voto);
    $_SESSION["exi"] = 1;
        
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}




 
        
        
       
    


?>

