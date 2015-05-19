<?php




include_once '../../../../conf/conf.php';
include_once '../../../../func/login.php';
include_once '../../../../func/usuario.php';
//include_once '../func/seguimiento.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    //$_SESSION["acc"] = $accAddNickProhibido;
    //$usuario = $_SESSION["usr"];
    
  
        
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){

        $nick = $_POST["nick"];
        
        editarEstadoUsuario($nick, 1);
        //$_SESSION["exi"] = 1;
        //addNickProhibido($nick);
        echo "Correo confirmado";
    }else{
        //$_SESSION["exi"] = 0;
    }

    //$_SESSION["acc"] .= $nick;
   
    
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>