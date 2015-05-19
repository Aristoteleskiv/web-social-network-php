<?php

include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/colecciones.php';
include_once '../clases/resultado_busqueda.php';
include_once '../funciones/usuario.php';
include_once '../funciones/menciones_comentarios.php';




session_start();


if(isset($_SESSION["usr"]) ){
        
        $usuario = $_SESSION["usr"];
        $b = $_GET["busqueda"];
        
        
        if(substr($b, 0,1)=="@"){
            
            $nombre = substr($b, 1, strlen($b)-1);
            $amigos = busquedaPersonas($usuario, $nombre,1);
            $maxResultados = 6;
            for($i=0; $i<min($maxResultados, count($amigos)); $i++){
                $amigo = $amigos[$i]["amigo"];
                $elemento = new resultadoBusquedaAmigoEmergente($usuario, $amigo);
                echo $elemento->getHtml();
                if($i<count($amigos)-1){
                    echo '<div style="display: inline-block; width: 160px; height: 1px; background-color: #FFF;"></div>';
                    echo '<div style="display: inline-block; width: 200px; height: 1px; background-color: #4c4c4c;"></div>';
                    echo '<div style="display: inline-block; width: 40px; height: 1px; background-color: #FFF;"></div>';
                }
            }
            if(count($amigos)>$maxResultados){
                    
                    echo '<div onclick="javascript:verMasAmigos(\''. $b .'\');"  class="div-resultado-busqueda-emergente-ver-mas">';
                    echo '<a href="#" class="botones-ver-mas-busqueda">Ver mas</a>';
                    echo '</div>';

            }
            
            
            
            
            
            
        }else{
            $bId = array();

            $publicaciones = busquedaPublicacionPorTexto($b, 1);
            $colecciones = busquedaColeccionPorTexto($b,1);

            ?>

            <div>

            <?php
                $maxResultados = 6;
                $minResultadoPublicaciones = 4;

                $numResultadosPublicaciones = count($publicaciones);
                $numResultadosColecciones = count($colecciones);
                $boolVerMas = false;


                if($numResultadosPublicaciones + $numResultadosColecciones<=$maxResultados){

                }

                if($numResultadosPublicaciones + $numResultadosColecciones>$maxResultados){
                    $boolVerMas = true;
                    $numResultadosPublicaciones = max($maxResultados - $numResultadosColecciones , $minResultadoPublicaciones);
                }






                for($i=0; $i<$numResultadosColecciones; $i++){
                    $id = $colecciones[$i];
                    $elemento = new resultadoBusquedaColeccionEmergente($id);
                    echo $elemento->getHtml();
                    

                }


                for($i=0; $i<$numResultadosPublicaciones; $i++){
                    $id = $publicaciones[$i];
                    $elemento = new resultadoBusquedaPublicacionEmergente($id);
                    echo $elemento->getHtml();
                    if($i<count($resultados)-1){
                        //echo '<div style="display: inline-block; width: 50px; height: 1px; background-color: #FFF;"></div>';
                        //echo '<div style="display: inline-block; width: 300px; height: 1px; background-color: #4c4c4c;"></div>';
                        //echo '<div style="display: inline-block; width: 50px; height: 1px; background-color: #FFF;"></div>';
                    }

                }
                if($boolVerMas){
                    echo '<div style="margin-left: 50px; width: 300px; height: 1px; background-color: #4c4c4c;"></div>';
                    echo '<div onclick="javascript:verMas(\''. $b .'\');"  class="div-resultado-busqueda-emergente-ver-mas">';
                    echo '<a href="#" class="botones-ver-mas-busqueda">Ver mas</a>';
                    echo '</div>';

                }

            ?>
            </div>
        
        <?php
        }
    }else{
        echo '<script>document.location="index.php"</script>';
    }

?>

