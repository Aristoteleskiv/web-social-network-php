<!DOCTYPE html>
<?php


include_once '../conf/conf.php';
include_once '../func/encuestas.php';
include_once '../func/seguimiento.php';
include_once '../func/grupos.php';
//session_start();
include_once '../conf/sesion.php';

//if(isset($_SESSION["usr"]) ){

    //$_SESSION["acc"] = $accEnviarVotoEncuesta;
    
$usuario = $_SESSION["usr"];
$nivel = 1;   
    
if($usuario!=null){   
    //$usuario = $_SESSION["usr"];
   
    $id = $_POST["id"];

    $voto = $_POST["voto"];
    

    $campo = getCampoUsuariosEncuesta($id);

    //comprobar si ya se ha votado, o si este usuario esta dentro del grupo
    if(comprobarSiEncuestaExiste($id)){

         if(!comprobarSiEncuestaVotada($usuario, $id) AND 
            comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $campo)){

             echo "Gracias por votar";
             marcarVotadaEncuesta($id, $usuario, $voto);
             //$_SESSION["acc"] .= "enc$id|voto$voto";
             //$_SESSION["exi"] = 1;

         }else{
            //$_SESSION["acc"] .= "enc$id|voto$voto";
            //$_SESSION["exi"] = 0;
            echo "Ha habido un error al votar";
         }
    }else{
        //$_SESSION["acc"] .= "enc$id|voto$voto";
        //$_SESSION["exi"] = 0;
        echo "Ha habido un error al votar";
    }
    
}
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>
 