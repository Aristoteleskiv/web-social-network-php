<?php




include_once '../config/configuracion.php';
include_once '../funciones/muro.php';
include_once '../funciones/usuario.php';
include_once '../funciones/seguimiento.php';

session_start();


if(isset($_SESSION["usr"]) ){
   
        $_SESSION["acc"] = $accActualizarPrivacidad;
    
        $usuario = $_SESSION["usr"];
        
        $evento = $_GET["e"];
        $comentario = $_GET["c"];
        $mencion = $_GET["m"];
        $amistad = $_GET["a"];
        if($evento==null){$evento=0;}
        if($comentario==null){$comentario=0;}
        if($mencion==null){$mencion=0;}
        if($amistad==null){$amistad=0;}
        
        $idUsuario = getID($usuario);
        
        actualizarPrivacidadMuro($usuario, $evento, $comentario, $mencion, $amistad);
        echo "Actualizado!";
        echo '<script>
            
            window.setTimeout(function(){
                $("#divCentro").load("amigos.php?p='. $idUsuario .'");
            }, 1500);


            </script>
            ';
        
        $_SESSION["exi"] = 1;
        registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>