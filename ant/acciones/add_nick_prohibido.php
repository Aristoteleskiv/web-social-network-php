<?php




include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/usuario.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accAddNickProhibido;
    $usuario = $_SESSION["usr"];
    
  
        
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){

        $nick = $_POST["nick"];
        $_SESSION["exi"] = 1;
        addNickProhibido($nick);
        echo "Nick añadido a la lista";
    }else{
        $_SESSION["exi"] = 0;
    }

    $_SESSION["acc"] .= $nick;
   
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>