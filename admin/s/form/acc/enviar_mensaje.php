<?php


include_once '../../../../conf/conf.php';
include_once '../../../../func/mensajes.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/seguimiento.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarMensaje;
    
        
        $usuario = $_SESSION["usr"];
        
        
        $mandatario = $_POST["mandatario"];
        $destinatario = $_POST["destinatario"];
        

        //$mandatario = $_SESSION["usr"];

        //$_SESSION["acc"] .= $destinatario . "|";
        $cuerpo = $_POST["cuerpo"];
        

        $cuerpo = htmlspecialchars( nl2br($cuerpo));
        $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
        
        enviarMensaje($destinatario, $mandatario, $cuerpo);
        echo 'Mensaje enviado!';
            //$_SESSION["exi"] = 1;
        
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

