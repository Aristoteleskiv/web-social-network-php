<?php



include_once '../../../../conf/conf.php';
include_once '../../../../func/noticias.php';
include_once '../../../../func/seguimiento.php';
include_once '../../../../func/usuario.php';
include_once '../../../../conf/sesion.php';
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
            $id = crearNoticia($autor, $titulo);
            //$_SESSION["acc"] .= "crear" . '|id' . $id ;
            break;
        case 2:

            $titulo = $_POST["titulo"];

            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editTitulo|id$id|" ;
            editarTituloNoticia($id, $titulo);

            break;
        case 3:

            $cuerpo = $_POST["cuerpo"];

            //$cuerpo = str_replace("&lt;br /&gt;", " <br> ", $cuerpo);
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editCuerpo|id$id|" ;
            editarCuerpoNoticia($id, $cuerpo);

            break;
        case 4:

            $usuarios = $_POST["usuarios"];

            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editUsr|id$id|" ;
            editarUsuariosNoticia($id, $usuarios);

            break;
        case 5:

            $tipo = $_POST["tipo"];

            if($tipo==2){
                $dia1=$_POST["dia1"];
                $dia2=$_POST["dia2"];
                $mes1=$_POST["mes1"];
                $mes2=$_POST["mes2"];
                $ano1=$_POST["ano1"];
                $ano2=$_POST["ano2"];
            }else{
                $dia1=null;
                $dia2=null;
                $mes1=null;
                $mes2=null;
                $ano1=null;
                $ano2=null;
            }
            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "editTipo|id$id|" ;

            editarTipoNoticia($id, $tipo, $dia1, $dia2, $mes1, $mes2, $ano1, $ano2);

            break;

          case 10:  //aprobar


            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "aprobar|id$id|";
            aprobarNoticia($id);

            break; 
        case 11:  //desaprobar


            $id = $_GET["id"]; 
            //$_SESSION["acc"] .= "desaprobar|id$id|" ;
            desaprobarNoticia($id);

            break; 
        case 12:  //eliminar


            $id = $_GET["id"];
            //$_SESSION["acc"] .= "eliminar|id$id|" ;
            eliminarNoticia($id);

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