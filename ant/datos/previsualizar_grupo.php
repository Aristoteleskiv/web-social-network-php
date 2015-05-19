<?php


include_once '../config/configuracion.php';
include_once '../funciones/grupos.php';
include_once '../funciones/usuario.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $id = $_POST["id"];
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        
    
        $nombre = getNombreGrupo($id);

        if(isset($_POST["usuarios"])){
            $usuarios = $_POST["usuarios"];

            $usuarios = getTodosUsuariosDeGrupoConCampo($usuarios);

        }else{
            $usuarios = getTodosUsuariosDeGrupoConId($id);
        }

        echo "Grupo <b>" . $nombre . "</b><br>";
        echo "Numero de usuarios: " . count($usuarios) . "<br>";
        for($i=0; $i<count($usuarios); $i++){
            echo $usuarios[$i] . " ";
        }
    }
    
}else{
    echo '<script>document.location="index.php"</script>';
}
