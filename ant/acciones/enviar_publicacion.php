<?php



include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/publicaciones_editor.php';
include_once '../funciones/latex.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/usuario.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    $_SESSION["acc"] = $accEnviarPublicacion;
    
    
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);


    if($nivel == 3){
        $paso = $_GET["p"];
        $autor = $_SESSION["usr"];
        $_SESSION["exi"] = 1;

        switch ($paso) {
        case 1:
            $titulo = $_POST["texto"];

            $titulo = sustituirLatexPorImagenes($titulo);

            $id = crearPublicacion($autor, null, $titulo, null, null, null, null, null);
            $_SESSION["acc"] .= "crear" . '|id' . $id;
            break;
        case 2:

            $titulo = $_POST["texto"];


            $titulo = sustituirLatexPorImagenes($titulo);
            
            
            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editTitulo|id$id|";
            editarPublicacionTitulo($id, $titulo);
            
            break;
        case 3:

            $cuerpo = $_POST["texto"];

            $cuerpo = sustituirLatexPorImagenes($cuerpo);
            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editCuerpo|id$id|";
            editarPublicacionCuerpo($id, $cuerpo);

            break;
        case 4:

            $ayudas = $_POST["ayudas"];

            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editAyudas|id$id|";
            editarPublicacionAyudasBusqueda($id, $ayudas);

            break;
        case 5:

            $tipo = $_POST["tipo"];

            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editTipo|id$id|";
            editarPublicacionTipoDocumento($id, $tipo);

            break;
        case 6:

            $ref = $_POST["referencia"];
            $server = $_POST["servidor"];
            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editVideo|id$id|";
            editarPublicacionVideo($id, $server, $ref);

            break;

        case 7:

            $nombre = $_POST["nombre"];
            $id = $_GET["id"]; 
            $_SESSION["acc"] .= "editPdf|id$id|";
            $tipo = getTipoDocumentoPublicacion($id);
            if($tipo == 1){

                $autor = getAutorPublicacion($id);
                $titulo = getTituloPublicacion($id);
                $tipoDocumento = 2;
                $cuerpo = getCuerpoPublicacion($id);
                $ayudas = getAyudasALaBusquedaPublicacion($id);
                $idNueva = crearPublicacion($autor, $cuerpo, $titulo, $tipoDocumento, null, $ayudas, null, $id);


                editarPublicacionPdf($idNueva, $nombre);
                editarPublicacionMaterialComplementario($id, $idNueva);


            }else{
                editarPublicacionPdf($id, $nombre);
            }


            break;
        case 8:  //aprobar


            $id = $_POST["id"]; 
            $_SESSION["acc"] .= "aprobar|id$id|";
            editarPublicacionAprobar($id);

            break;   
         case 9:  //desaprobar


            $id = $_POST["id"]; 
            $_SESSION["acc"] .= "desaprobar|id$id|" ;
            editarPublicacionDesaprobar($id);

            break;  
          case 10:  //eliminar


            $id = $_POST["id"]; 
            $_SESSION["acc"] .= "eliminar|id$id|";
            eliminarPublicacion($id);

            break; 
        default:
            break;
        }
    }else{
        $_SESSION["exi"] = 0;
    }
    
    
    
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
}else{
    echo '<script>document.location="../index.php"</script>';
    
}







?>