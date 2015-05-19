<!DOCTYPE html>

<?php
include_once '../../../func/secciones.php';
include_once '../../../conf/conf.php';
include_once '../../../conf/sesion.php';
$nivel = 3;

$usuario = $_SESSION["usr"];

include_once '../../../func/publicaciones.php';
include_once '../../../func/latex.php';
include_once '../../../func/usuario.php';
include_once '../../../datos/manejo_latex.php';



$id = null;
if(isset($_GET["id"])){$id = $_GET["id"];}
$paso = $_GET["p"];
$anterior = $_GET["a"];
switch ($anterior) {
        case "a":
            $direccion =  "../publicaciones_aprobadas.php";
            break;
        case "p":
            $direccion =  "../publicaciones_pendientes.php";
            break;
        default:
            break;
    }
    
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
                    function addTexto(texto){
                        textarea = "texto";
                        var elemento_dom=document.getElementsByName(textarea)[0];
                        if(document.selection){
                            elemento_dom.focus();
                            sel=document.selection.createRange();
                            sel.text=texto;
                            return;
                        }if(elemento_dom.selectionStart||elemento_dom.selectionStart=="0"){
                            var t_start=elemento_dom.selectionStart;
                            var t_end=elemento_dom.selectionEnd;
                            var val_start=elemento_dom.value.substring(0,t_start);
                            var val_end=elemento_dom.value.substring(t_end,elemento_dom.value.length);
                            elemento_dom.value=val_start+texto+val_end;
                        }else{
                            elemento_dom.value+=texto;
                        }
                    }
                    function enviarPublicacion() {
                        
                        $("#divPrevisualizacion").html('<?php echo  $imagenCargandoHtml; ?>');
                        $.ajax({
                            type: "POST",
                            url: "acc/enviar_publicacion.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                            data: $("#form").serialize(),
                            success: function(msg){
                              
                              document.location = '<?php echo $direccion; ?>';
                              
                              
                            }
                        });

                    }

                    function previsualizarTitulo(){
                        //$("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_texto_latex.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }


                    function previsualizarVideo(){
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_video.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                    function previsualizarPdf(){
                        $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                        $.ajax({
                            type: "POST",
                            url: "datos/previsualizar_pdf.php",
                            data: $("#form").serialize(),
                            success: function(msg){
                              $("#divPrevisualizacion").html(msg);

                            }
                        });
                        }
                     
                </script> 

                
                    <div class="div-contenido">
                        <h1>Modificar publicacion</h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
                            <?php
                            
                            
                            
                            
                            switch ($paso) {
                            case 1:
                                ?>

                                <br>
                                ID: <?php echo $id; ?>
                                <form id="form">
                                    Titulo/enunciado: <br>
                                    Para centrar formula verticalmente poner una <b>c</b> justo despues de [latex]<br>
                                    <div id="divManejoLatexFormulas">
                                        <?php echo subirImagenesDeFoolder($panelControlLatex, $nivel); ?>
                                    </div>

                                    <textarea id="texto" name="texto" id="texto" cols="70" rows="8"></textarea><br>            
                                    <br>

                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;

                            case 2:
                                ?>

                                <br>
                                ID: <?php echo $id; ?>
                                Editar titulo<br>

                                <form id="form">
                                    Titulo/enunciado: <br>
                                    Para centrar formula verticalmente poner una <b>c</b> justo despues de [latex]<br>
                                    <div id="divManejoLatexFormulas">
                                        <?php echo subirImagenesDeFoolder($panelControlLatex, $nivel); ?>
                                    </div>

                                    <br><textarea name="texto" id="cuerpo" cols="70" rows="8"><?php 
                                    $titulo = getTituloPublicacion($id);


                                    $titulo = sustituirImagenesPorLatex($titulo);



                                    echo $titulo;

                                    ?></textarea><br>            
                                    <br>
                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">


                                    </form>


                                <?php

                                break;



                            case 3:
                                ?>

                                <br>
                                ID: <?php echo $id; ?>
                                Editar cuerpo<br>
                                <div id="divManejoLatexFormulas">
                                        <?php echo subirImagenesDeFoolder($panelControlLatex, $nivel); ?>
                                    </div>

                                <form id="form">
                                    Cuerpo: <br><textarea name="texto" id="cuerpo" cols="70" rows="8"><?php 
                                    $cuerpo = getCuerpoPublicacion($id);
                                    $cuerpo = sustituirImagenesPorLatex($cuerpo);
                                    echo $cuerpo;
                                    ?></textarea><br>            
                                    <br>
                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;

                            case 4:
                                ?>

                                <br>

                                Editar ayudas a la busqueda<br>
                                ID: <?php echo $id; ?><br>
                                <?php echo subirImagenesDeFoolder(getTituloPublicacion($id),$nivel);
                                echo "<br><br>";
                                echo subirImagenesDeFoolder(getCuerpoPublicacion($id), $nivel);
                                echo "<br><br>";?>
                                <form id="form">
                                    Ayudas a la busqueda: <br><textarea name="ayudas" id="cuerpo" cols="70" rows="8"><?php 
                                    $ayudas = getAyudasALaBusquedaPublicacion($id);
                                    echo $ayudas;
                                    ?></textarea><br>            
                                    <br>

                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;



                            case 5:
                                ?>

                                <br>

                                Editar tipo de documento<br>
                                ID: <?php echo $id; ?><br>
                                <?php $tipoDocumento=  getTipoDocumentoPublicacion($id); ?>
                                <form id="form">

                                    Tipo : <select  name="tipo">
                                            <option value="1" <?php if($tipoDocumento==1){echo "selected";} ?>>video</option>
                                            <option value="2" <?php if($tipoDocumento==2){echo "selected";} ?>>pdf</option>

                                        </select>




                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;



                                case 6:
                                ?>

                                <br>
                                Editar video<br>
                                ID: <?php echo $id; ?><br>
                                <?php  

                                if(getTipoDocumentoPublicacion($id)==2){
                                    $id = getIdMaterialComplementarioPublicacion($id);
                                }



                                $ident = getIdentificativoReferenciaVideoPublicacion($id);
                                $server = getServidorReferenciaVideoPublicacion($id);
                                $titulo = subirImagenesDeFoolder(getTituloPublicacion($id), $nivel);

                                ?>

                                Titulo: <?php echo $titulo; ?><br>
                                <form id="form">

                                Servidor: 
                                <select  name="servidor">
                                <option value="youtube" <?php if($server=="youtube"){echo "selected";} ?>>youtube</option>
                                </select>
                                <br>
                                Identificativo: <input type="text" name="referencia" value="<?php echo $ident; ?>">
                                <br>
                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarVideo();return false;">
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;



                                case 7:
                                ?>

                                <br>
                                Editar pdf<br>
                                ID: <?php echo $id; ?><br>
                                El nombre del pdf hace referencia al archivo pdf y al archivo de imagen que le acompaña.
                                <br>
                                <?php
                                if(getTipoDocumentoPublicacion($id)==1){
                                    echo 'Al darle a enviar se creará una nueva publicacion de tipo PDF exacta a la actual, apuntando al PDF y con material complementario este video.
                                    <br>';
                                }
                                ?>

                                <br>
                                <?php echo subirImagenesDeFoolder(getTituloPublicacion($id), $nivel); 

                                if(getTipoDocumentoPublicacion($id)==1){
                                    $id = getIdMaterialComplementarioPublicacion($id);

                                }
                                $nombre = getNombrePDFPublicacion($id);
                                ?>

                                <form id="form">

                                    Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                                    <br>
                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarPdf();return false;">
                                    <input type="button" value="Enviar" onclick="window.location = '<?php echo $direccion; ?>';">
                                </form>


                                <?php

                                break;
                                case 8:
                                ?>

                                <br>
                                Editar directorio<br>
                                ID: <?php echo $id; ?><br>
                                
                                <br>
                                <?php 
                                $tituloCompatible = $id . "-" . quitarSimbolosString(sustituirImagenesPorLatex(getTituloPublicacion($id)));
                                $cuerpoCompatible = $id . "-" .  quitarSimbolosString(sustituirImagenesPorLatex(getCuerpoPublicacion($id)));
                                
                                
                                
                                $seccion = getDirSeccionado($id);
                                $dirTitulo =  $pivoteDirectorioCreacionDocumentos . "/" . $seccion . $tituloCompatible ;
                                $dirCuerpo =  $pivoteDirectorioCreacionDocumentos . "/" . $seccion . $cuerpoCompatible ;
                                
                                $dirTitulo = substr($dirTitulo, 0,min(190, strlen($dirTitulo)));
                                $dirCuerpo = substr($dirCuerpo, 0,min(190, strlen($dirCuerpo)));
                                
                                echo "<b>Titulo:</b> " . subirImagenesDeFoolder(getTituloPublicacion($id), $nivel);
                                echo "<br><b>Cuerpo:</b> " . subirImagenesDeFoolder(getCuerpoPublicacion($id), $nivel);
                                echo "<br>";
                                echo "<br><b>Seccion:</b> " . $seccion;
                                echo "<br>";
                                echo "<br><b>Titulo valido:</b> " . $tituloCompatible ;
                                echo "<br><b>Cuerpo valido:</b> " . $cuerpoCompatible ;
                                echo "<br>";
                                echo "<br><b>Dir con titulo:</b> " . $dirTitulo ;
                                echo "<br><b>Dir con cuerpo:</b> " . $dirCuerpo ;
                                //echo checkSiDirPublicacionExiste("", $nivel);
                                
                                
                                ?>
                                
                                
                                <br>
                                <div onclick="addTexto('<?php echo $dirTitulo; ?>');" class="div-boton-estandar">Seccion + titulo</div><br>
                                <div onclick="addTexto('<?php echo $dirCuerpo; ?>');" class="div-boton-estandar">Seccion + cuerpo</div>
                                <form id="form">
                                    <textarea name="texto" id="cuerpo" cols="70" rows="8"><?php 
                                    $dir = getDirPublicacion($id);
                                    echo $dir;
                                    ?></textarea><br>
                                    Cuando se envíe se creará un documento en la direccion especificada con el contenido de la publciación.
                                    <br>
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </form>


                                <?php

                                break;
                            case 9:
                                ?>

                                <br>
                                Editar video<br>
                                ID: <?php echo $id; ?><br>
                                <?php  

                                ?>

                                Dificultad: <?php echo $titulo; ?><br>
                                <form id="form">
                                <?php
                                $dif = getDificultadPublicacion($id);
                                ?>
                                Seleccionar dificultad: 
                                <select  name="dif">
                                <option value="0" <?php if($dif==0){echo "selected";} ?>>0</option>
                                <option value="1" <?php if($dif==1){echo "selected";} ?>>1</option>
                                <option value="2" <?php if($dif==2){echo "selected";} ?>>2</option>
                                <option value="3" <?php if($dif==3){echo "selected";} ?>>3</option>
                                <option value="4" <?php if($dif==4){echo "selected";} ?>>4</option>
                                <option value="5" <?php if($dif==5){echo "selected";} ?>>5</option>
                                <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
                                </select>
                                <br>
                                </form>


                                <?php

                                break;    
                            case 10:
                                ?>

                                <br>
                                ID: <?php echo $id; ?>
                                Editar respuesta<br>
                                <div id="divManejoLatexFormulas">
                                        <?php echo subirImagenesDeFoolder($panelControlLatex, $nivel); ?>
                                    </div>

                                <form id="form">
                                    Respuesta: <br><textarea name="texto" id="cuerpo" cols="70" rows="8"><?php 
                                    $respuesta = getRespuestaPublicacion($id);
                                    $respuesta = sustituirImagenesPorLatex($respuesta);
                                    echo $respuesta;
                                    ?></textarea><br>            
                                    <br>
                                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarTitulo();return false;">
                                    <input type="button" value="Enviar" onclick="javascript:enviarPublicacion(); return false;">
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
