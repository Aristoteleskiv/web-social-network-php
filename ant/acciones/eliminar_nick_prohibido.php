<?php




include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/usuario.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){

    $_SESSION["acc"] = $accEliminarNickProhibido;
    
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);

    if($nivel == 3){

        $id = $_POST["id"];
        $nick = getNickProhibido($id);  
        eliminarNickProhibido($id);
        echo "Nick eliminado de la lista";

        $_SESSION["exi"] = 1;
    }else{
        $_SESSION["exi"] = 0;
    }
    
    
    $_SESSION["acc"] .= $nick ;
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>