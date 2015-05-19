<?php



include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../func/menciones_comentarios.php';
include_once '../func/usuario.php';
include_once '../func/secciones.php';
include_once '../func/otras.php';
include_once '../func/publicaciones.php';
include_once '../func/panel_control.php';

//session_start();


//if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    
    $id = $_POST["id"];
    $filtro = $_POST["filtro"];
    $nivel = $_POST["nivel"];
    //$usuario = $_SESSION["usr"];
    $comentariosPermitidos = getRegla(2);
    
    
    
    if($comentariosPermitidos==1){
        $salida = getTablaComentarios($id, $filtro, $nivel, $usuario);
    }else{
        $salida = "Comentarios temporalmente desactivados. Disculpen las molestias.";
    }
    echo $salida;

    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}




function getComentarios($id, $filtro, $nivel, $usuario){
    
   
    
    
    switch ($filtro) {
        case 1:

            $comentarios = getComentariosPorFecha($id);
            break;
        case 2:

            $comentarios = getComentariosPorRelevancia($id);
            break;
        case 3:
            $comentarios = array();
            if($usuario!=null){
                $comentarios = getComentariosSoloMenciones($id, $usuario);
            }
            break;
        case 4:
            $comentarios = array();
            if($usuario!=null){
                $comentarios = getComentariosSoloAmigos($id, $usuario);
            }
            break;

        default:
            break;
    }
        
    
        $s = getNiveles($nivel);
        
        $votarPos = $s ."images/header/vota_pos.png";
        $votarNeg = $s ."images/header/vota_neg.png";
        
      
       
        $salida = "";
  
        for($i=0; $i<count($comentarios); $i++){
            $posicion = $comentarios[$i]["posicion"];
            $autor = $comentarios[$i]["usuario"];
            $fecha =  $comentarios[$i]["fecha"];
            
            
            $cuerpo = $comentarios[$i]["cuerpo"];
            
            
            $cuerpo = sustituirMenciones($id, $cuerpo, $posicion, $fecha);
            
            $cuerpo = sustituirCitasNueva($cuerpo, $id, $posicion, $comentarios);
            
            
            
            $fecha = getFechaYHoraFormatoClaro($fecha);
            $urlImagen = getImagenDeUsuario( $comentarios[$i]["usuario"]);
            $idUsuario = getID($comentarios[$i]["usuario"]);
            
            $salida .= '
                <div style="margin: 5px; width:750px; text-align: left; margin-bottom: 20px;">
                
                    <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $urlImagen . '); background-repeat: no-repeat; width:  750px; float: left;">
                        
                        <a href="'. $s .'s/muro/?u='.$idUsuario.'"><div class="div-nombre-usuario" >@'.$autor.'</div></a>
                        <div class="div-posicion-comentario-usuario">#'.$posicion.'</div>
                        <div style=" " class="div-cuerpo-comentarios">'.$cuerpo.'</div>
                        <div style="text-align: center; margin-left: 186px; width:430px; display: inline-block;"><span class="indicadores-publicacion">'. $fecha . '</span></div>
                        <div id="divVotar'.$posicion.'" style=" width:122px; display: inline-block;">
                            <img onclick="javascript:votarComentario(\''. $id .'\' , \''. $posicion .'\' , \''. $nivel .'\', \'+1\')" class="imagen-menus-publicacion" src="'. $votarPos.  '">
                            <img onclick="javascript:votarComentario(\''. $id .'\' , \''. $posicion .'\' , \''. $nivel .'\', \'-1\')" class="imagen-menus-publicacion" src="'. $votarNeg.  '">
                    </div>

                    </div>
                    <br>
                    <hr style="clear: both;  margin-left: 186px; height: 1px; width: 50%;">
                    <div style=""></div>
                    
                    
                    

                </div>


                        ';
            
        }
        
        return $salida;
        
    }
    
function getTablaComentarios($id, $filtro, $nivel, $usuario){
        
        $comentariosParaUsuariosNoConfirmados = getRegla(3);
        $confirmado = comprobarSiUsuarioConfirmado_usuario($usuario);
        $s = getNiveles($nivel);
        $b11 = $b12 = $b21  = $b22 = $b31 = $b32 = $b41 = $b42 = "";
        
        
        if($filtro==1){
            $b11 = "<b>";
            $b12 = "</b>"; 
        }
        if($filtro==2){
            $b21 = "<b>";
            $b22 = "</b>"; 
        }
        if($filtro==3){
            $b31 = "<b>";
            $b32 = "</b>"; 
        }
        if($filtro==4){
            $b41 = "<b>";
            $b42 = "</b>"; 
        }

        $scriptToolTip="
        <script>            
        $(document).ready(function() {
                $('.masterTooltipComentarios').hover(function(){
                        var title = $(this).attr('title');

                        $(this).data('tipText', title).removeAttr('title');
                        $('<p class=\"tooltip\"></p>')
                        .text(title)
                        .appendTo('body')
                        .fadeIn('slow');
                }, function() {
                        $(this).attr('title', $(this).data('tipText'));
                        $('.tooltip').remove();
                }).mousemove(function(e) {
                       
                        var x = $(this).offset().left - ($('.tooltip').width() - $(this).width())/2;
                        var y = $(this).offset().top - $('.tooltip').height() -8 ; 
                        
                        $('.tooltip')
                        .css({ top: y, left: x});
                });
        });
        </script>
                    ";
        
        $formulario="";
        if($confirmado){
            $formulario = '<div id="divFormularioEnviarComentario">
                 <form id="formEnviarComentario">
                    <textarea name="cuerpo" id="cuerpo" cols="70" rows="8"></textarea><br>
                    <input type="hidden" name="id" value="'. $id . '">

                    <input type="submit" value="Enviar" onclick="javascript:enviarComentario(\''.$id.'\' ,\''.$nivel.'\' ,\''.$filtro.'\' );return false;">
                </form><br>
                </div>';
        }else{
            if($usuario==null){
                $formulario  ="<div>Para poder comentar debes registrarte. Es gratuito y tardas 1 minuto.<br><a href='".$s."user/registro' style='color: blue'>Registro</a></div>";
            }else{
                $formulario  ="<div>Para poder comentar debes validar tu cuenta de correo desde el panel de preferencias.<br><a href='".$s."pref' style='color: blue'>Preferencias</a></div>";
            }
        }
        
        $salida = $scriptToolTip . '
                 <div class="div-contenedor-botones-orden-comentarios">
  
                            <div class="botones-orden-comentarios" onclick="verComentariosPublicacion(\''. $id.'\', '. $nivel .', 1);">' . $b11 . 'Fecha' . $b12 . '</div>
                            <div class="botones-orden-comentarios" onclick="verComentariosPublicacion(\''. $id.'\', '. $nivel .', 2);">' . $b21 . 'Relevancia' . $b22 . '</div>
                            <div class="botones-orden-comentarios" onclick="verComentariosPublicacion(\''. $id.'\', '. $nivel .', 3);">' . $b31 . 'Solo menciones' . $b32 . '</div>
                            <div class="botones-orden-comentarios" onclick="verComentariosPublicacion(\''. $id.'\', '. $nivel .', 4);">' . $b41 . 'Solo amigos' . $b42 . '</div>
                    
                    '. getComentarios($id, $filtro, $nivel, $usuario) . '
                   
                </div>
                <br>' . $formulario;
        
        return $salida;
    }


?>

