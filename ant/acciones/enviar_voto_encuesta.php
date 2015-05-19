<!DOCTYPE html>
<?php


include_once '../config/configuracion.php';
include_once '../funciones/encuestas.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/grupos.php';
session_start();


if(isset($_SESSION["usr"]) ){

    $_SESSION["acc"] = $accEnviarVotoEncuesta;
    
    
    
    
    $usuario = $_SESSION["usr"];
    $id = $_POST["id"];

    $voto = $_POST["voto"];
    $tipo = $_POST["tipo"];

    $campo = getCampoUsuariosEncuesta($id);

    //comprobar si ya se ha votado, o si este usuario esta dentro del grupo
    if(comprobarSiEncuestaExiste($id)){

         if(!comprobarSiEncuestaVotada($usuario, $id) AND 
            comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $campo)){

             echo "Gracias por votar";
             marcarVotadaEncuesta($id, $usuario, $voto);
             $_SESSION["acc"] .= "enc$id|voto$voto";
             $_SESSION["exi"] = 1;

         }else{
            $_SESSION["acc"] .= "enc$id|voto$voto";
            $_SESSION["exi"] = 0;
            echo "Ha habido un error al votar";
         }
    }else{
        $_SESSION["acc"] .= "enc$id|voto$voto";
        $_SESSION["exi"] = 0;
        echo "Ha habido un error al votar";
    }
    

    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>
 