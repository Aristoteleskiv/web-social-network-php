<?php


include_once '../conf/conf.php';

include_once '../conf/sesion.php';
include_once '../func/usuario.php';
include_once '../func/login.php';
include_once '../func/seguimiento.php';
include_once '../func/otras.php';

$usuario = $_SESSION["usr"];
$nivel = 1;

//if(isset($_SESSION["usr"]) ){
if($usuario!=null){
    
    $password = $_POST["pass"];
    $passmd5 = md5($password);
    
    //$nivel = getNivelUsuario($usuario);
    $codRecarga = "<script>setTimeout( function(){ location.reload(); }, 15000);</script>";
    $codRecarga2 = "<script>setTimeout( function(){ location.reload(); }, 2000);</script>";
    if(comprobarUsuarioPassword($usuario, $passmd5)){
        
        deshabilitarUsuario($usuario);
        echo "Se procederá a eliminar la cuenta. En unos instantes se le redirigirá a la página principal. Su usuario será deshabilitado para futuros usos. Gracias y un saludo." . $codRecarga ;
        unset($_SESSION["usr"]);

    }else{
        echo "La contraseña introducida es incorrecta." . $codRecarga2;
    }
 }      
    
    
?>

