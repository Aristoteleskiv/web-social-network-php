<?php


include_once '../../../../conf/conf.php';
include_once '../../../../func/menciones_comentarios.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/seguimiento.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarMensaje;
    
        
        $usuario = $_SESSION["usr"];
        
       
        $destinatario = $_POST["destinatario"];
        $mandatario = $_POST["mandatario"];
        $idPublicacion = $_POST["idPublicacion"];
        $posicion = $_POST["posicion"];
        $cuerpo = $_POST["cuerpo"];

        $cuerpo = htmlspecialchars( nl2br($cuerpo));
        $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
        
        
        enviarMencion($destinatario, $mandatario, $idPublicacion, $posicion);
        
        echo "Mencion enviada!";
        
        //enviarMensaje($destinatario, $mandatario, $cuerpo);
        //echo 'Mensaje enviado!';
            //$_SESSION["exi"] = 1;
        
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

