<?php

include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';
include_once '../funciones/login.php';
include_once '../funciones/seguimiento.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accCambiarMail;
    
    
    
    
    $usuario = $_SESSION["usr"];
    $correo = $_POST["email"];

    $correoAntiguo = getEmailUsuario($usuario);
    if($correo==$correoAntiguo){
        echo '<b>'. $correo . ' | Mismo email!</b>';
        $_SESSION["acc"] .= "$correoAntiguo|$correo";
        $_SESSION["exi"] = 0;
    }else{

        $existe = comprobarSiMailExiste_Login($correo);

        if(!$existe){
            editarEmail($usuario, $correo);
            editarEstado($usuario, 0);
            echo '<b>'. $correo . ' | Email actualizado!</b><script>$("#divEstadoDeCuentaDeCorreo").html("No confirmado");</script>';

            $_SESSION["acc"] .= "$correoAntiguo|$correo";
            $_SESSION["exi"] = 1;
        }else{
            echo '<b>'. $correo . ' | Cogido ya por otro usuario!</b>';
            $_SESSION["acc"] .= "$correoAntiguo|$correo";
            $_SESSION["exi"] = 0;
        } 
    }
    
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}


?>

