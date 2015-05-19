<?php



include_once '../../../../conf/conf.php';
include_once '../../../../func/publicidad.php';
include_once '../../../../func/seguimiento.php';
include_once '../../../../func/usuario.php';

//session_start();
$usuario = $_SESSION["usr"];

//if(isset($_SESSION["usr"]) ){
    
    //$_SESSION["acc"] = $accEnviarNoticia;
    
$nivel = 4;    
        
    //$usuario = $_SESSION["usr"];
    $nivelUsuario = getNivelUsuario($usuario);

    
    if($nivelUsuario == 3){
        $paso = $_GET["p"];
        $autor = $usuario;
        //$_SESSION["exi"] = 1;
        switch ($paso) {
        case 1:
            
            $titulo = $_POST["titulo"];
            
            $id = crearPlanPublicidad($autor, $titulo);
            
            //$_SESSION["acc"] .= "crear" . '|id' . $id ;
            break;
        case 2:

            $titulo = $_POST["titulo"];

            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editTitulo|id$id|" ;
            editarTituloPlanPublicidad($id, $titulo);

            break;
        case 3:

            $cuerpo = $_POST["usuarios"];
           
            //$cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editCuerpo|id$id|" ;
            editarCampoUsuariosPlanPublicidad($id, $cuerpo);

            break;
        case 4:

            $accion = $_POST["accion"];
            
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editUsr|id$id|" ;
            editarAccionPlanPublicidad($id, $accion);

            break;
        case 5:

            $modulos = $_POST["modulos"];
            
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editUsr|id$id|" ;
            editarModulosPlanPublicidad($id, $modulos);

            break;

          case 10:  //aprobar

            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "aprobar|id$id|";
            aprobarPlanPublicidad($id);

            break; 
        case 11:  //desaprobar

            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "desaprobar|id$id|" ;
            desaprobarPlanPublicidad($id);

            break; 
        case 12:  //eliminar


            $id = $_GET["id"];
            //$_SESSION["acc"] .= "eliminar|id$id|" ;
            eliminarPlanPublicidad($id);

            break; 
        default:
            break;
        }
    }else{
         //$_SESSION["exi"] = 0;
    }
    
    
//    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
//            $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    
    
//}else{
 //   echo '<script>document.location="../index.php"</script>';
    
//}







?>