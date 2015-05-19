<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../func/clases/notificaciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';



include_once '../../func/notificaciones.php';

include_once '../../func/usuario.php';
include_once '../../func/otras.php';
//include_once 'funciones/seguimiento.php';
//include_once 'funciones/usuarios_online.php';
include_once '../../func/publicaciones.php';



$nivel = 2;
$usuario = $_SESSION["usr"];


if($usuario==null){
    echo codigoRedireccionHome($nivel);
}
?>


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>

    </head>
    <body>
        <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
        
            
            <div id="vertical">
                <aside id="menu">
                
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>

                <section id="contenido">
                    
                    <?php
                    if($usuario==null){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                            
                        <div class="div-contenido">
                            <h1>
                                Notificaciones
                            </h1>
                            <div id="div-contenido-no-titulo">
                                <script>numNotificacionesEliminadas=0;</script>
                               <?php
                                $htmls = array();
                                $numTotal = 0;
                                $notificaciones = getNotificacionesSolicitudDeAmistad($usuario);
                                $numTotal += count($notificaciones);
                                for($i=0; $i<count($notificaciones); $i++){
                                    $fecha = $notificaciones[$i]["fecha"];
                                    $elemento = new NotificacionSolicitudAmistad2(
                                            $notificaciones[$i] , $nivel);
                                    $linea = array("html" => $elemento->getHTML(), 
                                                    "fecha" => $fecha);
                                    array_push($htmls, $linea);
                                }
                                $notificaciones = getNotificacionesAceptacionSolicitudDeAmistad($usuario);
                                $numTotal += count($notificaciones);
                                for($i=0; $i<count($notificaciones); $i++){
                                    $fecha = $notificaciones[$i]["fecha"];
                                    $elemento = new NotificacionAceptacionSolicitudAmistad2( 
                                            $notificaciones[$i] , $nivel);
                                     $linea = array("html" => $elemento->getHTML(), 
                                                    "fecha" => $fecha);
                                    array_push($htmls, $linea);
                                }
                                $notificaciones = getNotificacionesErrorProblema($usuario);
                                $numTotal += count($notificaciones);
                                for($i=0; $i<count($notificaciones); $i++){
                                    $fecha = $notificaciones[$i]["fecha"];
                                    $elemento = new NotificacionErrorProblema2(
                                            $notificaciones[$i], $nivel);
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
                                echo '<script>numNotificaciones = '.$numTotal.';</script>';
                                if($numTotal==0){
                                    echo '<div class="div-contenedor-estandar">No tiene ninguna notificación.</div>';
                                }
                                setTodasNotificacionesVistas($usuario);
                            ?>
                            </div>
                        </div>
                    
                        <?php
                    }
                    ?>
                    
                <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
                
            </div>
        
        
        <div>
            <?php echo getScrolls($nivel); ?>
        </div>
        
        
    </body>

    
</html>

