<?php

include_once '../conf/conf.php';
include_once '../func/menciones_comentarios.php';
//include_once '../func/seguimiento.php';
//session_start();
include_once '../conf/sesion.php';

//if(isset($_SESSION["usr"]) ){
$usuario = $_SESSION["usr"];
$nivel = 1;  
    
if($usuario!=null){   
    $id = $_POST["id"];
    $salida = "1";
    //$usuario = $_SESSION["usr"];
    if(comprobarSiMencionEsDeUsuario($id, $usuario)){
        eliminarMencion($id, $usuario);
        //echo 'Mencion eliminada!';
        
        //$_SESSION["exi"] = 1;
    }else{

        //$_SESSION["exi"] = 0;
        $salida = "0";
    }
    
    return $salida;
   
}    
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}


?>

