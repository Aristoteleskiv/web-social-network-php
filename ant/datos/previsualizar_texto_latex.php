<?php



include_once '../config/configuracion.php';
include_once '../funciones/latex.php';
include_once '../funciones/usuario.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        
        $texto = $_POST["texto"];

        echo previsualizarLatex($texto);
        
    }
    
    
    
}else{
    echo '<script>document.location="index.php"</script>';
    
}







?>
