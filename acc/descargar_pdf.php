<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/publicaciones.php';
include_once '../func/seguimiento.php';
include_once '../func/panel_control.php';


//session_start();

$usuario = $_SESSION["usr"];

if($usuario!=null){
//if(isset($_SESSION["usr"]) ){
    
    
    $idPublicacion = $_GET["id"];
    
    $archivo = getNombrePDFPublicacion($idPublicacion);
    echo $archivo;
    
    $usuario = $_SESSION["usr"];
    
    
    //$_SESSION["acc"] = $accDescargarPdf . "idPub" . $idPublicacion;
    
    
    $cadena = $estPublicacion . "pub" . $idPublicacion;
    
    
        
        $comprobar = getRegla(4);
        if($comprobar==1){
            //comprobar numero de descargas de usuario, etc
            //filtro
            
            $autorizado = true;

            if($autorizado){
                //$_SESSION["exi"] = 1;

                $original = '../datos/pdf/'. $archivo . '.pdf';
                if(file_exists($original)){

                    $nuevo = 'publicacion' .  $archivo . '.pdf';

                    header("Content-Type: application/pdf");
                    header("Content-Length: " . filesize($original));
                    header('Content-Disposition: attachment; filename="' . $nuevo . '"');

                    readfile($original);
                }else{
                    echo "El archivo ha sido eliminado";
                }


            }else{
                echo "Ha superado el limite de descargas por hoy...";
                //$_SESSION["exi"] = 0;
            }
        }else{
            echo "Las descargas estan desactivadas temporalmente. Disculpe las molestias.";
            //$_SESSION["exi"] = 0;
        }
}else{
    echo "Para descargar archivos es necesario ser un usuario registrado. Disculpe las molestias.";
} 
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
 //  echo '<script>document.location="../index.php"</script>'; 
//}

?>