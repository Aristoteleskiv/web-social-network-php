<?php


include_once '../config/configuracion.php';
include_once '../funciones/mensajes.php';
include_once '../funciones/usuario.php';
include_once '../funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEnviarMensaje;
    
    
        
        $id = $_GET["i"];
        $destinatario = getNombreUsuario($id);
        $mandatario = $_SESSION["usr"];

        $_SESSION["acc"] .= $destinatario . "|";
        $cuerpo = $_GET["c"];
        
        if(sonAmigos($destinatario, $mandatario)){
            
            $cuerpo = htmlspecialchars( nl2br($cuerpo));
            $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
            
            enviarMensaje($destinatario, $mandatario, $cuerpo);
            echo 'Mensaje enviado!';
            $_SESSION["exi"] = 1;
        }else{

            echo "Error al enviar el mensaje";
            $_SESSION["exi"] = 0;
        }
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>

