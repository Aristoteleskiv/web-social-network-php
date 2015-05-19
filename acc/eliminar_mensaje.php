<?php

include_once '../conf/conf.php';
include_once '../func/mensajes.php';
include_once '../conf/sesion.php';
//include_once '../func/seguimiento.php';
//session_start();

$usuario = $_SESSION["usr"];
$nivel = 1;
//if(isset($_SESSION["usr"]) ){
if($usuario!=null){
    //$_SESSION["acc"] = $accEliminarMensaje;
    $salida = "1";
    $id = $_POST["id"];
    //$_SESSION["acc"] .= $id; 
    
    if(comprobarSiMensajeEsDeUsuario($id, $usuario)){
         eliminarMensaje($usuario, $id);
         //$_SESSION["exi"] = 1;
    }else{
        $salida = "0";
        //$_SESSION["exi"] = 0;
    }
    return $salida;

 }       
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}


?>

