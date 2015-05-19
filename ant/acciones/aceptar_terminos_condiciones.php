<?php




include_once '../config/configuracion.php';

include_once '../funciones/seguimiento.php';

include_once '../funciones/usuario.php';


session_start();


if(isset($_SESSION["usr"]) ){
        $_SESSION["acc"] = $accAceptarTerminos;
    
   
    
        $usuario = $_SESSION["usr"];
        
            
        actualizarAceptacionTerminosYCondiciones($usuario);
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>


