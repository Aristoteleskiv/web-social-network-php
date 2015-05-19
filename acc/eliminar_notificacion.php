<?php


include_once '../conf/conf.php';
include_once '../func/notificaciones.php';
include_once '../func/seguimiento.php';
include_once '../conf/sesion.php';

//session_start();

$usuario = $_SESSION["usr"];
$nivel = 1;
//if(isset($_SESSION["usr"]) ){

        //$_SESSION["acc"] = $accEliminarNotificacion;
if($usuario!=null){    
    $salida = "1";
    
    
    $tipo = $_POST["t"];

    $id = $_POST["id"];

    //$_SESSION["acc"] .= $id;

    switch ($tipo) {
        case 1:
            if(comprobarSiNotificacionSolicitudDeAmistadEsDeUsuario($id, $usuario)){

                setInvisibleNotificacionSolicitudDeAmistad($usuario, $id);
                //$_SESSION["exi"] = 1;

            }else{
                $salida =  "0";
                //$_SESSION["exi"] = 0;
            }

            break;
        case 2:
            if(comprobarSiNotificacionAceptacionSolicitudDeAmistadEsDeUsuario($id, $usuario)){
                eliminarNotificacionAceptacionSolicitudDeAmistad ($usuario, $id);
                //$_SESSION["exi"] = 1;
            }else{
                $salida =  "0";
                //$_SESSION["exi"] = 0;
            }
            break;
        case 3:


            if(comprobarSiNotificacionErrorProblemaEsDeUsuario($id, $usuario)){


                eliminarNotificacionErrorProblema ($usuario, $id);

                //$_SESSION["exi"] = 1;
            }else{
                $salida =  "0";
                //$_SESSION["exi"] = 0;
            }

            break;
        default:
            $salida =  "0";
            break;
    }
    
    echo $salida;
 }   
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>
 