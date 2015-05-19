<!DOCTYPE html>

<?php
include_once 'config/configuracion.php';
include_once 'funciones/publicaciones.php';
include_once 'clases/publicaciones.php';
include_once 'funciones/colecciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estPublicacion;
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $id = $_GET["id"];
    
    if(isset($_GET["c"])){
        $col = $_GET["c"];
        $_SESSION["est"] .= "pub" . $id . "col" . $col ;
    }else{
        $col = null;
        $_SESSION["est"] .= "pub" . $id ;
    }
    if(isset($_GET["pc"])){
        $posComentario = $_GET["pc"];
    }else{
        $posComentario = null;
    }
    
  
    

?>

        <script>
        
        $(function(){
               //reajustamos el ancho de los divs
               
                var $window = $(window).on('resize', function(){
                   
                    var windowWidth = ((parseInt($(window).width())))*90/100;
                    var windowHeight = ((parseInt($(window).height())) ) - 380;
                    
                    //$('#divPopUp').css({'width':windowWidth  });
                    //$('#divPopUp').css({'height':windowHeight  });
                    //$('#divPopUp').css({'height':windowHeight  });
                }).trigger('resize'); //on page load
            });
        
        
            
        </script>
        
        
       
        
       
            <?php 
            
            
            
            
            $elemento = new Publicacion($id, $usuario, $col, $posComentario);
            
            echo $elemento->getHtml();
            if($col != null){
                sumarVisitaAColeccion($col);
            }
            sumarVisitaAPublicacion($id);
            marcarPublicacionVista($usuario, $id);
            
            
            ?>
            

<?php  

registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
    echo '<script>document.location="index.php"</script>';
} ?>