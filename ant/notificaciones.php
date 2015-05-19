<!DOCTYPE html>

<?php

include_once 'config/configuracion.php';
include_once 'funciones/notificaciones.php';
include_once 'clases/notificaciones.php';
include_once 'funciones/usuario.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
include_once 'funciones/publicaciones.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estNotificaciones;
   
?>
        <br>
        <h1> Notificaciones
        </h1>
        <script>
        $(document).ready(function() {
                document.title = '6T - Notificaciones';
            });
            function verPublicacion(idP){
            $("#divPopUp").bPopup({
                    follow: [false, false],
                    loadUrl: "publicacion.php?id=" + idP 
                });
            }
            function verAmigo(str){
                $("#divCentro").load("amigos.php?p=" + str);
                return false; 
            }
            function enviarMensaje(str){
                $("#divCentro").load("mensajes.php?i=" + str);
                return false;
            }
            function eliminarNotificacion(str, t) {
                if (confirm("Estas seguro de eliminar la notificacion?")) {

                    $.ajax({
                       type: "GET",
                       url: "acciones/eliminar_notificacion.php?i=" + str + "&t=" + t,
                       data: "",
                       success: function(msg){
                           //alert(msg);
                           $("#divCentro").load("notificaciones.php");
                           
                       }
                   });
                }
            }
            function aceptarSolicitud(i, inn) {
               
                 
                    $.ajax({
                       type: "GET",
                       url: "acciones/aceptar_solicitud_amistad.php?i=" + i + "&in=" + inn,
                       data: "",
                       success: function(msg){
                            $("#divAceptarAmistad" + inn).html(msg);
                            setTimeout(function(){$("#divCentro").load("notificaciones.php"); }, 2000);
                        }
                   });
               
            }
        </script>
<br>
        <?php
            $htmls = array();
            
            $numTotal = 0;
            
            
            $notificaciones = getNotificacionesSolicitudDeAmistad($usuario);
            
            $numTotal += count($notificaciones);
            
            for($i=0; $i<count($notificaciones); $i++){
                
                
                
                $id = $notificaciones[$i]["id"];
                $usuario = $notificaciones[$i]["usuario"];
                $solicitante = $notificaciones[$i]["solicitante"];
                $fecha = $notificaciones[$i]["fecha"];
                $estado = $notificaciones[$i]["estado"];
                
                $elemento = new NotificacionSolicitudAmistad($id, $usuario, 
                        $solicitante, $fecha, $estado);
                
                $linea = array("html" => $elemento->getHTML(), 
                                "fecha" => $fecha);
                
                
                array_push($htmls, $linea);
                
            }
            
            $notificaciones = getNotificacionesAceptacionSolicitudDeAmistad($usuario);
            $numTotal += count($notificaciones);
            for($i=0; $i<count($notificaciones); $i++){
                $id = $notificaciones[$i]["id"];
                $usuario = $notificaciones[$i]["usuario"];
                $aceptante = $notificaciones[$i]["aceptante"];
                $fecha = $notificaciones[$i]["fecha"];

                $elemento = new NotificacionAceptacionSolicitudAmistad($id, 
                        $usuario, $aceptante, $fecha);
                 $linea = array("html" => $elemento->getHTML(), 
                                "fecha" => $fecha);
                
                
                array_push($htmls, $linea);
            }
            $notificaciones = getNotificacionesErrorProblema($usuario);
            $numTotal += count($notificaciones);
            for($i=0; $i<count($notificaciones); $i++){
                $id = $notificaciones[$i]["id"];
                $idPublicacion = $notificaciones[$i]["id_publicacion"];
                $usuario = $notificaciones[$i]["usuario"];
                $informante = $notificaciones[$i]["informante"];
                $fecha = $notificaciones[$i]["fecha"];
                $descripcion = $notificaciones[$i]["descripcion"];

                $elemento = new NotificacionErrorProblema($id, $idPublicacion ,
                        $usuario, $informante, $fecha, $descripcion);
                
                $linea = array("html" => $elemento->getHTML(), 
                                "fecha" => $fecha);
                array_push($htmls, $linea);
            }
            
            //los ordenamos de manera descendente
            function sortFunction( $a, $b ) {
                return strtotime($a["fecha"]) - strtotime($b["fecha"]);
            }
            
            usort($htmls, "sortFunction"); 
          
            
            
            for($i=count($htmls)-1; $i>=0; $i--){
                
                echo $htmls[$i]["html"];
                
            }
            
            if($numTotal==0){echo "No tiene ninguna notificacion.";}
            setTodasNotificacionesVistas($usuario);
        ?>
        
        
        <script>
            $.ajax({
                    type: "POST",
                    url: "datos/datos_home_izquierda.php",
                    data: "t=1",
                    success: function(msg){
                        $("#divNumeroNotificacionesUsuario").html(msg);

                    }
                });
        </script>
        
        <br>

<?php  
registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
            }else{
    echo '<script>document.location="index.php"</script>';
}
 ?>