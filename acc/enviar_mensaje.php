<?php


include_once '../conf/conf.php';
include_once '../func/mensajes.php';
include_once '../func/usuario.php';
include_once '../func/seguimiento.php';
//session_start();
include_once '../conf/sesion.php';

//if(isset($_SESSION["usr"]) ){
$usuario = $_SESSION["usr"];
$nivel = 1;    
    //$_SESSION["acc"] = $accEnviarMensaje;
    
        
       
 if($usuario!=null){       
        
        $mandatario = $usuario;
        $destinatario = getNombreUsuario($_POST["id"]);
        

        //$mandatario = $_SESSION["usr"];

        //$_SESSION["acc"] .= $destinatario . "|";
        $cuerpo = $_POST["cuerpo"];
        

        $cuerpo = htmlspecialchars( nl2br($cuerpo));
        $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
        
        enviarMensaje($destinatario, $mandatario, $cuerpo);
        echo 'Mensaje enviado!';
            //$_SESSION["exi"] = 1;
        
}    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

