<?php

include_once '../config/configuracion.php';
include_once '../clases/publicaciones.php';
include_once '../clases/colecciones.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/colecciones.php';
include_once '../funciones/seguimiento.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    $pagina = $_POST["pag"];
    $usuario = $_SESSION["usr"];
    
         
        
        if(isset($_GET["b"])){
            $b = $_GET["b"];
            $_SESSION["est"] .= "b" .$_GET["b"];
            
            
            
            if($b!="" AND $b!= " "){
                
                if(isset($_GET["f"])){
                    
                    
                    if($_GET["f"]=="1"){
                        
                        $publicaciones = busquedaPublicacionPorTexto($b,$pagina);

                        for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

                            $id = $publicaciones[$i];

                            $elemento = new PublicacionResumen($id, $usuario);
                            echo $elemento->getHtml();

                        }
                    }
                    if($_GET["f"]=="2"){
                        
                        $colecciones = busquedaColeccionPorTexto($b,$pagina);
                        
                        for($i=0;$i<min($numeroResultadosPorPagina, count($colecciones)); $i++){

                            $id = $colecciones[$i];
          
                            $elemento = new ColeccionResumen($id, $usuario);
                            echo $elemento->getHtml();
                        }   
                    }
                }else{
       
                    $publicaciones = busquedaPublicacionPorTexto($b,$pagina);


                    for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

                        $id = $publicaciones[$i];
                        
                        $elemento = new PublicacionResumen($id, $usuario);
                        echo $elemento->getHtml();

                    }
                }
            
            }
            
            $direccion = 'datos/busqueda_mas.php?b='. $_GET["b"];
            if(isset($_GET["f"])){
               
                $direccion .= "&f=" . $_GET["f"];
            }
            
            
            if(count($publicaciones)== $numeroResultadosPorPagina+1){
            $coma = "'";
             echo '<div id="pag'. (int)($pagina+1) . '">
                
            <div class="div-contenedor-boton-cargar-mas">
                        <div id="btnCargarMasPublicaciones" class="div-boton-cargar-mas">Cargar más</div>
                    </div>
            
            <script> 
                $(window).scroll(function() {
                    if($(window).scrollTop() + $(window).height() == $(document).height()) {
                        
                    }
                 });
                $("#btnCargarMasPublicaciones").click(function(){

                        $("#pag'. (int)($pagina+1) . '").html(' . $coma . $imagenCargandoHtml .$coma . ');
                        $.ajax({
                           type: "POST",
                           url: "'. $direccion . '",
                           data: "pag='. (int)($pagina+1) . '",
                           success: function(msg){
                             $("#pag'. (int)($pagina+1) . '").html(msg);
                           }
                       });
                });

            </script>
            </div>';
            }
             
             
        }
    
    
}else{
    echo '<script>document.location="index.php"</script>';
}
