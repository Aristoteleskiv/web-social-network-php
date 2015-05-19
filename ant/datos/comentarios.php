<?php



include_once '../config/configuracion.php';
include_once '../funciones/menciones_comentarios.php';
include_once '../funciones/usuario.php';
include_once '../funciones/panel_control.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    
    $id = $_POST["id"];
    $filtro = $_POST["filtro"];
    $usuario = $_SESSION["usr"];
    $comentariosPermitidos = getRegla(2);
    $comentariosParaUsuariosNoConfirmados = getRegla(3);
    
    if($comentariosPermitidos==1){
        if($comentariosParaUsuariosNoConfirmados==1){
            $salida = getScriptEnviarComentario() . getTablaComentarios();
        }else{
            $confirmado = comprobarSiUsuarioConfirmado_usuario($usuario);
            if($confirmado){
                $salida = getScriptEnviarComentario() . getTablaComentarios();
            }else{
                $salida = "Para poder participar en los comentarios debes confirmar la cuenta de correo electronico en el apartado Preferencias.";
            }
        }
        
    }else{
        $salida = "Comentarios temporalmente desactivados. Disculpen las molestias.";
    }
    echo $salida;

    
}else{
    echo '<script>document.location="index.php"</script>';
}




function getComentarios(){
    
    global $id;
    global $usuario;
    global $filtro;
    
    
    switch ($filtro) {
        case 1:

            $comentarios = getComentariosPorFecha($id);
            break;
        case 2:

            $comentarios = getComentariosPorRelevancia($id);
            break;
        case 3:
            $comentarios = getComentariosSoloMenciones($id, $usuario);

            break;
        case 4:

            $comentarios = getComentariosSoloAmigos($id, $usuario);
            break;

        default:
            break;
    }
        
    
    
        
        $votarPos = "images/header/vota_pos.png";
        $votarNeg = "images/header/vota_neg.png";
        
        $salida = '$("#linkVotarNegativo'. $posicion . '").click(function(){

                        $.ajax({
                            type: "POST",
                            url: "acciones/votar_comentario.php",
                            data: "id='. $id .'&posicion='. $posicion . '&voto=-1",
                            success: function(msg){
                              $("#divVotar'. $posicion . '").html(msg);
                            }
                        });

                    return false; 
                    });
                                ';
        
        
       $salida = '<script>
                          
                    function votarNegativo(id, p){
                    
                        $.ajax({
                                type: "POST",
                                url: "acciones/votar_comentario.php",
                                data: "id=" + id + "&posicion=" + p + "&voto=-1",
                                success: function(msg){
                                  $("#divVotar" + p).html(msg);
                                }
                            });
                    }
                    function votarPositivo(id, p){
                    
                        $.ajax({
                                type: "POST",
                                url: "acciones/votar_comentario.php",
                                data: "id=" + id + "&posicion=" + p + "&voto=1",
                                success: function(msg){
                                  $("#divVotar" + p).html(msg);
                                }
                            });
                    }

                    </script>'; 
        
        
        
        
        
        
        for($i=0; $i<count($comentarios); $i++){
            $posicion = $comentarios[$i]["posicion"];
            $autor = $comentarios[$i]["usuario"];
            $fecha =  $comentarios[$i]["fecha"];
            $styleImagen= 'background-image: 
                url(images/imagenes_usuarios/'. getImagenDeUsuario( $comentarios[$i]["usuario"]) . ');
                background-repeat: no-repeat;
                background-position: 0px 0px;
                width: 180px;
                ';
            
            $cuerpo = $comentarios[$i]["cuerpo"];
            
            
            $cuerpo = sustituirMenciones($id, $cuerpo, $posicion);
            
            $cuerpo = sustituirCitas($cuerpo, $id, $posicion);
            
            
            $salida .= '<tr>
                        <td valign="top" rowspan="2" style="'. $styleImagen .  '"><div class="div-nombre-usuario-en-comentario"><span class="nombre-usuario">@' . $autor . '</span></div><span class="numero-hastag-comentario">#'. $posicion . '</span></td>
                            <td colspan="3" style="text-align: left;"><div  id="marcaComentario'. $posicion . '">' . $cuerpo . '</div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span class="indicadores-publicacion">'. $fecha . '</span>
                            </td>
                            <td>
                                <div style="float: right;" id="divVotar'. $posicion . '">'  . ''
                    . '         <img onclick="votarPositivo(\''. $id .'\' , \''. $posicion .'\')" class="imagen-menus-publicacion" src="'. $votarPos.  '">'
                    . '         <img onclick="votarNegativo(\''. $id .'\' , \''. $posicion .'\')" class="imagen-menus-publicacion" src="'. $votarNeg.  '">' . '</div>
                                
                            </td>    
                        </tr>
                        <tr><td colspan="4"><hr></td></tr>
                        
                        ';
            
            
        }
        
        return $salida;
        
    }
    
    function getTablaComentarios(){
        global $id;
        global $filtro;
        
        
        
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
        
        
        $formulario = getFormularioEnviarComentario();
        
        $salida = '
            
            <script>
            
                $("#linkFiltroFecha").click(function(){
                    
                        $.ajax({
                            type: "POST",
                            url: "datos/comentarios.php",
                            data: "id='. $id .'&filtro=1",
                            success: function(msg){
                              $("#divComentarios").html(msg);
                            }
                        });

                return false; 
                });
                $("#linkFiltroAmigos").click(function(){
                    
                    $.ajax({
                            type: "POST",
                            url: "datos/comentarios.php",
                            data: "id='. $id .'&filtro=4",
                            success: function(msg){
                              $("#divComentarios").html(msg);
                            }
                        });


                return false; 
                });
                $("#linkFiltroRelevancia").click(function(){
                    
                    $.ajax({
                            type: "POST",
                            url: "datos/comentarios.php",
                            data: "id='. $id .'&filtro=2",
                            success: function(msg){
                              $("#divComentarios").html(msg);
                            }
                        });


                return false; 
                });
                $("#linkFiltroMenciones").click(function(){
                    
                    $.ajax({
                            type: "POST",
                            url: "datos/comentarios.php",
                            data: "id='. $id .'&filtro=3",
                            success: function(msg){
                              $("#divComentarios").html(msg);
                            }
                        });


                return false; 
                });

            </script>
                
                <div id="divFiltrosComentarios">
                    <table width="100%">
                        <tr>
                            <td width="25%"><a id="linkFiltroFecha" href="#" class="botones-orden-comentarios">' . $b11 . 'Fecha' . $b12 . '</a></td>
                            <td width="25%"><a id="linkFiltroRelevancia" href="#" class="botones-orden-comentarios">' . $b21 . 'Relevancia' . $b22 . '</a></td>
                            <td width="25%"><a id="linkFiltroMenciones" href="#" class="botones-orden-comentarios">' . $b31 . 'Solo menciones' . $b32 . '</a></td>
                            <td width="25%"><a id="linkFiltroAmigos" href="#" class="botones-orden-comentarios">' . $b41 . 'Solo amigos' . $b42 . '</a></td>
                        </tr>
                    
                    '. getComentarios() . '
                    </table>
                </div>
                <br>      
                <div id="divFormularioEnviarComentario">
                
                    '. $formulario . '
                </div>

           
            ';
        
        return $salida;
    }
    
    
    
    function getFormularioEnviarComentario(){
        global $id;
        $salida = '
            <form id="formEnviarComentario">
                <textarea name="cuerpo" id="cuerpo" cols="70" rows="8"></textarea><br>
                <input type="hidden" name="id" value="'. $id . '">

                <input type="submit" value="Enviar" onclick="javascript:enviarComentario();return false;">
            </form><br><br>
                ';
        
        return $salida;
    }
    
    
    
    
    
    function getScriptEnviarComentario(){
        global $id;
        global $filtro;
        $salida = '
        <script>
            function enviarComentario() {
                $.ajax({
                    type: "POST",
                    url: "acciones/enviar_comentario.php",
                    data: $("#formEnviarComentario").serialize(),
                    success: function(msg){
                      $("#divFormularioEnviarComentario").html(msg);
                         setTimeout(function(){

                              $.ajax({
                               type: "POST",
                               url: "datos/comentarios.php",
                               data: "id='. $id .'&filtro='. $filtro .'",
                               
                               success: function(msg){
                               $("#divComentarios").html(msg);
                               }
                           });



                       }, 2000);
                    }
                });
            }
        </script>

            ';
        
        return $salida;
    }



?>

