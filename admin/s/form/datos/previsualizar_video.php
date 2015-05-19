<?php

include_once '../../../../conf/conf.php';
include_once '../../../../conf/sesion.php';
include_once '../../../../func/usuario.php';

//session_start();


//if(isset($_SESSION["usr"]) ){
    //$usuario = $_SESSION["usr"];
    $usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);
    if($nivelUsuario == 3){
        $ref = $_POST["referencia"];

        $url = '//www.youtube.com/embed/' . $ref;
        $salida = '<iframe width="620" height="465" src="' . $url . '" frameborder="0" allowfullscreen></iframe>';


        echo $salida;
    }

    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}


