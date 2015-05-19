<?php


include_once '../../../../conf/conf.php';
include_once '../../../../func/notificaciones.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/seguimiento.php';
//session_start();


//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarMensaje;
    
$nivel = 4;        
        $usuario = $_SESSION["usr"];
        
        $tipo = $_POST["tipo"];
        $destinatario = $_POST["destinatario"];
        $mandatario = $_POST["mandatario"];
        $idPublicacion = $_POST["idPublicacion"];
        
        $cuerpo = $_POST["cuerpo"];

        $cuerpo = htmlspecialchars( nl2br($cuerpo));
        $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
        switch ($tipo) {
            case 1:
                notificacionErrorProblema($mandatario, $idPublicacion, $cuerpo);
                break;
            case 2:
                notificacionSolicitudAmistad($destinatario, $mandatario);
                break;
            case 3:
                notificacionAceptacionSolicitudAmistad($destinatario, $mandatario);
                break;
            default:
                
                break;
        }
        echo "Notificacion enviada!";
        
        //enviarMensaje($destinatario, $mandatario, $cuerpo);
        //echo 'Mensaje enviado!';
            //$_SESSION["exi"] = 1;
        
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

