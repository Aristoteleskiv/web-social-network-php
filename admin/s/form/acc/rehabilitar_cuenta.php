<?php


include_once '../../../../conf/conf.php';

include_once '../../../../conf/sesion.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/login.php';
include_once '../../../../func/seguimiento.php';
include_once '../../../../func/otras.php';


$nivel = 4;
    $usuario = $_SESSION["usr"];
    
    $user = $_POST["nick"];
    $password = $_POST["pass"];
    $passmd5 = md5($password);
    
    $nivelUsuario = getNivelUsuario($usuario);
    if($nivelUsuario==3){
            if(comprobarSiUsuarioExiste($user)){
                if(comprobarSiUsuarioDeshabilitado($user)){
                    if(validarPassword($password)){
                         rehabilitarUsuario($user, $passmd5);
                        echo "Usuario restaurado";
                    }else{
                        echo "La contraseña introducida no es correcta. Debe tener entre 6 y 40 caracteres.";
                    }
                }else{
                    echo "El usuario introducido no está deshabilitado.";
                }
            }else{
                echo "El usuario introducido no existe.";
            }
        
        
    }else{
        echo "Error";
    }
    
       
    
    
//    if($nivel==3){
//        $nivel = getNivelUsuario($persona);
//        if($nivel<3){
//
//            if($tipo==1){
//                //deshabilitarUsuario($persona);
//                echo "Deshabilitado";
//            }elseif($tipo==2){
//                //eliminacionTotalUsuario($persona);
//                echo "Eliminado";
//            }
//
//            if($_SESSION["usr"]==$usuario){
//                //unset($_SESSION["usr"]);
//                
//            }
//            
//        }else{
//            echo "No se puede eliminar el usuario";
//            
//        }
//    }else{
//        
//    }
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

