<?php
include_once '../config/configuracion.php';
include_once '../funciones/grupos.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    
    if($nivel == 3){
        
        
        
    
    
    ///var_dump($reglas);
    ?>
    
<br><h1>Gestion de grupos de usuarios</h1>
    <br>

        
        <script>
        function previsualizar(id){
                    $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                    $.ajax({
                        type: "POST",
                        url: "datos/previsualizar_grupo.php",
                        data: "id="+id,
                        success: function(msg){
                          $("#divPrevisualizacion").html(msg);

                        }
                    });
                }    
            
        </script>
        <br><br>
        Grupos especiales: <br>
        <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td width="46"><b>Nombre</b></td>
		<td width="689"><b>Descripcion</b></td>
		<td><b>Usuarios</b></td>
		<td width="37"><b>Tipo</b></td>

                <td width="64"><b>Eliminar</b></td>
	</tr>
        
        <tr>
            <td>1</td>
            <td>Todos los usuarios</td>
            <td>Conjunto de todos los usuarios de la web</td>
            <td>Usuarios</td>
            <td>Invisible</td>
            <td>
                <form>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizar(1)">
                </form>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Usuarios online</td>
            <td>Todos los usuarios que estan online en los ultimos 5 minutos</td>
            <td>Usuarios</td>
            <td>Invisible</td>
            <td><form>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizar(2)">
                </form></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Usuarios no confirmados</td>
            <td>Todos los usuarios que no han confirmado su email</td>
            <td>Usuarios</td>
            <td>Invisible</td>
            <td><form>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizar(3)">
                </form></td>
        </tr>
        
        </table>
        <div id="divPrevisualizacion"></div>
        <br><br>
        <span class="boton" id="linkCrearGrupo">Crear grupo</span><br><br>
        
        
        
        Grupos existentes: <br>
        <table border="1" width="100%">
	<tr>
		<td width="16"><b>ID</b></td>
		<td width="46"><b>Nombre</b></td>
		<td width="689"><b>Descripcion</b></td>
		<td><b>Usuarios</b></td>
		<td width="37"><b>Tipo</b></td>

                <td width="64"><b>Eliminar</b></td>
	</tr>
    
        <?php 
        
        $grupos = getGrupos();
        
        $ic= '<img src="images/header/correcto.png" width="20" height="20">';
        $ii= '<img src="images/header/incorrecto.png" width="20" height="20">';
        
        for($i=0; $i<count($grupos); $i++){
            $id = $grupos[$i]["id"];
            
            $scripts='
                
                    <script>    
                    $("#iNombre'. $id . '").click(function(){
                        
                        $.ajax({
                                type: "POST",
                                url: "formularios/crear_grupo.php?p=2",
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
                                url: "formularios/crear_grupo.php?p=3",
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
                                url: "formularios/crear_grupo.php?p=4",
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
                                url: "formularios/crear_grupo.php?p=5",
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
                                    url: "acciones/enviar_grupo.php?p=10",
                                    data: "id='. $id . '",
                                    success: function(msg){
                                      $("#divCentro").load("admin/panel_control_grupos.php");
                                    }
                                });
                            }
                    return false;
                    
                    }
                    </script>

                        ';
            
            
            echo $scripts;
            
            
            
            
            
            $nombre = $grupos[$i]["nombre"];
            
            $iNombre = '<img id="iNombre'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            
            $descripcion = $grupos[$i]["descripcion"];
            if($descripcion==null){
                $iDescripcion = $ii .'<img id="iDescripcion'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iDescripcion = $ic .'<img id="iDescripcion'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }
            
            $usuarios = 'Usuarios<img id="iUsuarios'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            
            $tipo = $grupos[$i]["tipo"];
            switch ($tipo) {
                case 1:
                    $tipo1="Visible";

                    break;
                case 2:
                    $tipo1="Invisible";

                    break;
                default:
                    break;
            }
            
            if($tipo==null){
                $iTipo = $ii . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }else{
                $iTipo =  $tipo1 . '<img id="iTipo'. $id . '" class="imagen-menus" src="images/header/menu_editor.png">';
            }

            $formEliminar = '
                
                    <form>
                    <input onclick="javascript:eliminar'. $id . '(); return false;" type="submit" value="eliminar">
                    </form>

                        ';
            
            
            echo '<tr><td>'. $id.'</td>
                <td>'. $nombre . $iNombre . '</td>
                <td>'. $descripcion. $iDescripcion . '</td>
                <td>'. $usuarios . '</td>
                <td>'. $iTipo . '</td>
                
                
                <td>'. $formEliminar . '</td>
                </tr>
                ';
        }
        
        ?>
        </table>
        <br>
        <br>
        
        <script>
            $('#linkCrearGrupo').click(function(){
                $.ajax({
                       type: "POST",
                       url: "formularios/crear_grupo.php?p=1",
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
        
}
?>
    