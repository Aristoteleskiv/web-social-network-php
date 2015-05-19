<?php




class Publicacion  {
    var $id;
    
    var $titulo;
    var $tipo;
    var $cuerpo;
    var $autor;
    var $tipoDocumento;
    var $tipoClasificacion;
    var $encabezado;
    var $clase;
    var $fecha;
    var $fechaUltimaPublicacion;
    var $resumen;
    var $urlVideo;
    var $idMaterialComplementario;
    
    var $tipoMaterialComplementario;
    var $imagenMaterialComplementario;
    var $realizado;
    var $usuario;
    var $guardadoParaMasTarde;
    var $col;
    var $posComentario;
    
    function __construct($id, $usuario, $col=null, $posComentario =null) {

        
        $this->col = $col;
        $this->posComentario = $posComentario;
        
        $this->id = $id;
        $this->titulo = getTituloPublicacion($id);
        $this->tipoClasificacion = getTipoClasificacionPublicacion($id);
        $this->tipoDocumento = getTipoDocumentoPublicacion($id);
        $this->cuerpo = getCuerpoPublicacion($id);
        $this->autor = getAutorPublicacion($id);
        
        $this->fecha = getFechaPublicacion($id);
        $this->fechaUltimaPublicacion = getFechaUltimaModificacionPublicacion($id);
        $this->idMaterialComplementario = getIdMaterialComplementarioPublicacion($id);
        $this->usuario = $usuario;
        $this->realizado = comprobarSiUsuarioHaRealizadoPublicacion($usuario, $id);
        $this->guardadoParaMasTarde = comprobarSiPublicacionGuardadaParaMasTarde($usuario, $id);
        
        
        if($this->idMaterialComplementario!=0){
            $this->tipoMaterialComplementario = getTipoDocumentoPublicacion($this->idMaterialComplementario);
        
            switch ($this->tipoMaterialComplementario) {
                case 1:
                     $this->imagenMaterialComplementario = '<img src="images/resolucion_video.png"><br/>Resolucion en video';

                    break;
                case 2:
                     $this->imagenMaterialComplementario = '<img src="images/resolucion_pdf.png"><br/>Resolucion en pdf';

                    break;

                default:
                    break;
            }
            
        }
        

    }
    
    
    function getHtml(){
        
        $salida = $this->getScriptCargarComentarios();
        $salida .= $this->getTabla();
        if($this->posComentario!=null){
            $salida .= '<script>
                        verComentarios();
                        
                    </script>';
        }
        
        return $salida;
    }
    
    
    
    
    function getScriptCargarComentarios(){
        $salida = '
        <script>
            function verComentarios(){
                $.ajax({
                    type: "POST",
                    url: "datos/comentarios.php",
                    data: "id='. $this->id .'&filtro=1",
                    success: function(msg){
                      $("#divComentarios").html(msg);
                    }
                });
            }
         </script>
            ';
        
        return $salida;
    }
    
    function getMaterialComplementario(){
        $salida = "";
        if($this->idMaterialComplementario!=0){
            
            $salida .= '<br>Ejercicio tambien disponible en: <br>
                    <span class="enlace" id="linkMaterialComplementario'. $this->id . '">'. $this->imagenMaterialComplementario . '</span><br>
                
                <script>
                    $("#linkMaterialComplementario'. $this->id . '").click(function(){

                        $.ajax({
                            type: "POST",
                            url: "publicacion.php?id='. $this->idMaterialComplementario . '",
                            data: "id='. $this->idMaterialComplementario . '",
                            success: function(msg){

                                $("#divPopUp").html(msg);


                            }   
                        });
                    return false; 
                    });
                </script>



                    ';
        }
        return $salida;
    }
    
    
    
    
    function getHtmlPresentacionPdf(){
        
        $salida = "";
        $idPdf = getNombrePDFPublicacion($this->id);
        $dir = 'images/pdf/img';
        $empiezan = $idPdf . '_';
        
        $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);
        sort($imagenes, SORT_ASC);
        
