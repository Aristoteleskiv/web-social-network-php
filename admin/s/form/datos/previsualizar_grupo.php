<?php


include_once '../../../../conf/conf.php';
include_once '../../../../conf/sesion.php';
include_once '../../../../func/grupos.php';
include_once '../../../../func/usuario.php';
include_once '../../../../func/usuario.php';



    
    $id = $_POST["id"];
    //$usuario = $_SESSION["usr"];
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
    
