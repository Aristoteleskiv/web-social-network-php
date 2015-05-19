<?php

include_once '../conf/conf.php';
include_once '../func/noticias.php';
include_once '../func/seguimiento.php';
include_once '../func/usuario.php';
//session_start();
include_once '../conf/sesion.php';

//if(isset($_SESSION["usr"]) ){
$usuario = $_SESSION["usr"];
$nivel = 1;
    //$_SESSION["acc"] = $accMarcarCerradaNoticia;
    
 if($usuario!=null){   
    
    
    $id = $_POST["id"];
    
    $tipo = getTipoNoticia($id);
    
    if($tipo==4){
        actualizarAceptacionTerminosYCondiciones($usuario);
    }
    $salida = marcarCerradoNoticia($id, $usuario);
   
}    
    //$_SESSION["acc"] .= $id ;
    //$_SESSION["exi"] = 1;
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>
