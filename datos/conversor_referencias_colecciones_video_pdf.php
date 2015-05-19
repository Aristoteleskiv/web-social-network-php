<?php

include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';
include_once '../funciones/publicaciones.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        
        $referencias = $_POST["texto"];
        
        $ref = explode(" ", $referencias);
        $salida = "";
        
        for($i=0; $i<count($ref); $i++){
            
            $refi = getIdMaterialComplementarioPublicacion ($ref[$i]);
            $salida .= $refi . " ";
        }
        
        
        

        echo $salida;
    }
    
    
}else{
    echo '<script>document.location="index.php"</script>';
}
