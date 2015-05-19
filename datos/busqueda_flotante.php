<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/publicaciones.php';
include_once '../func/colecciones.php';
include_once '../func/clases/resultado_busqueda.php';
include_once '../func/usuario.php';
include_once '../func/otras.php';
include_once '../func/secciones.php';
include_once '../func/menciones_comentarios.php';

$nivel = 1;



$usuario = $_SESSION["usr"];
$b = $_GET["b"];
$n = $_GET["n"];
$s = getNiveles($n);

if(substr($b, 0,1)=="@"){
//    busqueda de usuarios
    $nombre = substr($b, 1, strlen($b)-1);
    $amigos = busquedaPersonas($usuario, $nombre,1);
   
    $maxResultados = 6;
    for($i=0; $i<min($maxResultados, count($amigos)); $i++){
        $amigo = $amigos[$i]["amigo"];
        $elemento = new resultadoBusquedaAmigoEmergente($usuario, $amigo, $n);
        echo $elemento->getHtml();
        if($i<count($amigos)-1){
            echo '<div style="margin-left: 120px; width: 200px; height: 1px; background-color: rgba(0, 0, 0, 0.2);"></div>';
        }
    }
    if(count($amigos)>$maxResultados){
        echo '<a href="'. $s .'busqueda/?b='.$b.'"><div class="botones-ver-mas-busqueda">Ver mas</div></a>';
    }
}else{
    
    $bId = array();
    $publicaciones = busquedaPublicacionPorTexto($b, 1);
    $colecciones = busquedaColeccionPorTexto($b,1);
    ?>
    <div>

    <?php
        

       $boolVerMas = false;  
       $resultados = 6;
       if(count($colecciones)>$numeroResultadosColeccionesBusqueda){$boolVerMas = true;}
       if(count($publicaciones)>$numeroResultadosColeccionesBusqueda){$boolVerMas = true;}
       
       for($i=0; $i<min(count($colecciones), $numeroResultadosColeccionesBusqueda); $i++){
            $id = $colecciones[$i];
            $elemento = new resultadoBusquedaColeccionEmergente($id, $n);
            echo $elemento->getHtml();
            if($i<count($resultados)-1){
                echo '<div style="margin-left: 120px; width: 200px; height: 1px; background-color: rgba(0, 0, 0, 0.2);"></div>';
            }
        }


        for($i=0; $i<min(count($publicaciones), $numeroResultadosColeccionesBusqueda); $i++){
            $id = $publicaciones[$i];
            $elemento = new resultadoBusquedaPublicacionEmergente($id, $n);
            echo $elemento->getHtml();
            if($i<count($resultados)-1){
                echo '<div style="margin-left: 120px; width: 200px; height: 1px; background-color: rgba(0, 0, 0, 0.2);"></div>';
            }

        }
        if($boolVerMas){
            echo '<a href="'. $s .'busqueda/?b='.$b.'"><div class="botones-ver-mas-busqueda">Ver mas</div></a>';

        }

    ?>
    </div>

<?php
}


?>

