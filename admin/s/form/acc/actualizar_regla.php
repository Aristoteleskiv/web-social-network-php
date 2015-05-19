<?php




include_once '../../../../conf/conf.php';
include_once '../../../../func/panel_control.php';
include_once '../../../../conf/sesion.php';
//include_once '../func/seguimiento.php';
include_once '../../../../func/usuario.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
        $usuario = $_SESSION["usr"];
        //$usuario = $_SESSION["usr"];
        //$_SESSION["acc"] = $accActualizarReglaAdmin;
    
        $nivelUsuario = getNivelUsuario($usuario);
        if($nivelUsuario==3){
    
            $id = $_POST["id"];
            $estado = $_POST["estado"];


            actualizarRegla($id, $estado);

            echo "ID = $id, Estado = $estado. Regla cambiada";

            //$_SESSION["acc"] .= 'reg' . $id . 'est' . $estado;
            //$_SESSION["exi"] = 1;
        }else{
            //$_SESSION["exi"] = 0;
            echo "usuario no valido";
            echo $usuario;
        }
    
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
//    echo '<script>document.location="../index.php"</script>';
//}
?>


