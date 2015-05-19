<?php



include_once '../../../../conf/conf.php';
include_once '../../../../func/encuestas.php';
include_once '../../../../func/seguimiento.php';
include_once '../../../../func/usuario.php';
include_once '../../../../conf/sesion.php';
$usuario = $_SESSION["usr"];

$nivel = 4;
//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarEncuesta;
    
    
    
    //$usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);

    if($nivelUsuario == 3){
        //$_SESSION["exi"] = 1;
    $paso = $_GET["p"];
    //$autor = $_SESSION["usr"];

        switch ($paso) {
        case 1:
            $titulo = $_POST["titulo"];
            $id = crearEncuesta($autor, $titulo);
            //$_SESSION["acc"] .= "crear" . '|id' . $id;
            break;
        case 2:

            $titulo = $_POST["titulo"];

            $id = $_GET["id"]; 
            editarTituloEncuesta($id, $titulo);
            //$_SESSION["acc"] .= "editTitulo|id$id|" ;
            break;
        case 3:

            $cuerpo = $_POST["cuerpo"];

            //$cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
            $id = $_GET["id"]; 
            editarCuerpoEncuesta($id, $cuerpo);
            //$_SESSION["acc"] .= "editCuerpo|id$id|" ;
            break;
        case 4:

            $usuarios = $_POST["usuarios"];

            $id = $_GET["id"]; 
            editarUsuariosEncuesta($id, $usuarios);
            //$_SESSION["acc"] .= "editUsr|id$id|" ;
            break;
        case 5:

            $tipo = $_POST["tipo"];


            $id = $_GET["id"]; 

            switch ($tipo) {
                case 1:
                     editarOpcionesEncuesta($id, "Si\nNo");

                    break;
                case 2:
                    editarOpcionesEncuesta($id, null);
                    break;
                case 3:
                    editarOpcionesEncuesta($id, "0\n1\n2\n3\n4\n5\n6\n7\n8\n9\n10");
                    break;

                default:
                    break;
            }
            //$_SESSION["acc"] .= "editTipo|id$id|";
            editarTipoEncuesta($id, $tipo);

            break;
        case 6:

            $opciones = $_POST["opciones"];


            $id = $_GET["id"]; 

            //$_SESSION["acc"] .= "editOpciones|id$id|";
            editarOpcionesEncuesta($id, $opciones);

            break;

          case 10:  //aprobar


            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "aprobar|id$id|";
            aprobarEncuesta($id);

            break; 
        case 11:  //desaprobar


            $id = $_GET["id"]; 
            desaprobarEncuesta($id);
            //$_SESSION["acc"] .= "desaprobar|id$id|";
            break; 
        case 12:  //eliminar


            $id = $_GET["id"]; 
            eliminarEncuesta($id);
            //$_SESSION["acc"] .= "eliminar|id$id|";
            break; 
        default:
            break;
        }
    }
   
    
    
 //   registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
 //           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
//}else{
//    echo '<script>document.location="../index.php"</script>';
//    
////}







?>