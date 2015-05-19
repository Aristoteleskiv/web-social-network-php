
<?php
include_once '../config/configuracion.php';
include_once '../funciones/colecciones.php';

include_once '../funciones/usuario.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
    ?>
    
    <h1>Menu colecciones</h1>
        <br>
        
        <script>
            $('#linkCrearColeccion').click(function(){
                $.ajax({
                       type: "POST",
                       url: "formularios/crear_coleccion.php?p=1",
                       data: "",
                       success: function(msg){
                         $("#divCentro").html(msg);
                       }
                   });


           return false; 
           });
           
        </script>
        
        
        
        <span class="boton" id="linkCrearColeccion">Crear coleccion</span><br><br>
        

        
    Colecciones aprobadas: <br>
        <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td><b>Nombre</b></td>
		<td><b>Descripcion</b></td>
                <td><b>Coleccion de</b></td>
                <td><b>Referencias</b></td>
                
		<td width="20"><b>Imagen</b></td>
                <td width="20"><b>Desaprobar</b></td>
                <td width="20"><b>Eliminar</b></td>
                
		
	</tr>
    
        <?php 
        
        $colecciones = getColeccionesAprobadas($usuario);
        
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($colecciones); $i++){
            $id = $colecciones[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iNombre'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_coleccion.php?p=2",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iDescripcion'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_coleccion.php?p=3",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iImagen'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_coleccion.php?p=4",
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
                                url: "acciones/enviar_coleccion.php?p=9",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").load("admin/panel_control_colecciones_aprobadas.php");
                                }
                            });

                    return false;
                    }
                    
                    
                    $("#iRef'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_coleccion.php?p=6",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    $("#iCol'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_coleccion.php?p=5",
                                data: "id='. $id . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });

                    return false; 
                    });
                    </script>

                        ';
            
            
            echo $scripts;

            
            $nombre = $colecciones[$i]["nombre"];
            
            $iNombre = '<img id="iNombre'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            
            $descripcion = $colecciones[$i]["descripcion"];
            if($descripcion==null){
                $iDescripcion = $ii .'<img id="iDescripcion'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iDescripcion = $ic .'<img id="iDescripcion'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $imagen = $colecciones[$i]["imagen"];
            if($imagen==null){
                $iImagen = $ii .'<img id="iImagen'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iImagen = $ic .'<img id="iImagen'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            

            $formEnviar = '
                
                    <form>
                    <input onclick="javascript:desaprobar'. $id . '(); return false;" type="submit" value="desaprobar">
                    </form>

                        ';
            $formEliminar = '
                
                    <form>
                    <input onclick="javascript:eliminar'. $id . '(); return false;" type="submit" value="eliminar">
                    </form>

                        ';
            
            $referencias = $colecciones[$i]["ref"];
            
            if($referencias==null){
                $iRef = $ii .'<img id="iRef'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iRef = $ic .'<img id="iRef'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $coleccion = $colecciones[$i]["coleccion"];
            
            if($coleccion==null){
                $iCol = $ii .'<img id="iCol'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iCol = $ic .'<img id="iCol'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            if($coleccion==1){
                $coleccion = "Publicaciones";
            }
            if($coleccion==2){
                $coleccion = "Colecciones";
            }
            
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $nombre . $iNombre . '</td>
                <td>'. $descripcion . $iDescripcion . '</td>
                    
                <td>'. $coleccion . $iCol . '</td>
                <td>'. $referencias . $iRef . '</td>
                       
                <td>'. $iImagen . '</td>
                <td>'. $formEnviar . '</td>
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        ?>
        </table>
    
    <?php
    }
}
?>
