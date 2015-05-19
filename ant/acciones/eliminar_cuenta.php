<?php


include_once '../config/configuracion.php';

include_once '../funciones/usuario.php';
include_once '../funciones/login.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/otras.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEliminarCuenta;
    
    $usuario = $_SESSION["usr"];
    $persona = $_GET["u"];
    $tipo = $_GET["t"];
    $nivel = getNivelUsuario($usuario);
    if($nivel==3){
        $nivel = getNivelUsuario($persona);
        if($nivel<3){

            if($tipo==1){
                deshabilitarUsuario($persona);
                echo "Deshabilitado";
            }elseif($tipo==2){
                //eliminacionTotalUsuario($persona);
                echo "Eliminado";
            }

            if($_SESSION["usr"]==$usuario){
                unset($_SESSION["usr"]);
            }
            $_SESSION["exi"] = 1;
        }else{
            echo "No se puede eliminar el usuario";
            $_SESSION["exi"] = 0;
        }
    }else{
        $_SESSION["exi"] = -1;
    }
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>

