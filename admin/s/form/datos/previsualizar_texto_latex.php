<?php



include_once '../../../../conf/conf.php';
include_once '../../../../conf/sesion.php';
include_once '../../../../func/latex.php';
include_once '../../../../func/usuario.php';


session_start();


//if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    //$usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);
    
    if($nivelUsuario == 3){
        
        $texto = $_POST["texto"];

        echo previsualizarLatex($texto);
        
    }
    
    
    
//}else{
//    echo '<script>document.location="index.php"</script>';
    
//}







?>
