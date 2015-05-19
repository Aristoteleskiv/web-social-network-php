<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/grupos.php';
include_once '../funciones/latex.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"])  AND getNivelUsuario($_SESSION["usr"]) == 3 ){
    
    $usuario = $_SESSION["usr"];
    $paso = $_GET["p"];
    if(isset($_POST["id"])){
        $id = $_POST["id"];
    }else{
        $id = null;
    }
    
    
    ?>

    <script>
                function enviarPublicacion() {
                       
                    $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');
                    $.ajax({
                        type: "POST",
                        url: "acciones/enviar_grupo.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                        data: $("#form").serialize(),
                        success: function(msg){
                          $("#divCentro").load("admin/panel_control_grupos.php");
                            //$("#divCentro").html(msg);

                        }
                    });

                }
                function previsualizarUsuarios(){
                    $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                    $.ajax({
                        type: "POST",
                        url: "datos/previsualizar_grupo.php",
                        data: $("#form").serialize(),
                        success: function(msg){
                          $("#divPrevisualizacion").html(msg);

                        }
                    });
                }
            
                </script>    
        
         
        <h1>Crear grupo</h1>
        <script>
        $('#linkVolverAPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_grupos.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        </script>
        
        
        <a class="mencion_usuario_no_enlace" href="#" id="linkVolverAPendientes">Volver a Grupos</a>  
        
        <?php
        switch ($paso) {
            case 1:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                <form id="form">
                    Nombre del grupo: <br><input type="text" id="nombre" name="nombre"><br>            
                    <br>
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            case 2:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                Editar nombre<br>
                
                <form id="form">
                    <?php 
                    $nombre = getNombreGrupo($id);                    
                    echo $nombre;
                    ?>
                    Nombre del grupo: <br><input type="text" id="nombre" value="<?php echo $nombre; ?>" name="nombre"><br> 
                               
                    
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            
            
            case 3:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                Editar descripcion<br>
                <form id="form">
                    Descripcion: <br><textarea name="cuerpo" id="cuerpo" cols="70" rows="8"><?php 
                    $des = getDescripcionGrupo($id);
                    
                    echo $des;
                    ?></textarea><br>            
                    
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            case 4:
                ?>
                
                <br>
                
                Usuarios dentro del grupo<br>
                ID: <?php echo $id; ?><br>
                <?php echo "Nombre del grupo: " . getNombreGrupo($id);
                echo "<br><br>";
                echo "Introducir usuarios del tipo @usuario o el numero de otro grupo separado por espacios. Para quitar usuarios de un grupo mas amplio utilizar el signo menos (-) antes del usuario o antes del grupo.<br><br>";
                ?>
                <form id="form">
                    Usuarios: <br><textarea name="usuarios" id="usuarios" cols="70" rows="8"><?php 
                    $usuarios = getCampoUsuariosGrupo($id);
                    echo $usuarios;
                    ?></textarea><br>            
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarUsuarios();return false;">
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                    <br>
                </form>

        
                <?php

                break;
            
            
            
            case 5:
                ?>
                
                <br>
                
                Tipo de grupo<br>
                ID: <?php echo $id; ?><br>
                <?php $tipo= getTipoGrupo($id); ?>
                <form id="form">
                    
                    Tipo : <select  name="tipo">
                            <option value="1" <?php if($tipo==1){echo "selected";} ?>>Visible</option>
                            <option value="2" <?php if($tipo==2){echo "selected";} ?>>Invisible</option>

                        </select>
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
                
                
                
                
            default:
                break;
        }
        
        ?>
        
        <div id="divPrevisualizacion">
            
        </div>

    <?php
    
}else{
    
    echo '<script>document.location="index.php"</script>';
}

    
 ?>

