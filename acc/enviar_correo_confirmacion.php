<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/usuario.php';
include_once '../func/login.php';
include_once '../func/otras.php';
include_once '../func/seguimiento.php';


$usuario = $_SESSION["usr"];
$nivel = 1;
//if(isset($_SESSION["usr"]) ){
    
   
if($usuario!=null){
    

    $correo = getEmailUsuario($usuario);
    generarClaveConfirmacionEmail($usuario, $correo);
    

}


//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}


?>

