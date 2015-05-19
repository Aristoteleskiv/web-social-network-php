<?php


include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/colecciones.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $refs = $_POST["texto"];
    $col = $_POST["col"];
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
   
    
        if($col==1){  //coleccion de publicaciones

            $publicaciones = explode(" ", $refs);

            for($i=0; $i<count($publicaciones); $i++){

                $id = (int)$publicaciones[$i];
                $titulo = getTituloPublicacion($id);
                $tipo = getTipoDocumentoPublicacion($id);
                if($tipo==1){$tipo="Video";}
                if($tipo==2){$tipo="PDF";}

                $pos = $i+1;

                echo "<b>$pos</b>.ID: $id- $tipo  -" . $titulo . '<br>';
            }

        }

        if($col==2){  //coleccion de colecciones

            $colecciones = explode(" ", $refs);
            $contador = 0;
            $todasColecciones = array();
            for($i=0; $i<count($colecciones); $i++){
                $id = (int)$colecciones[$i];
                $ids = getIDsColeccionColeccion($id);
                for($j=0; $j<count($ids); $j++){
                    $todasColecciones[] = $ids[$j];

                }

            }


            $todasColecciones = array_interseccion_colecciones($todasColecciones, $todasColecciones);


            for($j=0; $j<count($todasColecciones); $j++){
                $titulo = getTituloPublicacion_colecciones($todasColecciones[$j]);
                $tipo = getTipoDocumentoPublicacion($todasColecciones[$j]);
                if($tipo==1){$tipo="Video";}
                if($tipo==2){$tipo="PDF";}

                $contador++;
                echo "<b>$contador</b>.ID: $todasColecciones[$j]- $tipo  -" . $titulo . '<br>';
            }



        }
    }
        
   
    
    
}else{
    echo '<script>document.location="index.php"</script>';
}
