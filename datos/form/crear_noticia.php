<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/noticias.php';
include_once '../funciones/latex.php';
include_once '../funciones/usuario.php';






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
                        url: "acciones/enviar_noticia.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                        data: $("#form").serialize(),
                        success: function(msg){
                          $("#divCentro").load("admin/panel_control_noticias.php");
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
        
         
        <h1>Crear Noticia</h1>
        <script>
        $('#linkVolverAPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_noticias.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        </script>
        
        
        <a class="mencion_usuario_no_enlace" href="#" id="linkVolverAPendientes">Volver a Noticias</a>  
        
        <?php
        switch ($paso) {
            case 1:
                ?>
                
                <br>
                ID: <?php echo $id; ?>
                <form id="form">
                    Titulo de la noticia: <br><input type="text" id="titulo" name="titulo"><br>            
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
                    $titulo = getTituloNoticia($id);                    
                    
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
                    $des = getCuerpoNoticia($id);
                    
                    echo $des;
                    ?></textarea><br>            
                    
                    
                    <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                </form>

        
                <?php

                break;
            
            case 4:
                ?>
                
                <br>
                
                Usuarios a los que llegará la noticia. Introducir grupo de usuarios o @nombre<br>
                ID: <?php echo $id; ?><br>
                
                <form id="form">
                    Usuarios: <br><textarea name="usuarios" id="usuarios" cols="70" rows="8"><?php 
                    $usuarios = getCampoUsuariosNoticia($id);
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
                
                Tipo de noticia<br>
                ID: <?php echo $id; ?><br>
                <?php $tipo= getTipoNoticia($id); ?>
                
                <script>
                    $(document).on('change','#tipo',function(){
                       actualizarNoticiaSubTipo("<?php echo $id ?>",<?php echo $nivel ?>);

                        
                   });
                </script>
                <form id="form">
                    
                    Tipo : <select  name="tipo" id="tipo">
                            <option value="1" <?php if($tipo==1){echo "selected";} ?>>Indefinido</option>
                            <option value="2" <?php if($tipo==2){echo "selected";} ?>>Entre dos fechas</option>
                            <option value="3" <?php if($tipo==3){echo "selected";} ?>>Pulsar cerrar</option>
                            <option value="4" <?php if($tipo==4){echo "selected";} ?>>Aceptar terminos</option>
                        </select>
                    <br><br>
                    <div id="divNoticiaSubTipo">
                        <?php 
                        if($tipo==2){
                            ?>
                                <script>
                                   
                                        $.ajax({
                                            type: "POST",
                                            url: "formularios/crear_noticia_tipo.php",
                                            data: "tipo=<?php echo $tipo; ?>&id=<?php echo $id; ?>",
                                            success: function(msg){
                                              $("#divNoticiaSubTipo").html(msg);

                                            }
                                        });

                                </script>
                        
                        
                            <?php
                        }
                        ?>
                    </div>
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

