<?php

include_once '../conf/conf.php';
include_once '../func/publicaciones.php';
include_once '../func/seguimiento.php';
include_once '../conf/sesion.php';


//if(isset($_SESSION["usr"]) ){
$usuario = $_SESSION["usr"];
$nivel = 1;   

if($usuario!=null){
        //$_SESSION["acc"] = $accGuardarParaMasTarde;
        $idPublicacion = $_POST["id"];
        
        $nivel = $_POST["nivel"];
       
        //$usuario = $_SESSION["usr"];

        $salida = guardarParaMasTarde($usuario, $idPublicacion);
        if($salida){

            $salida = '<img class="imagen-menus-publicacion-no-opaco" src="images/header/guardado_later.png">';
        }else{

            $salida = '<img class="imagen-menus-publicacion" src="images/header/guardado_later.png">';
        }
        $salida = subirImagenesDeFoolder($salida, $nivel);
        echo $salida;
        //$_SESSION["acc"] .= $idPublicacion;
        //$_SESSION["exi"] = 1;
}        
        
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}

?>

