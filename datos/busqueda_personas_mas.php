<?php



include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';
include_once '../clases/amigo.php';
include_once '../funciones/muro.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $pagina = $_POST["pag"];
    $usuario = $_SESSION["usr"];
    $b = $_POST["b"];
    
    $noAmigos = busquedaPersonasSoloNoAmigos($usuario, $b, $pagina);
    
    
    if(count($noAmigos)==0){
        
    }else{
        for($i=0;$i<min($numeroResultadosPorPagina, count($noAmigos)); $i++){

            $elemento = new PersonaResumen($usuario, $noAmigos[$i]["amigo"]);
            echo $elemento->getHtml();

        }
    }
    
    
    if(count($noAmigos)>$numeroResultadosPorPagina){
       
        echo '<div id="pag'. (int)($pagina+1) . '">
                
            <div class="div-contenedor-boton-cargar-mas">
                <div id="btnCargarMasPersonas" class="div-boton-cargar-mas">Cargar más</div>
            </div>
            
            <script> 
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    
                }
             });
            $("#btnCargarMasPersonas").click(function(){
            
                    $("#pag'. (int)($pagina+1) . '").html(\'' . $imagenCargandoHtml . '\');
                    $.ajax({
                       type: "POST",
                       url: "datos/busqueda_personas_mas.php",
                       data: "pag='. (int)($pagina+1) . '&b='. $b .'",
                       success: function(msg){
                         $("#pag'. (int)($pagina+1) . '").html(msg);
                       }
                   });
            });
            
        </script>
        </div>';
    }
    
    
    
    
    
}else{
    echo '<script>document.location="index.php"</script>';
}





    


?>