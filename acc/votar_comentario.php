<?php

include_once '../conf/conf.php';
include_once '../func/publicaciones.php';
include_once '../func/seguimiento.php';


//session_start();
include_once '../conf/sesion.php';
$usuario = $_SESSION["usr"];


//if(isset($_SESSION["usr"]) ){
$usuario = $_SESSION["usr"];
$nivel = 1;
if($usuario!=null){
    $id = $_POST["id"];
    $voto = $_POST["voto"];
    $idPublicacion = $_POST["id"];
    $posicion = $_POST["p"];

    votar($usuario, $idPublicacion, $posicion, $voto);
    //$_SESSION["exi"] = 1;
     
}else{
     echo "<span style='font-size: 10px;'>Solo para registrados</span>";
}    
    
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}




 
        
        
       
    


?>

