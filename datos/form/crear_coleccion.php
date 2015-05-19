<?php


include_once '../config/configuracion.php';
include_once '../funciones/colecciones.php';
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
                    function enviarColeccion() {
                       
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');
                        $.ajax({
                            type: "POST",
                            url: "acciones/enviar_coleccion.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divCentro").load("admin/panel_control_colecciones_pendientes.php");
                                //$("#divCentro").html("msg");

                            }
                        });

                    }
                
                    function previsualizarTitulo(){
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_texto_latex.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                    function previsualizarColeccion(){
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_coleccion.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                    function previsualizarImagen(){
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_imagen_coleccion.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                    
                </script>    
        
         
        <h1>Crear coleccion</h1>
        
        <script>
        $('#linkVolverAPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_colecciones_pendientes.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkVolverAAprobadas').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_colecciones_aprobadas.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        </script>
        
        
        <a class="mencion_usuario_no_enlace" href="#" id="linkVolverAPendientes">Volver a Pendientes</a>  
        <a class="mencion_usuario_no_enlace" href="#" id="linkVolverAAprobadas">Volver a Aprobadas</a><br>
        
        
        <?php
        
        
        
        switch ($paso) {
            case 1:
                ?>
                
                <br>
                <form id="form">
                    Nombre de coleccion <br><textarea name="texto" id="texto" cols="70" rows="8"></textarea><br>            
                    <br>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
                </form>

        
                <?php

                break;
            
            case 2:
                ?>
                
                <br>
                Editar nombre de coleccion<br>
                
                <form id="form">
                    Nombre: <br><textarea name="texto" id="texto" cols="70" rows="8"><?php 
                    $nombre = getNombreColeccion($id);
                    
                    
                    $nombre = sustituirImagenesPorLatex($nombre);
                    echo $nombre;
                    
                    ?></textarea><br>            
                    <br>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
                </form>

        
                <?php

                break;
            
            
            
            case 3:
                ?>
                
                <br>
                Editar descripcion<br>
                <form id="form">
                    Descripcion: <br><textarea name="texto" id="texto" cols="70" rows="8"><?php 
                    $descripcion = getDescripcionColeccion($id);
                    $descripcion = sustituirImagenesPorLatex($descripcion);
                    echo $descripcion;
                    ?></textarea><br>            
                    <br>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
                </form>

        
                <?php

                break;
            
            case 4:
                ?>
                
                <br>
                Editar Imagen de coleccion<br>
                <?php 
                
                echo "<br><b>Nombre</b>: ";
                echo getNombreColeccion($id);
                $imagen = getImagenColeccion($id);
                        
                echo "<br><b>Descripcion</b>: ";
                echo getDescripcionColeccion($id);
                
                echo '<br><img src="images/colecciones/' . $imagen . '">';
                echo "<br>";?>
                
                <form id="form">
                    Imagen: <br>
                    <input type="text" name="imagen" id="imagen" value="<?php echo $imagen;?>">
                    <br>            
                    <br>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarImagen();return false;">
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
                </form>

        
                <?php

                break;
            
            case 5:
                ?>
                
                <br>
                Editar qué colecciona<br>
                <?php $tipoDocumento= getColeccionColeccion($id); ?>
                <form id="form">
                    
                    Tipo : <select  name="coleccion">
                        
                            <option value="1" <?php if($tipoDocumento==1){echo "selected";} ?>>Publicaciones</option>
                            <option value="2" <?php if($tipoDocumento==2){echo "selected";} ?>>Colecciones</option>

                        </select>
                    
                    
                   
                    
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
                </form>

        
                <?php

                break;
                
            case 6:
                ?>
                
                <br>
                Editar referencias. <br>
                <form id="form">
                    Referencias: <br><textarea name="texto" id="texto" cols="70" rows="8"><?php 
                    $ref = getReferenciasColeccion($id);
                    $col = getColeccionColeccion($id);
                    echo $ref;
                    ?></textarea><br>            
                    <br>
                    <input type="hidden" value="<?php echo $col; ?>" id="col" name="col">
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarColeccion();return false;">
                    <input type="button" value="Enviar" onclick="javascript:enviarColeccion(); return false;">
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

