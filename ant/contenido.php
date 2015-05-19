<!DOCTYPE html>


<?php


include_once 'config/configuracion.php';
include_once 'funciones/publicaciones.php';
include_once 'clases/publicaciones.php';
include_once 'clases/noticias.php';
include_once 'clases/encuestas.php';
include_once 'funciones/noticias.php';
include_once 'funciones/grupos.php';
include_once 'funciones/encuestas.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estHome;
   
    
?>

<br>
        
    
    
    <h1>Contenido</h1><br>
    <script>
        $(document).ready(function() {
                document.title = '6T - Home';
            });
        </script>

        <?php
            
            $noticias = getNoticias($usuario);
            for($i=0;$i<count($noticias); $i++){
                
                $linea = $noticias[$i];
                $id = $linea["id"];
                marcarVistaNoticia($id, $usuario);
                $elemento = new Noticia($id, $usuario);
                echo $elemento->getHtml();
            }
            
            
            $encuesta = getEncuesta($usuario);
            
            if($encuesta!=null){    
                $linea = $encuesta;
                $id = $linea["id"];
                marcarVistaEncuesta($id, $usuario);
                $elemento = new Encuesta($id, $usuario);
                echo $elemento->getHtml();
            }
            
            
       
        
            $publicaciones = getPublicaciones($usuario,1);
            for($i=0;$i<min(count($publicaciones), $numeroResultadosPorPagina); $i++){
                
                $linea = $publicaciones[$i];
                $id = $linea["id"];
                $elemento = new PublicacionResumen($id, $usuario);
                echo $elemento->getHtml();
            }
            
            
            if(count($publicaciones)>$numeroResultadosPorPagina){
                echo '<div id="pag2">

                <div class="div-contenedor-boton-cargar-mas">
                    <div id="btnCargarMasPublicaciones" class="div-boton-cargar-mas">Cargar más</div>
                </div>

                <script> 
                $(window).scroll(function() {
                    if($(window).scrollTop() + $(window).height() == $(document).height()) {
                        
                    }
                 });
                $("#btnCargarMasPublicaciones").click(function(){
                    $("#pag2").html(\'' . $imagenCargandoHtml . '\');
                        $.ajax({
                           type: "POST",
                           url: "datos/publicaciones_mas.php",
                           data: "pag=2",
                           success: function(msg){
                             $("#pag2").html(msg);
                           }
                       });
                       return false;
                        
                });

                
                </script>
            </div>';
            }
        ?>
    
    
    


<?php  
registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
    echo '<script>document.location="index.php"</script>';
} ?>