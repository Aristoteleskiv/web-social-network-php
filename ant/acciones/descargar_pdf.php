<?php

include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/panel_control.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $idPublicacion = $_GET["id"];
    
    $archivo = getNombrePDFPublicacion($idPublicacion);
    
    $usuario = $_SESSION["usr"];
    
    
    
    $_SESSION["acc"] = $accDescargarPdf . "idPub" . $idPublicacion;
    
    
    $cadena = $estPublicacion . "pub" . $idPublicacion;
    
    
        
        $comprobar = getRegla(4);
        if($comprobar==1){
            //comprobar numero de descargas de usuario, etc
            //filtro
            
            $autorizado = true;

            if($autorizado){
                $_SESSION["exi"] = 1;



                $original = '../pdf/'. $archivo . '.pdf';
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
                $_SESSION["exi"] = 0;
            }
        }else{
            echo "Las descargas estan desactivadas temporalmente. Disculpe las molestias.";
            $_SESSION["exi"] = 0;
        }
   
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
   echo '<script>document.location="../index.php"</script>'; 
}

?>