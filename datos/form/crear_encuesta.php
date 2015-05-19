<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/encuestas.php';
include_once '../funciones/latex.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"]) AND getNivelUsuario($_SESSION["usr"]) == 3  ){
    
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
                        url: "acciones/enviar_encuesta.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                        data: $("#form").serialize(),
                        success: function(msg){
                          $("#divCentro").load("admin/panel_control_encuestas.php");
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
        
         
        <h1>Crear encuesta</h1>
        <script>
        $('#linkVolverAPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_encuestas.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        </script>
        
        
        <a class="mencion_usuario_no_enlace" href="#" id="linkVolverAPendientes">Volver a Encuestas</a>  
        
        <?php
        switch ($paso) {
            case 1:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                <form id="form">
                    Titulo de la encuesta: <br><input type="text" id="titulo" name="titulo"><br>            
                    <br>
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            case 2:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                Editar titulo<br>
                
                <form id="form">
                    <?php 
                    $titulo = getTituloEncuesta($id);                    
                    
                    ?>
                    Titulo: <br><input type="text" id="titulo" value="<?php echo $titulo; ?>" name="titulo"><br> 
                               
                    
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            
            
            case 3:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                Editar cuerpo<br>
                <form id="form">
                    Cuerpo: <br><textarea name="cuerpo" id="cuerpo" cols="70" rows="8"><?php 
                    $des = getCuerpoEncuesta($id);
                    
                    echo $des;
                    ?></textarea><br>            
                    
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            case 4:
                ?>
                
                <br>
                
                Usuarios a los que llegará la encuesta. Introducir la id del grupo de usuarios o @nombre<br>
                ID: <?php echo $id; ?><br>
                
                <form id="form">
                    Usuarios: <br><textarea name="usuarios" id="usuarios" cols="70" rows="8"><?php 
                    $usuarios = getCampoUsuariosEncuesta($id);
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
                
                Tipo de en encuesta<br>
                ID: <?php echo $id; ?><br>
                <?php $tipo= getTipoEncuesta($id); ?>
                
                
                <form id="form">
                    
                    Tipo : <select  name="tipo" id="tipo">
                            <option value="1" <?php if($tipo==1){echo "selected";} ?>>Si/No</option>
                            <option value="2" <?php if($tipo==2){echo "selected";} ?>>Varias respuestas</option>
                            <option value="3" <?php if($tipo==3){echo "selected";} ?>>0/10</option>
                        </select>
                    <br>
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>
                
        
                <?php

                break;
                
            case 6:
                ?>
                
                <br>
                
                Opciones de encuesta<br>
                ID: <?php echo $id; ?><br>
                Introducir cada opcion en un renglón
               
                <form id="form">
                    
                    Opciones: <br><textarea name="opciones" id="opciones" cols="70" rows="8"><?php 
                    $opciones = getOpcionesEncuesta($id);
                    echo $opciones;
                    ?></textarea><br>   
                    
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

