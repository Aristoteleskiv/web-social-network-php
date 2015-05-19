<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/latex.php';
include_once '../funciones/usuario.php';
include_once '../datos/manejo_latex.php';



session_start();


if(isset($_SESSION["usr"]) AND getNivelUsuario($_SESSION["usr"]) == 3 ){
    
    $usuario = $_SESSION["usr"];
    $paso = $_GET["p"];
    if(isset($_POST["id"])){
        $id = $_POST["id"];
    }else{
        $id = null;
    }
    
    $anterior = $_GET["a"];
    
    switch ($anterior) {
        case "a":
            $direccion =  "admin/panel_control_publicaciones_aprobadas.php";

            break;
        case "p":

            $direccion =  "admin/panel_control_publicaciones_pendientes.php";
            break;

        default:
            break;
    }
    
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

                $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');
                $.ajax({
                    type: "POST",
                    url: "acciones/enviar_publicacion.php?p=<?php echo $paso; ?>&id=<?php echo $id; ?>",
                    data: $("#form").serialize(),
                    success: function(msg){
                      $("#divCentro").load("<?php echo $direccion; ?>");
                        //$("#divCentro").html(msg);

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
        
         
        <h1>Crear publicacion</h1>
        <script>
        $('#linkVolverAPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_publicaciones_pendientes.php",
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
                    url: "admin/panel_control_publicaciones_aprobadas.php",
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
                ID: <?php echo $id; ?>
                <form id="form">
                    Titulo/enunciado: <br>
                    Para centrar formula verticalmente poner una <b>c</b> justo despues de [latex]<br>
                    <div id="divManejoLatexFormulas">
                        <?php echo $panelControlLatex; ?>
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
                        <?php echo $panelControlLatex; ?>
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
                        <?php echo $panelControlLatex; ?>
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
                <?php echo getTituloPublicacion($id);
                echo "<br><br>";
                echo getCuerpoPublicacion($id);
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
                $titulo = getTituloPublicacion($id);
                
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
                <?php echo getTituloPublicacion($id); 
                
                if(getTipoDocumentoPublicacion($id)==1){
                    $id = getIdMaterialComplementarioPublicacion($id);
                    
                }
                $nombre = getNombrePDFPublicacion($id);
                ?>
                
                <form id="form">
                    
                    Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <br>
                    <input type="button" value="Previsualizar" onclick="javascript:previsualizarPdf();return false;">
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

    <?php
    
}else{
    
    echo '<script>document.location="index.php"</script>';
}

    
 ?>

