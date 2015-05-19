<?php




include_once '../config/configuracion.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/mensajes.php';
include_once '../funciones/menciones_comentarios.php';
session_start();


if(isset($_SESSION["usr"]) ){

    $t = $_POST["t"];
    $usuario = $_SESSION["usr"];

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
    
    
    
    
    
    if($num>99999){
        $tipo = "t";
    }else{
        $tipo = "n";
    }
    
    if($tipo==n){
        if($num>0){
            echo '<span class="numero-cantidad-menu">' . $num . '</span>';
        }
    }else{
        echo '<span class="numero-cantidad-menu">' . "..." . '</span>';
    }
        
        
        
    
    
    
}else{
   echo '<script>document.location="index.php"</script>'; 
}

?>