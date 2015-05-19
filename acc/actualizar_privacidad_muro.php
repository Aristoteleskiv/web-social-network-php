<?php




include_once '../conf/conf.php';
include_once '../func/muro.php';
include_once '../func/usuario.php';
include_once '../func/seguimiento.php';
include_once '../conf/sesion.php';
$usuario = $_SESSION["usr"];
$nivel = 1;


//if(isset($_SESSION["usr"]) ){
   
 if($usuario!=null){       
        
        
        
        $evento = $_GET["e"];
        $comentario = $_GET["c"];
        $mencion = $_GET["m"];
        $amistad = $_GET["a"];
        if($evento==null){$evento=0;}
        if($comentario==null){$comentario=0;}
        if($mencion==null){$mencion=0;}
        if($amistad==null){$amistad=0;}
        
        //$idUsuario = getID($usuario);
        //echo "<br>" .$mencion . "<br>" . $comentario . "<br>" . $amistad . "<br>" . $evento . "<br>";
        
        actualizarPrivacidadMuro2($usuario, $evento, $comentario, $mencion, $amistad);
        echo 'Actualizado!';
        
 }       
        
//        registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>