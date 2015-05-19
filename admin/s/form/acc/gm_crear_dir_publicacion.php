<?php


include_once '../../../../conf/conf.php';
include_once '../../../../func/publicaciones_editor.php';
include_once '../../../../func/publicaciones.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/secciones.php';
include_once '../../../../func/latex.php';
include_once '../../../../func/seguimiento.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarMensaje;
        $usuario = $_SESSION["usr"];
        $nivel = 4;
        $rango = $_POST["rango"];
        $tipo = $_POST["nomenclatura"]; 
        $s = getNiveles($nivel);
        switch ($rango) {
            case 1:
                $publis = getIDsTodasPublicacionesPDF();
                break;
            case 2:
                $publis = getIDsTodasPublicacionesVideo();
                break;
            case 3:
                $publis = getIDsTodasPublicaciones();
                break;
            default:
                break;
        }
        
        for ($i = count($publis)-1; $i >=0 ; $i--) {
            $id = $publis[$i]["id"];
            $tituloCompatible = $id . "-" . quitarSimbolosString(sustituirImagenesPorLatex(getTituloPublicacion($id)));
            $cuerpoCompatible = $id . "-" .  quitarSimbolosString(sustituirImagenesPorLatex(getCuerpoPublicacion($id)));
            $seccion = getDirSeccionado($id);
            $dirTitulo =  $pivoteDirectorioCreacionDocumentos . "/" . $seccion . $tituloCompatible;
            $dirCuerpo =  $pivoteDirectorioCreacionDocumentos . "/" . $seccion . $cuerpoCompatible;
            
            $dirTitulo = substr($dirTitulo, 0,min(190, strlen($dirTitulo)));
            $dirCuerpo = substr($dirCuerpo, 0,min(190, strlen($dirCuerpo)));
            
            if($tipo==1){
                $dir = $dirCuerpo;
            }elseif($tipo==2){
                $dir = $dirTitulo;
            }else{
                $dir = $dirCuerpo;
            }
            editarPublicacionDir($id, $dir);
            crearDocumento($dir, $id, $nivel);
            
            if(strlen($dir)==190){
                $bloqRevision = '<a href="'.$s .'admin/s/form/publicacion.php?id='.$id.'&p=8&a=a" target="_blank"><img style="width: 16px" src="'. $s .'images/header/incorrecto.png"></a>';
            }else{
                $bloqRevision = '<a href="'.$s .'admin/s/form/publicacion.php?id='.$id.'&p=8&a=a" target="_blank"><img style="width: 16px" src="'. $s .'images/header/correcto.png"></a>';
            }
            
            echo '<b>' .$id . "</b> ." . $dir . $bloqRevision . "<br>";
        }       
        
        echo "Documentos creados!";
        
        //enviarMensaje($destinatario, $mandatario, $cuerpo);
        //echo 'Mensaje enviado!';
            //$_SESSION["exi"] = 1;
        
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>

