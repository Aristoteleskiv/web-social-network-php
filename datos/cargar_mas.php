<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';

include_once '../func/publicaciones.php';
include_once '../func/colecciones.php';
include_once '../func/clases/colecciones.php';
include_once '../func/clases/publicaciones.php';
include_once '../func/clases/amigo.php';
include_once '../func/muro.php';

include_once '../func/otras.php';
include_once '../func/menciones_comentarios.php';
include_once '../func/usuario.php';
include_once '../func/otras.php';
include_once '../func/notificaciones.php';

//session_start();
$nivel = 1;

//if(isset($_SESSION["usr"]) ){

    
    $pagina = $_POST["pag"];
    //$usuario = $_SESSION["usr"];
    $usuario = $_SESSION["usr"];
    $contenido = $_POST["c"];
    $nivelContenido = $_POST["n"];
    
    $desfase = null;
    if(isset($_POST["d"])){
        $desfase = $_POST["d"];
    }
    
    
    $publicaciones = array();
    $colecciones = array();
    $amigos = array();
    
    switch ($contenido) {
    case 1:
        $publicaciones = getPublicaciones($usuario,$pagina);
        break;
    case 2:
        $publicaciones = getPublicacionesVistas($usuario,$pagina);
        break;
    case 3:
        $publicaciones = getPublicacionesGuardasParaMasTarde($usuario,$pagina, $desfase);
        break;
    case 4:
        $publicaciones = getPublicacionesRealizadas($usuario,$pagina, $desfase);
        break;
    case 5:
        $colecciones = getColecciones($usuario,$pagina);
        break;
    case 6:
        $b = null;
        if(isset($_POST["b"])){
            $b = $_POST["b"];
        }
        
        $nombre = substr($b, 1, strlen($b)-1);
        $amigos = busquedaPersonas($usuario,$nombre , $pagina);
        break;
    case 7:
        $b = null;
        if(isset($_POST["b"])){
            $b = $_POST["b"];
        }
        $f = null;
        if(isset($_POST["f"])){
            $f = $_POST["f"];
        }
        if($f=="c"){
            $publicaciones = busquedaColeccionPorTexto($b, $pagina);
        }else{
            $publicaciones = busquedaPublicacionPorTexto($b, $pagina);
        }
        break;
    default:
        break;
    }
    
    echo getPublicidadCargarMas($nivel);
    
    
    if($contenido==1 OR $contenido==2 OR $contenido==3 OR $contenido==4){
        echo "<script>" . getScriptOverText($pagina) . "</script>";
        for($i=0;$i<min($numeroResultadosPorPagina, count($publicaciones)); $i++){

            $linea = $publicaciones[$i];

            switch ($contenido) {
            case 1:
                $linea2 = $linea;
                $ref = null;
                    break;
            case 2:
                $id = $linea["id_publicacion"];
                $linea2 = getPublicacion($id);
                $ref = null;
                break;
            case 3:
                $id = $linea["id_publicacion"];
                $linea2 = getPublicacion($id);
                $ref = 3;
                break;
                
            case 4:
                $id = $linea["id_publicacion"];
                $linea2 = getPublicacion($id);
                
                $ref = 4;
                break;
            default:
                break;
            }
            $elemento = new PublicacionResumen2($linea2, $usuario, $nivel, $pagina,  $ref);
            echo $elemento->getHtml();
        }
    }
    if($contenido==5 ){
    
        for($i=0;$i<min($numeroResultadosPorPagina, count($colecciones)); $i++){

            $linea = $colecciones[$i];
            $id = $linea["id"];
            
            $elemento = new ColeccionResumen2($linea, $usuario, $nivel, $pagina);

            
            echo $elemento->getHtml();

        }
    }
    
    if($contenido==6 ){
    
        for($i=0; $i<min($numeroResultadosPorPagina, count($amigos)); $i++){
            $amigo = $amigos[$i]["amigo"];
            $elemento = new PersonaAmigoNoAmigoResumen($usuario, $amigo, $nivel);
            echo $elemento->getHtml();

        }
    }
    
    if($contenido==7 ){
        
        if($f=="c"){
            $colecciones = $publicaciones;
            for($i=0;$i<min(count($colecciones), $numeroResultadosPorPagina); $i++){
                $id = $colecciones[$i];
                $elemento = new ColeccionResumen2SoloConID($id, $usuario,
                        $nivel);
                echo $elemento->getHtml();
            }
        }else{
            for($i=0;$i<min(count($publicaciones), $numeroResultadosPorPagina); $i++){
                $id = $publicaciones[$i];
                $elemento = new PublicacionResumen2SoloConID($id, 
                        $usuario, $nivel, $pagina);
                echo $elemento->getHtml();
            }
        }
    }
    if(count($publicaciones)== $numeroResultadosPorPagina+1 OR 
            count($colecciones)== $numeroResultadosPorPagina+1 OR
            count($amigos)== $numeroResultadosPorPagina+1){
        $ext = "";
        if(isset($_POST["b"])){
            $ext .= "&b=" . $_POST["b"];
        }
        if(isset($_POST["f"])){
            $ext .= "&f=" . $_POST["f"];
        }
        if(isset($_POST["b"]) OR isset($_POST["f"])){
            $ext = ", '". $ext . "' ";
        }
        
        echo '<div id="pag'. (int)($pagina+1) . '">
            <div style="text-align: center;">
                <div onclick="cargarMas(\''. (int)($pagina+1) . '\',\''.$contenido.'\',\''.$nivelContenido.'\''. $ext .')" class="div-boton-estandar">Cargar más</div>
            </div>
            </div>';
    }
    
    
    
    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}
