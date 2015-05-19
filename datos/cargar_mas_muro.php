<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';

include_once '../func/publicaciones.php';
include_once '../func/colecciones.php';
include_once '../func/clases/colecciones.php';
include_once '../func/clases/publicaciones.php';
include_once '../func/usuario.php';
include_once '../func/otras.php';
include_once '../func/muro.php';


include_once '../func/menciones_comentarios.php';
include_once '../func/clases/amigo.php';
include_once '../func/clases/muro.php';

include_once '../func/login.php';

//include_once 'funciones/seguimiento.php';
include_once '../func/notificaciones.php';



//session_start();
$nivel = 1;

//if(isset($_SESSION["usr"]) ){

    
    $pagina = $_POST["pag"];
    //$usuario = $_SESSION["usr"];
    $usuario = $_SESSION["usr"];
    $user = $_POST["u"];
    
    $nivelContenido = $_POST["n"];
    
    $desfase = null;
    if(isset($_POST["d"])){
        $desfase = $_POST["d"];
    }
    
    $user = getNombreUsuario($user);
    
    $elemento = new AmigoMuroSinCabecera($usuario, $user, $nivelContenido, $pagina);
    echo $elemento->getHTML();
        
    
//    if(count($publicaciones)== $numeroResultadosPorPagina+1 OR 
//            count($colecciones)== $numeroResultadosPorPagina+1){
//        echo '<div id="pag'. (int)($pagina+1) . '">
//            <div style="text-align: center;">
//                <div onclick="cargarMas(\''. (int)($pagina+1) . '\',\''.$contenido.'\',\''.$nivelContenido.'\')" class="div-boton-estandar">Cargar más</div>
//            </div>
//            </div>';
//    }
    
    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}
