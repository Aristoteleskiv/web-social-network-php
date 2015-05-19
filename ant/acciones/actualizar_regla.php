<?php




include_once '../config/configuracion.php';
include_once '../funciones/panel_control.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/usuario.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
        $usuario = $_SESSION["usr"];
        $_SESSION["acc"] = $accActualizarReglaAdmin;
    
        $nivel = getNivelUsuario($usuario);
        if($nivel==3){
    
            $id = $_POST["id"];
            $estado = $_POST["estado"];


            actualizarRegla($id, $estado);

            echo "ID = $id, Estado = $estado. Regla cambiada";

            $_SESSION["acc"] .= 'reg' . $id . 'est' . $estado;
            $_SESSION["exi"] = 1;
        }else{
            $_SESSION["exi"] = 0;
        }
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>


