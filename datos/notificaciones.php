<?php




include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/notificaciones.php';
include_once '../func/mensajes.php';
include_once '../func/menciones_comentarios.php';

$nivel = 1;
$usuario = $_SESSION["usr"];
if($usuario==null){
    echo codigoRedireccionHome($nivel);
}

if($usuario==null){
    echo codigoRedireccionHome($nivel);
}else{
    
    $t = $_POST["t"];


    switch ($t) {
        case 1:
            $num = getNumeroNotificacionesNoVistas($usuario);
            
            break;
        case 2:
            $num = getNumeroMensajesNoVistos($usuario);
            
            break;
        case 3:
            $num = getNumeroMencionesNoVistas($usuario);
            
            break;

        default:
            break;
    }
    


    if($num>9999){
        $tipo = "t";
    }else{
        $tipo = "n";
    }

    if($tipo==n){
        if($num>0){
            echo  $num ;
        }
    }else{
        echo  "...";
    }
    
}

?>