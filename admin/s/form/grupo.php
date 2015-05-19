<!DOCTYPE html>

<?php
include_once '../../../func/secciones.php';
include_once '../../../conf/conf.php';
include_once '../../../conf/sesion.php';
$nivel = 3;

$usuario = $_SESSION["usr"];

include_once '../../../func/grupos.php';
include_once '../../../func/latex.php';
include_once '../../../func/usuario.php';
//include_once '../../../datos/manejo_latex.php';

$id = null;
if(isset($_GET["id"])){$id = $_GET["id"];}
$paso = $_GET["p"];
if(getNivelUsuario($usuario)<3){
    echo codigoRedireccionHome($nivel);
}

?>    


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>

    </head>
    <body>
        <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
        
            
            <div id="vertical">
                <aside id="menu">
                
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>

                <section id="contenido">
                    <?php
                    if(getNivelUsuario($usuario)<3){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                <script>
                    function enviarPublicacion() {

                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');
                        $.ajax({
                            type: "POST",
                            url: "acc/enviar_grupo.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                                
                              document.location = '../grupos.php';
                                
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
                                //alert(msg);
                              $("#divPrevisualizacion").html(msg);
                              
                            }
                        });
                    }
                     
                </script> 

                
                    <div class="div-contenido">
                        <h1>Modificar grupo</h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
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
                            </div>
                              
                        </div>
                           
                    </div>
                   <?php
                    }
                    ?>
                <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
                
            </div>
        
        
        <div>
            <?php echo getScrolls($nivel); ?>
        </div>
        
        
    </body>

    
</html>
