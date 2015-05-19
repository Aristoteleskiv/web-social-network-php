<?php




include_once '../../../../conf/conf.php';
include_once '../../../../func/login.php';
include_once '../../../../func/usuario.php';
include_once '../../../../conf/sesion.php';
//include_once '../func/seguimiento.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){

    //$_SESSION["acc"] = $accEliminarNickProhibido;
    $usuario = $_SESSION["usr"];
    
    //$usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);

    if($nivelUsuario == 3){

        $id = $_POST["id"];
        $nick = getNickProhibido($id);  
        eliminarNickProhibido($id);
        echo "Nick eliminado de la lista";

        //$_SESSION["exi"] = 1;
    }else{
        //$_SESSION["exi"] = 0;
    }
    
    
    //$_SESSION["acc"] .= $nick ;
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>