<!DOCTYPE html>


     
<?php


include_once 'config/configuracion.php';
include_once 'funciones/colecciones.php';
include_once 'clases/colecciones.php';
include_once 'funciones/publicaciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estColecciones;
    
    
    
    ?>
<br>
    <h1>Colecciones</h1>
    <br>
    <script>
        $(document).ready(function() {
                document.title = '6T - Colecciones';
            });
    </script>

    <?php
    
    
    if(isset($_GET["a"])){
        $_SESSION["est"] .= 'Arbol' . $_GET["a"];
        
        
        
        $descripcion = getDescripcionColeccion($_GET["a"]);
        $nombre = getNombreColeccion($_GET["a"]);
        echo '<div style="text-align: left;" class="div-contenedor-hijos-arbol-coleccion">
                Los niveles de las colecciones muestran cuántos escalones tiene cada colección. Un ejemplo de niveles sería empezando desde el nivel más alto al más bajo: libro, pagina, ejercicio, apartado. Por tanto, cuantos más niveles tenga una coleccion, más publicaciones abarcará puesto que las colecciones pueden reunir publicaciones y además otras colecciones.



                </div>';
        
        if($_GET["a"]!=$_GET["a2"]){
            echo '
                <script>
                            $( "#divVolverAInicial" ).click(function() {
                                $("#divCentro").html(\''  . $imagenCargandoHtml . '\');
                                $.ajax({
                                   type: "POST",
                                   url: "colecciones.php?a='. $_GET["a2"] . '&a2='.$_GET["a2"].'",
                                   data: "pag=2",
                                   success: function(msg){
                                     $("#divCentro").html(msg);
                                   }
                               });
                            }); 
                            </script>
                <div class="div-contenedor-boton-cargar-mas">
                <div id="divVolverAInicial" class="div-boton-cargar-mas">Volver a inicial</div>
                <br><br>
                </div>
                

                ';
        }
        
        
        echo '<div class="div-contenedor-hijos-arbol-coleccion">
            
               <h1>Colección madre</h1>
               <br>
               <div class="div-boton-coleccion-arbol-coleccion">
               <b>'. $_GET["a"] . '.</b> '. $nombre . ' 
              
                </div>
                <div>
                '. $descripcion . '
                </div>
             </div>';
        
        
        
        
        $botonHijas = '';
        $hijos = getHijosColeccion($_GET["a"]);
        for($i=0; $i<count($hijos); $i++){
            $nombre = getNombreColeccion($hijos[$i]);
            $botonHijas .= '
                            <script>
                            $( "#contenedorHijoID'. $hijos[$i] . '" ).click(function() {
                                $("#divCentro").html(\''  . $imagenCargandoHtml . '\');
                                $.ajax({
                                   type: "POST",
                                   url: "colecciones.php?a='. $hijos[$i] . '&a2='.$_GET["a2"].'",
                                   data: "pag=2",
                                   success: function(msg){
                                     $("#divCentro").html(msg);
                                   }
                               });
                            }); 
                            </script>
                            <div id="contenedorHijoID'. $hijos[$i] .'"  class="div-boton-coleccion-arbol-coleccion">
                                <b>'. $hijos[$i] . '.</b> '. $nombre .'
                            </div>';

        }
        if(count($hijos)==0){
            $botonHijas = "No existen colecciones hijas";
        }
        
        
        echo '<div class="div-contenedor-hijos-arbol-coleccion">
            
               <h1>Colecciones hijas</h1>
               <br>
               '. $botonHijas .'
            </div>';
        
        
        $porDebajo = getIDsPublicacionesYColeccionesColeccion($_GET["a"]);
        $porDebajo = array_interseccion_colecciones($porDebajo, $porDebajo);
        $botonHijas = "";
        for($i=0; $i<count($porDebajo); $i++){
            $linea = $porDebajo[$i];
            $vector = explode(" ", $linea);
            $id = $vector[0];
            $tipo = $vector[1];
            if($tipo ==1){
            $nombre = getNombrePublicacion($id);
            $mostrarNombre = "<b>Publicación $id</b><br>$nombre";
            $botonHijas .= '<script>
                            $( "#contenedorPublicacion'. $id . '" ).mouseover(function() {
                                $("#clickVer'. $id . '").html("Click para ver");
                            });
                            $( "#contenedorPublicacion'. $id . '" ).mouseleave(function() {
                                $("#clickVer'. $id . '").html("");
                            });    
                            $( "#contenedorPublicacion'. $id . '" ).click(function() {
                                $("#nombrePublicacionArbol").html(\' '. $mostrarNombre . ' \');
                            }); 
                            
                            </script>
                            <div class="div-boton-publicacion-arbol-coleccion" id="contenedorPublicacion'. $id . '" >
                                <b>P '. $id . '</b><div id="clickVer'. $id . '"></div>
                            </div>';
            }
            if($tipo ==2){
            $nombre = getNombreColeccion($id);
            $botonHijas .= '<script>
                            $( "#contenedorPorDebajoID'.$id . '" ).click(function() {
                                $("#divCentro").html(\''  . $imagenCargandoHtml . '\');
                                $.ajax({
                                   type: "POST",
                                   url: "colecciones.php?a='. $id . '&a2='.$_GET["a2"].'",
                                   data: "",
                                   success: function(msg){
                                     $("#divCentro").html(msg);
                                   }
                               });
                            }); 
                            </script>
                            <div id="contenedorPorDebajoID'. $id .'" class="div-boton-coleccion-arbol-coleccion">
                                <b>C '. $id . '.</b> '. $nombre .'
                            </div>';
                            
            }
            

        }
        
        echo '<div class="div-contenedor-hijos-arbol-coleccion">
            
               <h1>Colecciones y publicaciones por debajo</h1>
               <br>
               '. $botonHijas .'
                </div>';
        
        echo '<div class="div-contenedor-hijos-arbol-coleccion" style="background-color: #FFF;" id="nombrePublicacionArbol">
                </div>';
        
        
    }else{
    
        $colecciones = getColecciones($usuario,1);
        if(count($colecciones)==0){
            echo "No existen colecciones todavía";

        }else{
            for($i=0; $i<min(count($colecciones), $numeroResultadosPorPagina); $i++){
                $id = $colecciones[$i]["id"];
                $elemento = new ColeccionResumen($id, $usuario);
                echo $elemento->getHtml();

            }
            if(count($colecciones)> $numeroResultadosPorPagina){
            $coma = "'";
            echo '
                <div id="pag2">
                <div class="div-contenedor-boton-cargar-mas">
                            <div id="btnCargarMasColecciones" class="div-boton-cargar-mas">Cargar más</div>
                        </div>

                <script> 
                $(window).scroll(function() {
                    if($(window).scrollTop() + $(window).height() == $(document).height()) {
                        
                    }
                 });
                $("#btnCargarMasColecciones").click(function(){

                        $("#pag2").html(' . $coma . $imagenCargandoHtml .$coma . ');
                        $.ajax({
                           type: "POST",
                           url: "datos/colecciones_mas.php",
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
    
    }
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
    
}else{
    echo '<script>document.location="index.php"</script>';
}
    
    
    
    
?>
