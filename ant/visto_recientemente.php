<?php

include_once 'config/configuracion.php';
include_once 'funciones/publicaciones.php';
include_once 'clases/publicaciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estVistoRecientemente;
    
?>
    
<br>
        <h1>Visto recientemente</h1><br>
        <script>
        $(document).ready(function() {
                document.title = '6T - Visto recientemente';
            });
        </script>
       <?php
            $publicaciones = getPublicacionesVistas($usuario, 1);
            if(count($publicaciones)==0){
                echo "No ha visto ninguna publicación.";

            }else{

                for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

                    $linea = $publicaciones[$i];
                    $id = $linea["id_publicacion"];
                    $elemento = new PublicacionResumen($id, $usuario);
                    echo $elemento->getHtml();

                }
                
                if(count($publicaciones)== $numeroResultadosPorPagina+1){
                $coma = "'";
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

                            $("#pag2").html(' . $coma . $imagenCargandoHtml .$coma . ');
                            $.ajax({
                               type: "POST",
                               url: "datos/vistos_recientemente_mas.php",
                               data: "pag=2",
                               success: function(msg){
                                 $("#pag2").html(msg);
                               }
                           });
                    });
                    </script>
                    </div>';
                }
            }
            
            
            
            
            registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
        ?>



<?php  }else{
    echo '<script>document.location="index.php"</script>';
} ?>