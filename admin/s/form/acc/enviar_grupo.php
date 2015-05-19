<?php



include_once '../../../../conf/conf.php';
include_once '../../../../func/grupos.php';
include_once '../../../../func/seguimiento.php';
include_once '../../../../func/usuario.php';
include_once '../../../../conf/sesion.php';
//session_start();

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarGrupo;
    
    
    $usuario = $_SESSION["usr"];
    
    $nivelUsuario = getNivelUsuario($usuario);

    if($nivelUsuario == 3){
        //$_SESSION["exi"] = 1;
        $paso = $_GET["p"];
        $autor = $usuario;

        switch ($paso) {
        case 1:
            $nombre = $_POST["nombre"];
            $id = crearGrupo($usuario, $nombre);
            //$_SESSION["acc"] .= "crear" . '|id' . $id ;
            break;
        case 2:

            $nombre = $_POST["nombre"];

            $id = $_GET["id"]; 
            editarNombreGrupo($id, $nombre);
            //$_SESSION["acc"] .= "editNombre|id$id|" ;
            break;
        case 3:

            $cuerpo = $_POST["cuerpo"];

            $id = $_GET["id"]; 
            editarDescripcionGrupo($id, $cuerpo);
            //$_SESSION["acc"] .= "editCuerpo|id$id|" ;
            break;
        case 4:

            $usuarios = $_POST["usuarios"];

            $id = $_GET["id"]; 
            editarUsuariosGrupo($id, $usuarios);
            //$_SESSION["acc"] .= "editUsr|id$id|" ;
            break;
        case 5:

            $tipo = $_POST["tipo"];

            $id = $_GET["id"]; 
            editarTipoGrupo($id, $tipo);
            //$_SESSION["acc"] .= "editTipo|id$id|" ;
            break;

          case 10:  //eliminar


            $id = $_GET["id"]; 
            eliminarGrupo($id);
            //$_SESSION["acc"] .= "eliminar|id$id|";
            break; 
        default:
            break;
        }
    }else{
        //$_SESSION["exi"] = 0;
    }
    
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
    
//}







?>