<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/noticias.php';
include_once '../funciones/usuario.php';
include_once '../funciones/grupos.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
    ?>


    <br>
    <h1>Panel de control de noticias</h1>
    <br>
    <br>
    Noticias pendientes
    <br><br>
    <span class="boton" id="linkCrearNoticia">Crear noticia</span>
    <script>
            $('#linkCrearNoticia').click(function(){
                $.ajax({
                       type: "POST",
                       url: "formularios/crear_noticia.php?p=1",
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

                <td width="64"><b>Aprobar</b></td>
                <td width="64"><b>Eliminar</b></td>
	</tr>
    
        <?php
        
        $noticias = getNoticiasPendientes();
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($noticias); $i++){
            $id = $noticias[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iTitulo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_noticia.php?p=2",
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
                                url: "formularios/crear_noticia.php?p=3",
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
                                url: "formularios/crear_noticia.php?p=4",
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
                                url: "formularios/crear_noticia.php?p=5",
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
                                    url: "acciones/enviar_noticia.php?p=12",
                                    data: "id='. $id . '",
                                    success: function(msg){
                                      $("#divCentro").load("admin/panel_control_noticias.php");
                                    }
                                });
                            }
                    return false;
                    
                    }
                    function aprobar'. $id . '(){
                        $.ajax({
                                type: "POST",
                                url: "acciones/enviar_noticia.php?p=10",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_noticias.php");
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
                    $tipo1="Indefinido";

                    break;
                case 2:
                    $tipo1="Entre dos fechas";

                    break;
                case 3:
                    $tipo1="Pulsar cerrar";

                    break;
                case 4:
                    $tipo1="Aceptar terminos";

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
                    <input onclick="javascript:aprobar('. $id . '); return false;" type="submit" value="aprobar">
                    </form>

                        ';
            $formEliminar = '
                
                    <form>
                    <input onclick="javascript:eliminar('. $id . '); return false;" type="submit" value="eliminar">
                    </form>

                        ';
            
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $titulo . $iTitulo . '</td>
                <td>'. $cuerpo. $iCuerpo . '</td>
                <td>'. $iUsuarios . '</td>
                <td>'. $iTipo . '</td>
                
                <td>'. $formAprobar . '</td>
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        
        ?>
        
        
        
    
    </table>
    <br>
    <br>
    
    Noticias aprobadas
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
        
        $noticias = getNoticiasAprobadas();
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($noticias); $i++){
            $id = $noticias[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iTitulo'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_noticia.php?p=2",
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
                                url: "formularios/crear_noticia.php?p=3",
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
                                url: "formularios/crear_noticia.php?p=4",
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
                                url: "formularios/crear_noticia.php?p=5",
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
                                    url: "acciones/enviar_noticia.php?p=12",
                                    data: "id='. $id . '",
                                    success: function(msg){
                                      $("#divCentro").load("admin/panel_control_noticias.php");
                                    }
                                });
                            }
                    return false;
                    
                    }
                    function desaprobar'. $id . '(){
                        $.ajax({
                                type: "POST",
                                url: "acciones/enviar_noticia.php?p=11",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_noticias.php");
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
                    $tipo1="Indefinido";

                    break;
                case 2:
                    $tipo1="Entre dos fechas";

                    break;
                case 3:
                    $tipo1="Pulsar cerrar";

                    break;
                case 4:
                    $tipo1="Aceptar terminos";

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
            
            $campoUsuarios = getCampoUsuariosNoticia($id);
            $usuarios = getTodosUsuariosDeGrupoConCampo($campoUsuarios);
            $numeroUsuarios = count($usuarios);
            
            $vistas = getVistasNoticia($id);
            $porcentajeVistas = (int)($vistas*100/$numeroUsuarios);
            $cerrados = getCerradosNoticia($id);
            $porcentajeCerrados = (int)($cerrados*100/$numeroUsuarios);
            
            
            $porcentaje = "V:$vistas<br>($porcentajeVistas%)";
            $porcentaje .= "<br>C:$cerrados<br>($porcentajeCerrados%)<br>T:$numeroUsuarios";
            
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
    <br>
    <br>
    
    
        
    <?php
    }
    
}else{
    
}
 
?>


        
        