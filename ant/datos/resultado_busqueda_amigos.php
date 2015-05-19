<!DOCTYPE html>


<?php
  


include_once '../config/configuracion.php';
include_once '../funciones/usuario.php';
include_once '../clases/resultado_busqueda.php';
session_start();



if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    $busqueda = $_POST["persona"];
    
?>


<br>

        <?php
        
           
            $amigos = busquedaPersonas($usuario, $busqueda);
            
            if(count($amigos)==0){
            
                echo "No existen resultados para la busqueda";
            }else{
                 for($i=0; $i<count($amigos); $i++){
                    $usuarioEncontrado = $amigos[$i]["amigo"];
                    
                    $elementoUsuario = new resultadoBusquedaPersona($usuario, 
                                                        $usuarioEncontrado,  $i);
                   
                    echo $elementoUsuario->getHtml();
                }
            }

        
        ?>
            
    

<?php  }else{
    echo '<script>document.location="index.php"</script>';
} ?>