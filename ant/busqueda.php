<!DOCTYPE html>

<?php

include_once 'config/configuracion.php';

include_once 'clases/publicaciones.php';
include_once 'clases/colecciones.php';
include_once 'funciones/publicaciones.php';
include_once 'funciones/colecciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estBusqueda;
    
    
    
?>
<br>
        <h1>Busqueda</h1>
        <br>
        <script>
        $(document).ready(function() {
                document.title = '6T - Resultados de busqueda';
                $("#busqueda").select().blur();
            });
        </script>
        
        
        <?php
        
        if(isset($_GET["idp"])){
                $id = $_GET["idp"];
                
                $elemento = new PublicacionResumen($id, $usuario);
                echo $elemento->getHtml();
                $_SESSION["est"] .= "p" . $_GET["idp"];
     
        }
        if(isset($_GET["idc"])){
                $id = $_GET["idc"];
                $elemento = new ColeccionResumen($id, $usuario);
                echo $elemento->getHtml();
                $_SESSION["est"] .= "c" . $_GET["idc"];
        }
        
        
        
        
        if(isset($_GET["b"])){
            $b = $_GET["b"];
            $_SESSION["est"] .= "b" .$_GET["b"];
            
            ?>
        
                <div class="div-contenedor-botones-filtro-busqueda">
                    <div id="filtroBusquedaSoloPublicaciones" style="background-color: #0481a6; color: #FFF" class="div-boton-filtro-busqueda">Publicaciones</div>
                    <div id="filtroBusquedaSoloColecciones" class="div-boton-filtro-busqueda">Colecciones</div>
                </div>
                <script>


                    $("#filtroBusquedaSoloPublicaciones").click(function(){

                            $.ajax({
                                type: "POST",
                                url: "busqueda.php?b=<?php echo $_GET["b"]; ?>&f=1",
                                data: "",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#filtroBusquedaSoloColecciones").click(function(){

                            $.ajax({
                                type: "POST",
                                url: "busqueda.php?b=<?php echo $_GET["b"]; ?>&f=2",
                                data: "",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });

                </script>
        
        
        
            
            <?php
            
            
            if($b!="" AND $b!= " "){
                
                
                if(isset($_GET["f"])){
                    
                    if($_GET["f"]==1){
                        $publicaciones = busquedaPublicacionPorTexto($b,1);
                        for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

                            $id = $publicaciones[$i];

                            $elemento = new PublicacionResumen($id, $usuario);
                            echo $elemento->getHtml();

                        }
                        if (count($publicaciones)==0){
                            echo "<br>No se han encontrado resultados para su busqueda";
                        }
                    }
                    if($_GET["f"]==2){
                      
                        $colecciones = busquedaColeccionPorTexto($b,1);

                        for($i=0;$i<min($numeroResultadosPorPagina, count($colecciones)); $i++){

                            $id = $colecciones[$i];

                            $elemento = new ColeccionResumen($id, $usuario);
                            echo $elemento->getHtml();
                        }
                        if (count($colecciones)==0){
                            echo "<br>No se han encontrado resultados para su busqueda";
                        }
                    }
                    
                    
                }else{
                    
                    
                    
                    $publicaciones = busquedaPublicacionPorTexto($b,1);

                    $colecciones = busquedaColeccionPorTexto($b,1);

                    for($i=0;$i<min($numeroResultadosPorPagina, count($colecciones)); $i++){

                        $id = $colecciones[$i];

                        $elemento = new ColeccionResumen($id, $usuario);
                        echo $elemento->getHtml();
                    }
                    for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

                        $id = $publicaciones[$i];

                        $elemento = new PublicacionResumen($id, $usuario);
                        echo $elemento->getHtml();

                    }
                    if (count($publicaciones) + count($colecciones)==0){
                            echo "<br>No se han encontrado resultados para su busqueda";
                    }
                }
            }
            
            
            $direccion = 'datos/busqueda_mas.php?b='. $_GET["b"];
            if(isset($_GET["f"])){
                
                $direccion .= '&f=' . $_GET["f"]; 
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
                               url: "' . $direccion . '",
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
        
}else{
    echo '<script>document.location="index.php"</script>';
} ?>