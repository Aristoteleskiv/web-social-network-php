<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/usuario.php';
include_once '../func/login.php';
include_once '../func/seguimiento.php';

$usuario = $_SESSION["usr"];
$nivel = 1;


if($usuario!=null){    

    $correo = $_POST["email"];
    $codRecarga = "<script>setTimeout( function(){ location.reload(); }, 2000);</script>";
    $correoAntiguo = getEmailUsuario($usuario);
    if($correo==$correoAntiguo){
        echo '<b>'. $correo . ' | Mismo email!</b>' . $codRecarga;

    }else{

        $existe = comprobarSiMailExiste_Login($correo);
        if(!$existe){

            editarEmailUsuario($usuario, $correo);
            editarEstadoUsuario($usuario, 0);
            echo '<b>'. $correo . ' | Email actualizado!</b>' . $codRecarga;
        }else{
            echo '<b>'. $correo . ' | Cogido ya por otro usuario!</b>' . $codRecarga;

        } 
    }
    
}


?>

