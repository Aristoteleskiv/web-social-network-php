<?php




include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/login.php';
include_once '../func/seguimiento.php';

$usuario = $_SESSION["usr"];
$nivel = 1;

//if((isset($_POST["hash"])) AND (isset($_POST["password"])) ){
if($usuario!=null){   
    
    
    $antiguo = md5($_POST["ant"]);    
    $nuevo1 = md5($_POST["nue1"]); 
    $nuevo2 = md5($_POST["nue2"]); 
    
    $pass = $_POST["nue1"];
    $codRecarga = "<script>setTimeout( function(){ location.reload(); }, 2000);</script>";
    if(comprobarUsuarioPassword($usuario, $antiguo)){
        if($nuevo1 == $nuevo2){
            if($nuevo1 != $antiguo){
                if(validarPassword($pass)){
                    cambiarPassword($usuario, $nuevo1);
                    echo "<b>La contraseña ha sido cambiada con éxito</b>" . $codRecarga;
                }else{
                    echo "<b>La contraseña nueva debe de contener entre 6 y 40 caracteres</b> . $codRecarga";
                }
            }else{
                echo "<b>La nueva contraseña debe ser distinta a la antigua</b> . $codRecarga";
            }
        }else{
            echo "<b>La nueva contraseña no coinciden.</b>" . $codRecarga;
        }
    }else{
        echo "<b>La contraseña antigua no coincide.</b>" . $codRecarga;
    }
    
}   


//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>


