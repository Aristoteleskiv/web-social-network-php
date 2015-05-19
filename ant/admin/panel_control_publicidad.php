<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/encuestas.php';
include_once '../funciones/usuario.php';
include_once '../funciones/grupos.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
    ?>


    <br>
    <h1>Panel de control de publicidad</h1>
    <br>
    <br>
    Planes de publicidad pendientes
    <br><br>
    <span class="boton" id="linkCrearEncuesta">Crear encuesta</span>
    <script>
            $('#linkCrearEncuesta').click(function(){
                $.ajax({
                       type: "POST",
                       url: "formularios/crear_encuesta.php?p=1",
                       data: "",
                       success: function(msg){
                         $("#divCentro").html(msg);
                       }
                   });


           return false; 
           });
           
    </script>
    <br><br>
    <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td width="46"><b>Titulo</b></td>
		<td width="689"><b>Cuerpo</b></td>
		<td  width="20"><b>Usuarios</b></td>
		<td width="37"><b>Tipo</b></td>
                <td><b>Opciones</b></td>
                <td width="64"><b>Aprobar</b></td>
                <td width="64"><b>Eliminar</b></td>
	</tr>
    
        <?php
        
        $encuestas = getEncuestasPendientes();
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($encuestas); $i++){
            $id = $encuestas[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iTitulo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_encuesta.php?p=2",
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
                                url: "formularios/crear_encuesta.php?p=3",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    
                   $("#iUsuarios'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_encuesta.php?p=4",
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
                                url: "formularios/crear_encuesta.php?p=5",
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
                                url: "formularios/crear_encuesta.php?p=5",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iOpciones'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_encuesta.php?p=6",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    function eliminar'. $id . '(){
                        if (confirm("Estas seguro de eliminar la publicacion?")) {
                            $.ajax({
                                    type: "POST",
                                    url: "acciones/enviar_encuesta.php?p=12",
                                    data: "id='. $id . '",
                                    success: function(msg){
                                      $("#divCentro").load("admin/panel_control_encuestas.php");
                                    }
                                });
                            }
                    return false;
                    
                    }
                    function aprobar'. $id . '(){
                        $.ajax({
                                type: "POST",
                                url: "acciones/enviar_encuesta.php?p=10",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_encuestas.php");
                                }
                            });
                    return false;
                    
                    }
                    </script>

                        ';
            
            
            echo $scripts;
            
            
            
            
            
            $titulo = $encuestas[$i]["titulo"];
            
            $iTitulo = '<img id="iTitulo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            
            $cuerpo = nl2br($encuestas[$i]["cuerpo"]);
            if($cuerpo==null){
                $iCuerpo = $ii .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iCuerpo = $ic .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $usuarios = $encuestas[$i]["usuarios"];
            if($usuarios==null){
                $iUsuarios = $ii .'<img id="iUsuarios'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iUsuarios = $ic .'<img id="iUsuarios'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            
            $tipo = $encuestas[$i]["tipo"];
            switch ($tipo) {
                case 1:
                    $tipo1="Si/No";

                    break;
                case 2:
                    $tipo1="Varias respuestas";

                    break;
                case 3:
                    $tipo1="0/10";

                    break;
                
                default:
                    break;
            }
            
            if($tipo==null){
                $iTipo = $ii . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iTipo =  $tipo1 . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $opciones = nl2br($encuestas[$i]["opciones"]);
            if($opciones==null){
                $iOpciones = $ii .'<img id="iOpciones'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iOpciones = $ic .'<img id="iOpciones'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $formAprobar = '
                
                    <form>
                    <input onclick="javascript:aprobar'. $id . '(); return false;" type="submit" value="aprobar">
                    </form>

                        ';
            $formEliminar = '
                
                    <form>
                    <input onclick="javascript:eliminar'. $id . '(); return false;" type="submit" value="eliminar">
                    </form>

                        ';
            
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $titulo . $iTitulo . '</td>
                <td>'. $cuerpo. $iCuerpo . '</td>
                <td>'. $iUsuarios . '</td>
                <td>'. $iTipo . '</td>
                <td>'. $iOpciones . '</td>
                <td>'. $formAprobar . '</td>
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        
        ?>
        
        
        
    
    </table>
    <br>
    <br>
    
    Planes de publiciad aprobados
    <br><br>
    <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td ><b>Titulo</b></td>
		<td width="689"><b>Cuerpo</b></td>
		<td  width="20"><b>Usuarios</b></td>
		<td width="37"><b>Tipo</b></td>
                <td width="37"><b>%</b></td>
                <td width="64"><b>Desaprobar</b></td>
                <td width="64"><b>Eliminar</b></td>
	</tr>
    
        <?php
        
        $noticias = getEncuestasAprobadas();
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($noticias); $i++){
            $id = $noticias[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iTitulo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_encuesta.php?p=2",
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
                                url: "formularios/crear_encuesta.php?p=3",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    
                   $("#iUsuarios'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_encuesta.php?p=4",
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
                                url: "formularios/crear_encuesta.php?p=5",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    
                    function eliminar'. $id . '(){
                        if (confirm("Estas seguro de eliminar la publicacion?")) {
                            $.ajax({
                                    type: "POST",
                                    url: "acciones/enviar_encuesta.php?p=12",
                                    data: "id='. $id . '",
                                    success: function(msg){
                                      $("#divCentro").load("admin/panel_control_encuestas.php");
                                    }
                                });
                            }
                    return false;
                    
                    }
                    function desaprobar'. $id . '(){
                        $.ajax({
                                type: "POST",
                                url: "acciones/enviar_encuesta.php?p=11",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_encuestas.php");
                                }
                            });
                    return false;
                    
                    }
                    function previsualizar'. $id . '(){
                        $.ajax({
                                type: "POST",
                                url: "datos/previsualizar_encuesta.php",
                                data: "id='. $id . '",
                                success: function(msg){
                                     $("#divPrevisualizarEncuesta").html(msg);
                                }
                            });
                    return false;
                    
                    }
                    </script>

                        ';
            
            
            echo $scripts;
            
            
            
            
            
            $titulo = $noticias[$i]["titulo"];
            
            $iTitulo = '<img id="iTitulo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            
            $cuerpo = nl2br($noticias[$i]["cuerpo"]);
            if($cuerpo==null){
                $iCuerpo = $ii .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iCuerpo = $ic .'<img id="iCuerpo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $usuarios = $noticias[$i]["usuarios"];
            if($usuarios==null){
                $iUsuarios = $ii .'<img id="iUsuarios'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iUsuarios = $ic .'<img id="iUsuarios'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            
            $tipo = $noticias[$i]["tipo"];
            switch ($tipo) {
                case 1:
                    $tipo1="Si/No";

                    break;
                case 2:
                    $tipo1="Varias respuestas";

                    break;
                case 3:
                    $tipo1="0/10";

                    break;
                default:
                    break;
            }
            
            if($tipo==null){
                $iTipo = $ii . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iTipo =  $tipo1 . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $formAprobar = '
                
                    <form>
                    <input onclick="javascript:desaprobar'. $id . '(); return false;" type="submit" value="desaprobar">
                    </form>

                        ';
            $formEliminar = '
                
                    <form>
                    <input onclick="javascript:eliminar'. $id . '(); return false;" type="submit" value="eliminar">
                    </form>

                        ';
            
            $porcentaje ='
                
                    <form>
                    <input onclick="javascript:previsualizar'. $id . '(); return false;" type="submit" value="ver">
                    </form>


                    ';
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $titulo . $iTitulo . '</td>
                <td>'. $cuerpo. $iCuerpo . '</td>
                <td>'. $iUsuarios . '</td>
                <td>'. $iTipo . '</td>
                <td> '. $porcentaje . '</td>
                <td>'. $formAprobar . '</td>
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        
        ?>
        
        
        
    
    </table>
    <div id="divPrevisualizarEncuesta">
        
    </div>
    <br>
    <br>
    
    
        
    <?php
    }
    
}else{
    
}
 
?>


        
        