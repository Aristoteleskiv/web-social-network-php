<?php



include_once '../../../../conf/conf.php';
include_once '../../../../func/publicaciones.php';
include_once '../../../../func/colecciones.php';
include_once '../../../../func/latex.php';
//include_once '../func/seguimiento.php';
include_once '../../../../func/usuario.php';
include_once '../../../../conf/sesion.php';

$nivel = 4;
//session_start();


//if(isset($_SESSION["usr"]) ){
    

    //$_SESSION["acc"] = $accEnviarColeccion;
    
    
    //$usuario = $_SESSION["usr"];
    $usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);
    
    if($nivelUsuario == 3){

        //$_SESSION["exi"] = 1;
        $paso = $_GET["p"];
        
        $autor = $usuario;

        switch ($paso) {
        case 1:
            $titulo = $_POST["texto"];

            $titulo = sustituirLatexPorImagenes($titulo);
            
            $id = crearColeccion($titulo, null, null, $autor);
            
            //$_SESSION["acc"] .= "crear" . '|id' . $id ;
            break;
        case 2:

            $nombre = $_POST["texto"];


            $nombre = sustituirLatexPorImagenes($nombre);
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editTitulo|id$id|";
            editarColeccionNombre($id, $nombre);

            break;
        case 3:

            $cuerpo = $_POST["texto"];

            $cuerpo = sustituirLatexPorImagenes($cuerpo);
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editDescrip|id$id|";
            editarColeccionDescripcion($id, $cuerpo);

            break;
        case 4:

            $imagen = $_POST["imagen"];

            $id = $_GET["id"];
            //$_SESSION["acc"] .= "editImag|id$id|";
            editarColeccionImagen($id, $imagen);

            break;

        case 5:

            $col = $_POST["coleccion"];
            $formato = $_POST["formato"];

            $id = $_GET["id"];
            //$_SESSION["acc"] .= "editTipoColec|id$id|";
            editarFormatoColeccion($id, $formato);
            editarColeccionColeccion($id, $col);

            break;

        case 6:

            $ref = $_POST["texto"];

            $id = $_GET["id"];
            //$_SESSION["acc"] .= "editRefe|id$id|";
            editarColeccionRef($id, $ref);

            break;    

        case 8:  //aprobar

            
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "aprobar|id$id|";
            editarColeccionAprobar($id);

            break;   
         case 9:  //desaprobar

            
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "desaprobar|id$id|";
            editarColeccionDesaprobar($id);

            break;  
          case 10:  //eliminar

            
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "eliminar|id$id|";
            eliminarColeccion($id);

            break; 
        default:
            break;
        }


    }else{
        //$_SESSION["exi"] = 0;
    }
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//           $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
//}else{
    
//    echo '<script>document.location="../index.php"</script>';
//}







?>