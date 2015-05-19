<?php

include_once '../config/configuracion.php';
include_once '../funciones/colecciones.php';
include_once '../clases/colecciones.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $pagina = $_POST["pag"];
    $usuario = $_SESSION["usr"];
    
    $colecciones = getColecciones($usuario,$pagina);
    
   
    
    if(count($colecciones)==0){
        echo "No existen colecciones todavía";
        
    }else{
        for($i=0; $i<min($numeroResultadosPorPagina, count($colecciones)); $i++){
            $id = $colecciones[$i]["id"];
            $elemento = new ColeccionResumen($id, $usuario);
            echo $elemento->getHtml();

        }
        
        if(count($colecciones) == $numeroResultadosPorPagina+1){
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
                           url: "datos/colecciones_mas.php",
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
