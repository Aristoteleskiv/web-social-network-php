<!DOCTYPE html>

<?php
include_once '../conf/conf.php';
include_once '../func/notificaciones.php';
include_once '../func/usuario.php';
include_once '../func/seguimiento.php';
include_once '../conf/sesion.php';


//if(isset($_SESSION["usr"]) ){

$usuario = $_SESSION["usr"];
$nivel = 1;

if($usuario!=null){
    $id = $_GET["i"];
    $amigo = getNombreUsuario($id);
    $estadoAmistad = getEstadoAmistad($usuario, $amigo);
    if($estadoAmistad==0){
        solicitudAmistad($usuario, $amigo);
        echo "Solicitud enviada!" ;

    }else{
        echo "Ha habido un error.";

    }
}        
        
  //  registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
  //          $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
//}else{
 //   echo '<script>document.location="../index.php"</script>';
//} 
        
?>