        for($i=0; $i<count($imagenes); $i++){
            $nombre = $imagenes[$i];
            $salida .= '
            
                <tr>
                    <td colspan="5"><img width="550" border="1" src="images/pdf/img/'. $nombre . '"></td>
                </tr>';
        }
        
        $salida .= '
            
                <tr>
                    <td colspan="5"><br><a  class="descarga" href="acciones/descargar_pdf.php?&id='. $this->id . '" TARGET="_blank">Descargar PDF</a><td>
                </tr>
             ';
        
        
        return $salida;
    
    
 
    }
    
    
    function getTabla(){
        
        $contenidoExtra = "";
        switch ($this->tipoDocumento) {
            case 1:
                $contenidoExtra = getHtmlVideoEmbebidoPublicacion($this->id);

                break;
            case 2:
                $contenidoExtra = $this->getHtmlPresentacionPdf();

                break;

            default:
                break;
        }
        
        
        
        
        if($this->guardadoParaMasTarde){
            $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion-no-opaco" src="images/header/guardado_later.png">';
        }else{
            $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion" src="images/header/guardado_later.png">';
        }
        if($this->realizado){
            $imgRealizado = '<img class="imagen-menus-publicacion-no-opaco" src="images/header/marcado_realizado.png">';
        }else{
            $imgRealizado = '<img class="imagen-menus-publicacion" src="images/header/marcado_realizado.png">';
        }
        
        
        
        if($this->col != null){
            
            $nombre = getNombreColeccion($this->col);
            
            $bloqueColeccion = '<script>
                function pasarEnColeccionA(id){

                $.ajax({
                    type: "POST",
                    url: "publicacion.php?id=" + id + "&c='. $this->col . '",
                    data: "",
                    success: function(msg){

                        $("#divPopUp").html(msg);


                    }   
                });
                return false; 
                }
            </script>
            <b>Colección: </b> '.  $nombre . '. <br>
            ';
            
            
            $col = getColeccionColeccion($this->col);
            if($col==1){
            $titulos = getTitulosColeccion($this->col);
            $ids = getReferenciasColeccion($this->col);
            $ids = explode(" ", $ids);
            
            }
            if($col==2){
                $titulos = getTitulosColeccionColeccion($this->col);
                $ids = getIDsColeccionColeccion($this->col);
                $ids = array_interseccion($ids, $ids);
                
            }
            
            for($i=0; $i<count($ids); $i++){
                if($ids[$i]==$this->id){
                    $num = $i + 1;
                    $bloqueColeccion .= "<b>Ejercicio $num/" . count($ids) . "</b><br>";
                    if($i>0){
                        $bloqueColeccion .=  '<img style="cursor: pointer;" onclick="javascript:pasarEnColeccionA('. $ids[$i-1] .');" src="images/header/anterior.png">';
                    }
                    if($i< count($ids)-1){
                        $bloqueColeccion .= '<img  style="cursor: pointer;" onclick="javascript:pasarEnColeccionA('. $ids[$i+1] .');"  src="images/header/siguiente.png">';
                    }
                }
            }
            
            
            
            
        }else{
            $bloqueColeccion = null;
        }
        
        
        $salida = '
            
            

            <script>
                $("#imgGuardarParaMasTarde").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgCompartir").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgMarcarRealizado").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgNotificarError").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgAyudaBusqueda").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgMaterialComplementario").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgColecciones").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                
                function guardarParaMasTarde(){
                    $.ajax({
                    type: "POST",
                    url: "acciones/guardar_para_mas_tarde.php",
                    data: "id='. $this->id . '",
                    success: function(msg){
                        $("#imgGuardarParaMasTarde").html(msg);

                    }
                });
                }
                
                function compartir(){
                    $.ajax({
                        type: "POST",
                        url: "datos/compartir_publicacion.php",
                        data: "p='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                }

                function marcarRealizado(){
                   
                    $.ajax({
                        type: "POST",
                        url: "acciones/marcar_publicacion_realizada.php",
                        data: "id='. $this->id .'",
                        success: function(msg){
                            $("#imgMarcarRealizado").html(msg);
                        }   
                    });
                    
                 
                }
                function notificarError(){
                   
                    $.ajax({
                        type: "POST",
                        url: "formularios/formulario_notificar_error.php",
                        data: "id='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                    
                 
                }
                
                function ayudaBusqueda(){
                   
                    $.ajax({
                        type: "POST",
                        url: "datos/mostrar_ayudas_busqueda.php",
                        data: "id='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                 
                }
                function materialComplementario(){
                   
                    $.ajax({
                        type: "POST",
                        url: "datos/material_complementario.php",
                        data: "id='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                 
                }
                function Colecciones(){
                   
                    $.ajax({
                        type: "POST",
                        url: "datos/colecciones.php",
                        data: "id='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                 
                }
            </script>
            

            
                            
            <div class="div-pop-up">
                <div class="div-contenedor-publicacion">
                    <div>
                    '. $this->titulo . '
                    </div>
                    
                    
                    <div class="indicadores-publicacion">
                    V:'. getNumeroDeVisitas($this->id) . '. ID:' . $this->id . '. @'. $this->autor . '. '. $this->fecha . '
                    </div>
                    <div class="imagenes-opciones-publicacion">
                    
                        <div id="imgGuardarParaMasTarde" data-tooltip="#altGuardarParaMasTarde" style="display:inline-block;" onclick="javascript:guardarParaMasTarde(); return false;">'. $imgGuardadoParaMasTarde . '</div>
                        <div class="div-alt" id="altGuardarParaMasTarde">Guardar para mas tarde</div>
                        


                        <div id="imgMarcarRealizado" data-tooltip="#altMarcarRealizado" style="display:inline-block;" onclick="javascript:marcarRealizado(); return false;">'. $imgRealizado . '</div>
                        <div class="div-alt" id="altMarcarRealizado">Marcar como realizado</div>
                        


                        <div id="imgNotificarError" data-tooltip="#altNotificarError" style="display:inline-block;" onclick="javascript:notificarError(); return false;"><img class="imagen-menus-publicacion" src="images/header/notificar_error.png"></div>
                        <div class="div-alt" id="altNotificarError">Notificar error</div>

                        <div id="imgAyudaBusqueda" data-tooltip="#altAyudaBusqueda" style="display:inline-block;" onclick="javascript:ayudaBusqueda(); return false;"><img class="imagen-menus-publicacion" src="images/header/ayuda_busqueda.png"></div>
                        <div class="div-alt" id="altAyudaBusqueda">Ayudas de busqueda</div>
                        
                        <div id="imgMaterialComplementario" data-tooltip="#altMaterialComplementario" style="display:inline-block;" onclick="javascript:materialComplementario(); return false;"><img class="imagen-menus-publicacion" src="images/header/material_complementario.png"></div>
                        <div class="div-alt" id="altMaterialComplementario">Material complementario</div>
                          

                        <div id="imgColecciones" data-tooltip="#altColecciones" style="display:inline-block;" onclick="javascript:Colecciones(); return false;"><img class="imagen-menus-publicacion" src="images/header/colecciones.png"></div>
                        <div class="div-alt" id="altColecciones">Colecciones</div>
                          
                        <div id="imgCompartir" data-tooltip="#altCompartir" style="display:inline-block;" onclick="javascript:compartir(); return false;"><img class="imagen-menus-publicacion" src="images/header/compartir.png"></div>
                        <div class="div-alt" id="altCompartir">Compartir</div>
                          

                    </div>
                    <div id="divAyudaImagenes" align="center">
                        
                    </div>
                    
                    <div>
                    '. $this->cuerpo . '
                    </div>
                    <div align="center" class="">
                    ' . $bloqueColeccion .'
                    </div>
                    <div align="center" class="div-video-pdf-publicacion">
                    ' . $contenidoExtra .'
                    </div>
                    
                    
                     <div align="center" class="indicadores-publicacion" style="text-position: center;">
                     Ultima modificacion: '. $this->fechaUltimaPublicacion . ' 
                     </div>
                     <br>
                    <div align="center" id="divComentarios" class="div-comentarios-publicacion">
                        <form  id="formVerComentarios">
                            <input type="submit" value="Ver Comentarios" onclick="javascript:verComentarios(); return false;">
                        </form>

                    </div>
                     
                        
                </div>
            </div>
                ';
        
        return $salida;
    }

}








class PublicacionAnonimo  {
    var $id;
    
    var $titulo;
    var $tipo;
    var $cuerpo;
    var $autor;
    var $tipoDocumento;
    var $tipoClasificacion;
    var $encabezado;
    var $clase;
    var $fecha;
    var $fechaUltimaPublicacion;
    var $resumen;
    var $urlVideo;
    var $idMaterialComplementario;
    
    var $tipoMaterialComplementario;
    var $imagenMaterialComplementario;
    var $tituloConImagenesModificadas;
    var $usuario;
    
    function __construct($id) {

        
        
        
        $this->id = $id;
        $this->titulo = getTituloPublicacion($id);
        $this->tituloConImagenesModificadas = subirImagenesDeFoolder($this->titulo);
        $this->titulo = $this->tituloConImagenesModificadas;
        
        
        $this->tipoClasificacion = getTipoClasificacionPublicacion($id);
        $this->tipoDocumento = getTipoDocumentoPublicacion($id);
        $this->cuerpo = getCuerpoPublicacion($id);
        $this->autor = getAutorPublicacion($id);
        
        $this->fecha = getFechaPublicacion($id);
        $this->fechaUltimaPublicacion = getFechaUltimaModificacionPublicacion($id);
        $this->idMaterialComplementario = getIdMaterialComplementarioPublicacion($id);
        
        
        
        if($this->idMaterialComplementario!=0){
            $this->tipoMaterialComplementario = getTipoDocumentoPublicacion($this->idMaterialComplementario);
        
            switch ($this->tipoMaterialComplementario) {
                case 1:
                     $this->imagenMaterialComplementario = '<img src="../images/resolucion_video.png"><br/>Resolucion en video';

                    break;
                case 2:
                     $this->imagenMaterialComplementario = '<img src="../images/resolucion_pdf.png"><br/>Resolucion en pdf';

                    break;

                default:
                    break;
            }
            
        }
        

    }
    
    
    function getHtml(){
        
        $salida = $this->getScriptCargarComentarios();
        $salida .= $this->getTabla();
        
        
        return $salida;
    }
    
    
    
    
    function getScriptCargarComentarios(){
        $salida = '
        <script>
            function verComentarios(){
                $("#divComentarios").html("Registrese para poder visualizar los comentarios");
            }
         </script>
            ';
        
        return $salida;
    }
    
    function getMaterialComplementario(){
        $salida = "";
        if($this->idMaterialComplementario!=0){
            
            $salida .= '<br>Ejercicio tambien disponible en: <br>
                    <span class="enlace" id="linkMaterialComplementario'. $this->id . '">'. $this->imagenMaterialComplementario . '</span><br>
                
                <script>
                    $("#linkMaterialComplementario'. $this->id . '").click(function(){

                        $.ajax({
                            type: "POST",
                            url: "../publicacion.php?id='. $this->idMaterialComplementario . '",
                            data: "id='. $this->idMaterialComplementario . '",
                            success: function(msg){

                                $("#divPopUp").html(msg);


                            }   
                        });
                    return false; 
                    });
                </script>



                    ';
        }
        return $salida;
    }
    
    
    
    
    function getHtmlPresentacionPdf(){
        
        $salida = "";
        $idPdf = getNombrePDFPublicacion($this->id);
        $dir = '../pdf/img';
        $empiezan = $idPdf . '_';
        
        $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);
        sort($imagenes, SORT_ASC);
        
        for($i=0; $i<count($imagenes); $i++){
            $nombre = $imagenes[$i];
            $salida .= '
            
                <tr>
                    <td colspan="5"><img width="550" border="1" src="../pdf/img/'. $nombre . '"></td>
                </tr>';
        }
        
        $salida .= '
            
                <tr>
                    <td colspan="5"><br><b>Para descargsar el PDF se debe ser usuario registrado</b><td>
                </tr>
             ';
        
        
        return $salida;
    
    
 
    }
    
    
    function getTabla(){
        
        $contenidoExtra = "";
        switch ($this->tipoDocumento) {
            case 1:
                $contenidoExtra = getHtmlVideoEmbebidoPublicacion($this->id);

                break;
            case 2:
                $contenidoExtra = $this->getHtmlPresentacionPdf();

                break;

            default:
                break;
        }
        
        
        
        $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion" src="../images/header/guardado_later.png">';
        $imgRealizado = '<img class="imagen-menus-publicacion" src="../images/header/marcado_realizado.png">';

        
        
        
        
        $salida = '
            
            <script>
                $("#imgGuardarParaMasTarde").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left:  10,
                        top:  10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgCompartir").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgMarcarRealizado").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgNotificarError").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgAyudaBusqueda").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgMaterialComplementario").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                $("#imgColecciones").hover(function(e) {
                    var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                    var top = divPopup.top;
                    var left = divPopup.left;
                    $($(this).data("tooltip")).css({
                        left: e.clientX - left + 10,
                        top: e.clientY - top + 10
                        }).stop().show(100);
                        }, function() {
                    $($(this).data("tooltip")).hide();
                });
                
                function guardarParaMasTarde(){
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");
                
                }
                

                function marcarRealizado(){
                   
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");

                    
                 
                }
                function notificarError(){
                   
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");

                    
                 
                }
                function compartir(){
                    $.ajax({
                        type: "POST",
                        url: "p/compartir_publicacion.php",
                        data: "p='. $this->id .'",
                        success: function(msg){
                            $("#divAyudaImagenes").html(msg);
                        }   
                    });
                }

                
                function ayudaBusqueda(){
                   
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");

                 
                }
                function materialComplementario(){
                   
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");

                 
                }
                function Colecciones(){
                   
                    $("#divAyudaImagenes").load("p/necesario_registrarse.php");

                 
                }
            </script>
            

            
                            
            <div class="div-pop-up" style="text-align: left;" >
                <div class="div-contenedor-publicacion">
                    <div>
                    '. $this->titulo . '
                    </div>
                    
                    
                    <div class="indicadores-publicacion">
                    V:'. getNumeroDeVisitas($this->id) . '. ID:' . $this->id . '. @'. $this->autor . '. '. $this->fecha . '
                    </div>
                    <div class="imagenes-opciones-publicacion">
                    
                        <div id="imgGuardarParaMasTarde" data-tooltip="#altGuardarParaMasTarde" style="display:inline-block;" onclick="javascript:guardarParaMasTarde(); return false;">'. $imgGuardadoParaMasTarde . '</div>
                        <div class="div-alt" id="altGuardarParaMasTarde">Guardar para mas tarde</div>
                        


                        <div id="imgMarcarRealizado" data-tooltip="#altMarcarRealizado" style="display:inline-block;" onclick="javascript:marcarRealizado(); return false;">'. $imgRealizado . '</div>
                        <div class="div-alt" id="altMarcarRealizado">Marcar como realizado</div>
                        


                        <div id="imgNotificarError" data-tooltip="#altNotificarError" style="display:inline-block;" onclick="javascript:notificarError(); return false;"><img class="imagen-menus-publicacion" src="../images/header/notificar_error.png"></div>
                        <div class="div-alt" id="altNotificarError">Notificar error</div>

                        <div id="imgAyudaBusqueda" data-tooltip="#altAyudaBusqueda" style="display:inline-block;" onclick="javascript:ayudaBusqueda(); return false;"><img class="imagen-menus-publicacion" src="../images/header/ayuda_busqueda.png"></div>
                        <div class="div-alt" id="altAyudaBusqueda">Ayudas de busqueda</div>
                        
                        <div id="imgMaterialComplementario" data-tooltip="#altMaterialComplementario" style="display:inline-block;" onclick="javascript:materialComplementario(); return false;"><img class="imagen-menus-publicacion" src="../images/header/material_complementario.png"></div>
                        <div class="div-alt" id="altMaterialComplementario">Material complementario</div>
                          

                        <div id="imgColecciones" data-tooltip="#altColecciones" style="display:inline-block;" onclick="javascript:Colecciones(); return false;"><img class="imagen-menus-publicacion" src="../images/header/colecciones.png"></div>
                        <div class="div-alt" id="altColecciones">Colecciones</div>
                          
                        <div id="imgCompartir" data-tooltip="#altCompartir" style="display:inline-block;" onclick="javascript:compartir(); return false;"><img class="imagen-menus-publicacion" src="../images/header/compartir.png"></div>
                        <div class="div-alt" id="altCompartir">Compartir</div>
                            <br>
                    </div>
                    <div id="divAyudaImagenes" align="center">
                        
                    </div>
                    
                    <div>
                    '. $this->cuerpo . '
                    </div>
                    
                    <div align="center" class="div-video-pdf-publicacion">
                    ' . $contenidoExtra .'
                    </div>
                    
                    
                     <div align="center" class="indicadores-publicacion" style="text-position: center;">
                     Ultima modificacion: '. $this->fechaUltimaPublicacion . ' 
                     </div>
                     <br>
                    <div align="center" id="divComentarios" class="div-comentarios-publicacion">
                        <form  id="formVerComentarios">
                            <input type="submit" value="Ver Comentarios" onclick="javascript:verComentarios(); return false;">
                        </form>

                    </div>
                     
                        
                </div>
            </div>
                ';
        
        return $salida;
    }


}








class PublicacionResumen  {
    var $id;
    var $titulo;
    var $tipoDocumento;
    var $tipoClasificacion;
    var $clase;
    var $cuerpo;
    var $autor;
    var $encabezado;
    var $fecha;
    var $resumen;
    var $imagen;
   
    var $fechaUltimaModificacion;
    var $guardadoParaMasTarde;
    var $realizado;
    var $usuario;
    
    function __construct($id, $usuario){
        
        $this->usuario = $usuario;
        $this->id = $id;
        $this->titulo = getTituloPublicacion($id);
        
        $this->tipoDocumento = getTipoDocumentoPublicacion($id);
        $this->tipoClasificacion = getTipoClasificacionPublicacion($id);
        
        $this->cuerpo = getCuerpoPublicacion($id);
        $this->autor = getAutorPublicacion($id);
        
        $this->fecha = getFechaPublicacion($id);
        
        $this->realizado = comprobarSiUsuarioHaRealizadoPublicacion($usuario, $id);
        
        $this->guardadoParaMasTarde = comprobarSiPublicacionGuardadaParaMasTarde($usuario, $id);
        
        
        $this->fechaUltimaModificacion = getFechaUltimaModificacionPublicacion($id);
        
        
        //tipoDocumento:    1- resolucion video
        //                  2- resolucion pdf
        
        
        
        switch ($this->tipoDocumento) {
            case 1:
                 $this->imagen = 'youtube';

                break;
            case 2:
                 $this->imagen = 'pdf';

                break;

            default:
                break;
        }
        
        
        switch ($this->tipoClasificacion) {
            case 2:
                $this->clase = 'tabla_publicacion_resolucion_problema';
                $this->encabezado = 'Resolucion problema. ID ';
                break;
            case 1:
                  
                $this->clase = 'tabla_publicacion_noticia';
                $this->encabezado = 'Noticia. ID ';
                
                break;

            default:
                break;
        }

    }
    
    
    function getHtml(){
        
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    
    function getTabla(){
        
        
        
        
      
        
        if($this->guardadoParaMasTarde){
            $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion-no-opaco" src="images/header/guardado_later.png">';
        }else{
            $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion" src="images/header/guardado_later.png">';
        }
        if($this->realizado){
            $imgRealizado = '<img class="imagen-menus-publicacion-no-opaco" src="images/header/marcado_realizado.png">';
        }else{
            $imgRealizado = '<img class="imagen-menus-publicacion" src="images/header/marcado_realizado.png">';
        }
        
        
        $visitas = getNumeroDeVisitas($this->id);
        $palabraVisitas = "visitas";
        if($visitas==1){
            $palabraVisitas = "visita";
        }
        
        
        
        $salida = '
                    <div class="div-contenedor-publicacion-resumen">
                        <script>
                        $("#linkVerPublicacion'. $this->id . '").click(function(){
                            
                                $("#divPopUp").bPopup({
                                    follow: [false, false],
                                    loadUrl: "publicacion.php?id='. $this->id . '"
                                });
                        });   
                        
                        
                        function guardarParaMasTarde'. $this->id .'(){
                                $.ajax({
                                type: "POST",
                                url: "acciones/guardar_para_mas_tarde.php",
                                data: "id='. $this->id . '",
                                success: function(msg){
                                    $("#imgGuardarParaMasTarde' . $this->id .'").html(msg);

                                }
                            });
                        }
                

                        function marcarRealizado'. $this->id .'(){

                            $.ajax({
                                type: "POST",
                                url: "acciones/marcar_publicacion_realizada.php",
                                data: "id='. $this->id .'",
                                success: function(msg){
                                    $("#imgMarcarRealizado' . $this->id .'").html(msg);
                                }   
                            });
                        }

                            
                        </script>
                        
                        <div style="width: 100%;">
                            <div id="linkVerPublicacion'. $this->id . '" style="float: left; " class="div-contenedor-imagen-publicacion"><img src="images/'. $this->imagen . '.png"></div>
                            <div style="width: 100%; min-height: 180px;">
                                <div style="min-height: 116px; padding-top: 20px" >' . $this->titulo . '</div>
                                <div style="width: 100%; text-align: center;">
                                    <div id="imgGuardarParaMasTarde' . $this->id .'" style="display:inline-block;" onclick="javascript:guardarParaMasTarde'. $this->id .'(); return false;">'. $imgGuardadoParaMasTarde . '</div>
                                    <div id="imgMarcarRealizado' . $this->id .'" style="display:inline-block;" onclick="javascript:marcarRealizado'. $this->id .'(); return false;">'. $imgRealizado . '</div>
                                </div>
                                <div style="height: 18px; width: 100%; text-align: center;">Última modificación : '. $this->fechaUltimaModificacion . '</div>
                            </div>
                            <div class="div-pie-publicacion">publicación ' . $this->id . ' | @'. $this->autor . ' | '. getNumeroDeComentarios_Publicaciones($this->id) . ' comentarios | '. $visitas . ' '. $palabraVisitas . ' | fecha creación '. $this->fecha . '</div>

                        </div>
                        
                     </div>
                        ';
        
        
        return $salida;
    }
    
    
    function getRealizado(){
        if($this->realizado){
        $salida = '
                
                <tr>
                    <td colspan="5" ><img src="images/marcar_realizado.png"></td>
                </tr>
                
                
                ';
        }else{
            $salida = "";
        }
        return $salida;
    }
}