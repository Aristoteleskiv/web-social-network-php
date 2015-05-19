<?php

include_once '../conf/conf.php';
include_once '../func/notificaciones.php';
include_once '../func/seguimiento.php';
include_once '../conf/sesion.php';


//if(isset($_SESSION["usr"]) ){
 $usuario = $_SESSION["usr"];
$nivel = 1;   
    
    //$_SESSION["acc"] = $accEnviarNotificacionError;
if($usuario!=null){
   

    $id = $_POST["id"];
    $cadena = $estPublicacion . "pub" . $id;
    
        
    
    
    $descripcion = $_POST["descripcion"];
    notificacionErrorProblema($usuario, $id, $descripcion);
    echo 'Notificacion enviada! Gracias!';
    //$_SESSION["exi"] = 1;
        
}   
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}










   

?>

