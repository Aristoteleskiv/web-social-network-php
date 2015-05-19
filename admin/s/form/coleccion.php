<!DOCTYPE html>

<?php
include_once '../../../func/secciones.php';
include_once '../../../conf/conf.php';
include_once '../../../conf/sesion.php';
$nivel = 3;

$usuario = $_SESSION["usr"];

include_once '../../../func/colecciones.php';
include_once '../../../func/publicaciones.php';
include_once '../../../func/latex.php';
include_once '../../../func/usuario.php';
//include_once '../../../datos/manejo_latex.php';

$id = null;
if(isset($_GET["id"])){$id = $_GET["id"];};
$paso = $_GET["p"];
$anterior = $_GET["a"];

switch ($anterior) {
        case "a":
            $direccion =  "../colecciones_aprobadas.php";

            break;
        case "p":

            $direccion =  "../colecciones_pendientes.php";
            break;

        default:
            break;
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
                    function enviarColeccion() {
                       
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');
                        $.ajax({
                            type: "POST",
                            url: "acc/enviar_coleccion.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                              document.location = '<?php echo $direccion; ?>';
 
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
                            url: "datos/previsualizar_coleccion.php?n=<?php echo $nivel;?>",
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
                            url: "datos/previsualizar_imagen_coleccion.php?n=<?php echo $nivel;?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                                //alert(msg);
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                     
                </script> 

                
                    <div class="div-contenido">
                        <h1>Modificar coleccion</h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
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
                                $imagenSrc = '<img src="images/colecciones/' . $imagen . '">';
                                $imagenSrc = subirImagenesDeFoolder($imagenSrc, $nivel);
                                echo "<br><b>Descripcion</b>: ";
                                echo getDescripcionColeccion($id);
                                echo '<br>';
                                echo $imagenSrc;

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
                                <?php 
                                $tipoDocumento= getColeccionColeccion($id);
                                $formato= getFormatoColeccion($id);

                                ?>
                                <form id="form">

                                    Tipo : <select  name="coleccion">

                                            <option value="1" <?php if($tipoDocumento==1){echo "selected";} ?>>Publicaciones</option>
                                            <option value="2" <?php if($tipoDocumento==2){echo "selected";} ?>>Colecciones</option>

                                        </select>
                                    <br>
                                    Formato: <select  name="formato">

                                            <option value="1" <?php if($formato==1){echo "selected";} ?>>Video</option>
                                            <option value="2" <?php if($formato==2){echo "selected";} ?>>PDF</option>
                                            <option value="3" <?php if($formato==3){echo "selected";} ?>>Mixto</option>

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

