<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
    ?>


    
    <h1>Menu editor</h1>
        <br>
        
        <br>
        
        
        
        
        
        
        
        Publicaciones aprobadas: <br>
        <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td width="689"><b>Titulo</b></td>
		<td width="46"><b>Cuerpo</b></td>
		<td><b>Ayudas</b></td>
		<td width="37"><b>Tipo</b></td>
		<td width="45"><b>Video</b></td>
		<td width="30"><b>PDF</b></td>
		<td width="64"><b>Desaprobar</b></td>
                <td width="64"><b>Eliminar</b></td>
	</tr>
    
        <?php 
        
        $publicaciones = getPublicacionesAprobadasDeAutor($usuario);
        
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($publicaciones); $i++){
            $id = $publicaciones[$i]["id"];
             
            $scripts='
                
                    <script>    
                    $("#iTitulo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=2&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iCuerpo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=3&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    
                    $("#iAyuda'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=4&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iTipo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=5&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iVideo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=6&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iPdf'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_publicacion.php?p=7&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    
                    function desaprobar'. $id . '(){
                        
                        $.ajax({
                                type: "POST",
                                url: "acciones/enviar_publicacion.php?p=9&a=a",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_publicaciones_aprobadas.php");
                                }
                            });

                    return false;
                    
                    }
                    </script>

                        ';
            
            
            echo $scripts;
            
            
            
            
            
            $titulo = $publicaciones[$i]["titulo"];
            
            $iTitulo = '<img id="iTitulo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            
            $cuerpo = $publicaciones[$i]["cuerpo"];
            if($cuerpo==null){
                $iCuerpo = $ii .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iCuerpo = $ic .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $ayuda = $publicaciones[$i]["ayuda_busqueda"];
            if($ayuda==null){
                $iAyuda = $ii .'<img id="iAyuda'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iAyuda = $ic .'<img id="iAyuda'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $tipo = $publicaciones[$i]["tipo_documento"];
            switch ($tipo) {
                case 1:
                    $tipo1="video";

                    break;
                case 2:
                    $tipo1="pdf";

                    break;
                default:
                    break;
            }
            
            if($tipo==null){
                $iTipo = $ii . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iTipo =  $tipo1 . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            

            
            if($tipo==null){
                    $iVideo = $ii . '<img id="iVideo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    $iPdf =  $ii . '<img id="iPdf'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                
                if($tipo==1){
                    $pdf = getIdMaterialComplementarioPublicacion($id);
                    $video = getIDReferenciaVideoPublicacion($id);
                    if($pdf==0){
                        $iPdf =  '<img id="iPdf'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }else{
                        $iPdf =  $ic . '<img id="iPdf'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }
                    
                    if($video==null){
                        $iVideo = $ii . '<img id="iVideo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }else{
                        $iVideo = $ic . '<img id="iVideo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }
                    
                    
                }else{  //tipo = 2
                    $pdf = getIDReferenciaPDFPublicacion($id);
                    $video = getIdMaterialComplementarioPublicacion($id);
                    if($pdf==null){
                        $iPdf =  $ii . '<img id="iPdf'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }else{
                        $iPdf =  $ic . '<img id="iPdf'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }
                    if($video==0){
                        $iVideo = '<img id="iVideo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }else{
                        $iVideo = $ic . '<img id="iVideo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
                    }
                }
                
            }
            
            
            
           
            
            $formEnviar = '
                
                    <form>
                    <input onclick="javascript:desaprobar'. $id . '(); return false;"  type="submit" value="desaprobar">
                    </form>

                        ';
            $formEliminar = '
                
                    <form>
                    <input type="submit" value="eliminar">
                    </form>

                        ';
            
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $titulo . $iTitulo . '</td>
                <td>'. $iCuerpo . '</td>
                <td>'. $iAyuda . '</td>
                <td>'. $iTipo . '</td>
                <td>'. $iVideo . '</td>
                <td>'. $iPdf . '</td>
                <td>'. $formEnviar . '</td>
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        ?>
        </table>
        <br><br>
        <script>
            $('#linkCrearPublicacion').click(function(){
                $.ajax({
                       type: "POST",
                       url: "formularios/crear_publicacion.php?p=1&a=a",
                       data: "",
                       success: function(msg){
                         $("#divCentro").html(msg);
                       }
                   });


           return false; 
           });
           
        </script>

    <?php
    }
    
}else{
    
}
 
?>


        
        