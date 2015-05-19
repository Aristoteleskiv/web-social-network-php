
<?php


include_once '../config/configuracion.php';
include_once '../funciones/notificaciones.php';
include_once '../funciones/seguimiento.php';

session_start();


if(isset($_SESSION["usr"]) ){

        $_SESSION["acc"] = $accEliminarNotificacion;
    
    
        $usuario = $_SESSION["usr"];
        $tipo = $_GET["t"];
        
        $id = $_GET["i"];
        
        $_SESSION["acc"] .= $id;

        switch ($tipo) {
            case 1:
                if(comprobarSiNotificacionSolicitudDeAmistadEsDeUsuario($id, $usuario)){
                    
                    setInvisibleNotificacionSolicitudDeAmistad($usuario, $id);
                    $_SESSION["exi"] = 1;
                    
                }else{
                    echo "Error.";
                    $_SESSION["exi"] = 0;
                }

                break;
            case 2:
                if(comprobarSiNotificacionAceptacionSolicitudDeAmistadEsDeUsuario($id, $usuario)){
                    eliminarNotificacionAceptacionSolicitudDeAmistad ($usuario, $id);
                    $_SESSION["exi"] = 1;
                }else{
                    echo "Error.";
                    $_SESSION["exi"] = 0;
                }
                break;
            case 3:


                if(comprobarSiNotificacionErrorProblemaEsDeUsuario($id, $usuario)){


                    eliminarNotificacionErrorProblema ($usuario, $id);

                    $_SESSION["exi"] = 1;
                }else{
                    echo "Error.";
                    $_SESSION["exi"] = 0;
                }

                break;
            default:
                break;
        }
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>
 