<?php


include_once '../config/configuracion.php';
include_once '../funciones/menciones_comentarios.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/muro.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEnviarComentario;
    $id = $_POST["id"];
    $usuario = $_SESSION["usr"];
    
    
    $posicionSiguiente = getPosicionSiguienteComentario($id);
    $_SESSION["acc"] .= "pub$id|pos$posicionSiguiente";
    

    $cuerpo = htmlspecialchars( nl2br($_POST["cuerpo"]));
    $cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);


    $_SESSION["exi"] = 1;

    enviarComentario($usuario, $id , $cuerpo, $posicionSiguiente);
    addComentarioMuro($usuario, $id, $posicionSiguiente);
    
    
    
    enviarMencionesComentario($id, $cuerpo, $posicionSiguiente);

    
    echo "Comentario enviado";
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}



?>