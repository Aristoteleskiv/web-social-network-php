<!DOCTYPE html>

<?php
include_once '../../../func/secciones.php';
include_once '../../../conf/conf.php';
include_once '../../../conf/sesion.php';
$nivel = 3;

$usuario = $_SESSION["usr"];

include_once '../../../func/publicidad.php';
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
                            url: "acc/enviar_plan_publicidad.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                              alert(msg);
                              document.location = '../publicidad.php';
                                
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
                        <h1>Modificar plan publicidad</h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
                            
                            <?php
                    switch ($paso) {
                        case 1:
                            ?>

                            <br>
                            ID: <?php echo $id; ?>
                            <form id="form">
                                Titulo del plan: <br><input type="text" id="titulo" name="titulo"><br>            
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
                                $titulo = getTituloPlanPublicidad($id);                    

                                ?>
                                Titulo: <br><input type="text" id="titulo" value="<?php echo $titulo; ?>" name="titulo"><br> 
                                <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                            </form>
                            <?php
                            break;

                        case 3:
                            ?>

                            <br>

                            Usuarios a los que llegará la noticia. Introducir grupo de usuarios o @nombre<br>
                            ID: <?php echo $id; ?><br>

                            <form id="form">
                                Usuarios: <br><textarea name="usuarios" id="usuarios" cols="70" rows="8"><?php 
                                $usuarios = getCampoUsuariosPlanPublicidad($id);
                                echo $usuarios;
                                ?></textarea><br>            
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                <input type="button" value="Previsualizar" onclick="javascript:previsualizarUsuarios();return false;">
                                <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                <br>
                            </form>


                            <?php

                            break;

                        case 4:
                            ?>

                            <br>

                            Accion a aplicar a los usuarios que hay dentro del plan<br>
                            ID: <?php echo $id; ?><br>
                            <?php $accion = getAccionPlanPublicidad($id); ?>
                            <form id="form">
                                Tipo : <select  name="accion" id="cmbAccion">
                                        <option value="1" <?php if($accion==1){echo "selected";} ?>>Mostrar modulos</option>
                                        <option value="2" <?php if($accion==2){echo "selected";} ?>>Ocultar modulos</option>
                                        
                                    </select><br>            
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                <input type="submit" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                <br>
                            </form>


                            <?php

                            break;



                        case 5:
                            ?>
                            
                            <br>
                            Modulos de publicidad<br>
                            ID: <?php echo $id; ?><br>
                            Incluir numero de modulos separados por espacios.<br>
                            Modulo 1: Publicidad superior<br>
                            Modulo 2: Publicidad lateral superior<br>
                            Modulo 3: Publicidad lateral inferior<br>
                            Modulo 4: Publicidad cargar mas<br>
                            Modulo 5: Publicidad sobre videos<br>
                            
                           
                            <form id="form">
                                Modulos: <br><textarea name="modulos" id="usuarios" cols="70" rows="8"><?php 
                                $planes = getModulosPlanPublicidad($id);
                                echo $planes;
                                ?></textarea><br>            
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
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

