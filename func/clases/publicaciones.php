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
    var $nivel;
    var $s;
    var $dir;
    var $dif;
    var $nivelUsuario;
    
    function __construct($id, $usuario, $col=null, $posComentario =null, $nivel) {

        
        
        $this->nivel = $nivel;
        $this->s = getCadenaSubirNivel($nivel);
        $this->col = $col;
        $this->posComentario = $posComentario;
        $this->dir = getDirPublicacion($id);
        $this->dif = getDificultadPublicacion($id);
        $this->id = $id;
        $this->titulo = subirImagenesDeFoolder(getTituloPublicacion($id), $nivel);
        $this->tipoClasificacion = getTipoClasificacionPublicacion($id);
        $this->tipoDocumento = getTipoDocumentoPublicacion($id);
        $this->cuerpo = subirImagenesDeFoolder(getCuerpoPublicacion($id), $nivel);
        $this->autor = getAutorPublicacion($id);
        
        $this->fecha =  getFechaFormatoClaro(getFechaPublicacion($id));
        $this->fechaUltimaPublicacion = getFechaFormatoClaro(getFechaUltimaModificacionPublicacion($id));
        $this->idMaterialComplementario = 0;
        if($usuario != null){
            $this->idMaterialComplementario = getIdMaterialComplementarioPublicacion($id);
        }
        $this->usuario = $usuario;
        $this->realizado = false;
        $this->guardadoParaMasTarde = false;
        if($usuario!=null){
            $this->realizado = comprobarSiUsuarioHaRealizadoPublicacion($usuario, $id);
            $this->guardadoParaMasTarde = comprobarSiPublicacionGuardadaParaMasTarde($usuario, $id);
        }
        $this->nivelUsuario = getNivelUsuario($usuario);
        $this->imagenMaterialComplementario  = "";
        if($usuario!=null){
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
 
        
    }
    
    
    
    
    function getHtml(){
        
        //$salida = $this->getScriptCargarComentarios();
        $salida = $this->getTabla();

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
        
       
        $s = $this->s;
        $salida = "";
        $idPdf = getNombrePDFPublicacion($this->id);
        $dir = $s . 'images/pdf/img';
        $empiezan = $idPdf . '_';
        
        $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);
        sort($imagenes, SORT_ASC);
        
        for($i=0; $i<count($imagenes); $i++){
            $nombre = $imagenes[$i];
            $salida .= '
                     <div style="margin-top: 10px;"><img width="550" border="1" src="'.$s.'images/pdf/img/'. $nombre . '"></div>
                ';
        }
        
        $salida .= '
               
                   <div class="div-boton-estandar"><a  class="descarga" href="'.$s.'acc/descargar_pdf.php?&id='. $this->id . '" TARGET="_blank">Descargar PDF</a></div>
               
             ';
        return $salida;
    
    
 
    }
    
    function getTabla(){
        
        global $idDeveloperFB;
        global $frecuenciaPubliVideos;
        $s = $this->s;
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
        
        
        $imgGuardadoParaMasTarde = "";
        $imgRealizado = "";
        $bloqueEditor = "";
        if($this->usuario!=null){
            if($this->guardadoParaMasTarde){
                $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion-no-opaco" src="'.$s.'images/header/guardado_later.png">';
            }else{
                $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion" src="'.$s.'images/header/guardado_later.png">';
            }
            if($this->realizado){
                $imgRealizado = '<img class="imagen-menus-publicacion-no-opaco" src="'.$s.'images/header/marcado_realizado.png">';
            }else{
                $imgRealizado = '<img class="imagen-menus-publicacion" src="'.$s.'images/header/marcado_realizado.png">';
            }
            $bloqueEditor = "";
            if($this->nivelUsuario==3){
                $bloqueEditor = '<div class="masterTooltip'. $this->pagina .'" title="Editar"  style="display:inline-block;" ><a href="'.$s.'admin/s/publicaciones_aprobadas.php?id='.$this->id.'"><img class="imagen-menus-publicacion-no-opaco" src="'. $s . 'images/header/editar.png"></a></div>';
            }
        }
        
        
        
        if($this->col != null){
            
            $nombre = getNombreColeccion($this->col);
            
            $bloqueColeccion = 'Colección: </b> '.  $nombre . '. <br>
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
                        $dir = getDirPublicacion($ids[$i-1]);
                        $bloqueColeccion .=  '<a href="'.$s .'p/' .$dir .'/?c='.$this->col.'"><div style="margin: 10px; display: inline-block"><img src="'.$s.'images/header/flecha_izquierda.png"></div></a>';
                    }
                    if($i< count($ids)-1){
                        $dir = getDirPublicacion($ids[$i+1]);
                        $bloqueColeccion .= '<a href="'.$s .'p/'.$dir .'/?c='.$this->col.'"><div style="margin: 10px;  display: inline-block"><img src="'.$s.'images/header/flecha_derecha.png"></div></a>';
                    }
                }
            }
            
            $bloqueColeccion = '<div class="div-bloque-coleccion-publicacion">' . $bloqueColeccion . '</div>';
        }else{
            $bloqueColeccion = null;
        }
        
        $idMatComplementario = -1;
        $msgMaterialComplementario = "";
        $tipoDocumentoComplementario = -1;
        $ayudas = "";
        $ayudasALaBusqueda = "";
        $colecciones = "";
        $msg = "";
        $msgColecciones = "";
        $msgAltaDefinicion = "";
        if($this->usuario!=null){
            $idMatComplementario = getIdMaterialComplementarioPublicacion($this->id);
            $msgMaterialComplementario = "<b>Material complementario</b><br>";
            if($idMatComplementario==0){
                $msgMaterialComplementario .= 'Este contenido no tiene material complementario';
            }else{
                $tipoDocumentoComplementario = getTipoDocumentoPublicacion($idMatComplementario);
                if($tipoDocumentoComplementario==1){
                    $msgMaterialComplementario .= '<div style="display: inline-block;">Este material está tambien disponible en formato Video</div>';
                }else{
                    $msgMaterialComplementario .= '<div style="display: inline-block;">Este material está tambien disponible en formato PDF</div>';
                }
                $dirMatComplementario = getDirPublicacion($idMatComplementario);
                $msgMaterialComplementario .= '
                    <div style="display: inline-block;" class="div-boton-estandar" onclick="javascript:window.location=\''. $s . 'p/' . $dirMatComplementario .'\'">Ver</div>';
                if($this->tipoMaterialComplementario==2){
                    $msgAltaDefinicion = 'Instrucciones para ver el video en alta calidad: <br><img src="'.$s.'images/header/subir_calidad1.png"><br><img src="'.$s.'images/header/subir_calidad2.png"><br><img src="'.$s.'images/header/subir_calidad3.png">';
                }
            }

            $ayudas = convertirHTMLenTextoPlano(getAyudasALaBusquedaPublicacion($this->id));
            $ayudasALaBusqueda = '<b>Ayudas a la busqueda</b><br>A continuacion te mostramos las palabras clave de este ejercicio que
            podras utilizar en el cuadro de busqueda superior para encontrarlo con el fin de que te pueda ser util 
            en proximas busquedas de diferentes ejercicios.<br>
            Ayudas a la busqueda: <b><span style="color: red">' . $ayudas . '</span></b>
            <br><br>';

            $colecciones = getColeccionesDePublicacion($this->id);
            if(count($colecciones)==0){
                $msg = "Este problema no se encuentra dentro de ninguna colección todavía.";
            }else{
                $msg = "Este problema se encuentra dentro de las siguientes colecciones:<br> ";
                for($i=0; $i<count($colecciones); $i++){
                    $nombre = getNombreColeccion($colecciones[$i]);
                    $msg .= '<span onclick="">' . $nombre . "</span><br>";
                }
            }

            $msgColecciones =  '
                <b>Colecciones.</b><br>'. $msg . '';
        }
        $hrefFB = "http://seistemas.com";
        $urlFB = "https://www.facebook.com/dialog/share?app_id=". $idDeveloperFB."&display=popup&href=". $hrefFB ."&redirect_uri=". $hrefFB;
        
        
        $bloqueCompartir = ''
                . '<div style="display: inline-block"><a href="'.$urlFB.'"><img class="masterTooltip" title="Facebook" style="width: 48px" src="'. $s .'images/header/rrss/facebook.png"></a></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Twitter" style="width: 48px" src="'. $s .'images/header/rrss/twitter.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Google+"   style="width: 48px" src="'. $s .'images/header/rrss/google_plus.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Correo"   style="width: 48px" src="'. $s .'images/header/rrss/correo.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Linked In"   style="width: 48px" src="'. $s .'images/header/rrss/linkedin.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Evernote"   style="width: 48px" src="'. $s .'images/header/rrss/evernote.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Blogger"   style="width: 48px" src="'. $s .'images/header/rrss/blogger.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Reddit"   style="width: 48px" src="'. $s .'images/header/rrss/reddit.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Meneame"   style="width: 48px" src="'. $s .'images/header/rrss/meneame.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Tuenti"   style="width: 48px" src="'. $s .'images/header/rrss/tuenti.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Tumblr"   style="width: 48px" src="'. $s .'images/header/rrss/tumblr.png"></div>
    <div style="display: inline-block"><img class="masterTooltip" title="Whatsapp"   style="width: 48px" src="'. $s .'images/header/rrss/whatsapp.png"></div>
    <input type="text" style="text-align: center; font-family: \'Open Sans\' , sans-serif; color: #000; width: 400px; height: 20px;" value = "http://seistemas.com/?p='. $this->id .'">';
        
        $bloquePubli = "";
        if($this->tipoDocumento==1){
            if($this->id%$frecuenciaPubliVideos === 0){
                $bloquePubli = '
                    <script>
                    var p = $("#div-video-pdf-publicacion").position();
                    $("#popup_box").css({top: p.left, left: p.top});
                    </script>
                    <div id="popup_box"> 
                        <div>Pblicidad. Se cerrará en 5 segundos</div>

                    </div>';
            }
        }
        
        
        $bloqueMenusSuperior = "";
        $bloqueHD ="";
        if($this->tipoMaterialComplementario==2){
            $bloqueHD = '<div id="divContenidoAltaDefinicion'.$this->id.'" style="display: none;">'.$msgAltaDefinicion.'</div>
                        <div class="masterTooltip" title="Video en HD" style="display:inline-block;" onclick="javascript:clickHD(\''. $this->id.'\', '. $this->nivel .'); return false;"><img class="imagen-menus-publicacion" src="'.$s.'images/header/hd.png"></div>';
        }
        if($this->usuario!=null){
            $bloqueMenusSuperior = '

                        <div id="imgGuardarParaMasTarde'. $this->id .'" style="display:inline-block;" class="masterTooltip" title="Guardar para más tarde" onclick="javascript:guardarParaMasTarde(\''. $this->id.'\', '. $this->nivel .'); return false;">'. $imgGuardadoParaMasTarde . '</div>
                        <div id="imgMarcarRealizado'. $this->id .'" class="masterTooltip"  style="display:inline-block;" title="Marcar realizado" onclick="javascript:marcarRealizado(\''. $this->id.'\', '. $this->nivel .'); return false;">'. $imgRealizado . '</div>
     
                        <div class="masterTooltip" title="Notificar error" style="display:inline-block;" onclick="javascript:notificarError(\''. $this->id.'\', '. $this->nivel .'); return false;"><img class="imagen-menus-publicacion" src="'.$s.'images/header/notificar_error.png"></div>
                        <div class="masterTooltip" title="Ayudas de busqueda" style="display:inline-block;" onclick="javascript:clickAyudasBusqueda(\''. $this->id.'\', '. $this->nivel .'); return false;"><img class="imagen-menus-publicacion" src="'.$s.'images/header/ayuda_busqueda.png"></div>
                        <div id="divContenidoAyudasBusqueda'.$this->id.'" style="display: none;">'.$ayudasALaBusqueda.'</div>
                        <div class="masterTooltip" title="Material complementario" style="display:inline-block;" onclick="javascript:clickMaterialComplementario(\''. $this->id.'\', '. $this->nivel .'); return false;"><img class="imagen-menus-publicacion" src="'.$s.'images/header/material_complementario.png"></div>
                        <div id="divContenidoMaterialComplementario'.$this->id.'" style="display: none;">'.$msgMaterialComplementario.'</div>
                        <div class="masterTooltip" title="Colecciones" style="display:inline-block;" onclick="javascript:clickColecciones(\''. $this->id.'\', '. $this->nivel .'); return false;"><img class="imagen-menus-publicacion" src="'.$s.'images/header/colecciones.png"></div>
                        '.$bloqueHD.'
                        
                        <div id="divContenidoColecciones'.$this->id.'" style="display: none;">'.$msgColecciones.'</div>'
                    . ''.$bloqueEditor.'';
            
        
        }
        
        
        $bloqueDificultad = "";
        switch ($this->dif) {
            case 0:
                $bloqueDificultad = '☆☆☆☆☆';

                break;
            case 1:
                $bloqueDificultad = '★☆☆☆☆';

                break;
            case 2:
                $bloqueDificultad = '★★☆☆☆';

                break;
            case 3:
                $bloqueDificultad = '★★★☆☆';

                break;
            case 4:
                $bloqueDificultad = '★★★★☆';

                break;
            case 5:
                $bloqueDificultad = '★★★★★';

                break;
           
            default:
                break;
        }
        
        
        $salida = '
            

                <div class="div-contenedor-estandar" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; margin-top: 10px;">
                    '.$bloqueColeccion.'
                    <div style="margin-bottom: 10px;">
                    '. $this->cuerpo . '
                    </div>
                    <div class="indicadores-publicacion">
                    V:'. getNumeroDeVisitas($this->id) . '. ID:' . $this->id . '. @'. $this->autor . '. '. $this->fecha . '
                    </div>
                    Dificultad: '.$bloqueDificultad.'
                    <div style="margin-top:10px; margin-bottom: 10px;"> 
                    '.$bloqueMenusSuperior.'
                    </div>
                    <div id="divClickAccionPublicacion" style="text-align:center; margin:16px;">
                        
                    </div>
                    <div style="text-align: center; margin-top: 10px; margin-bottom: 30px;">'. $bloqueCompartir .'</div>
                    
                    <div>
                    '. $this->titulo . '
                    </div>
                    <div align="center" class="div-video-pdf-publicacion" id="div-video-pdf-publicacion">
                    '. $bloquePubli .'
                    ' . $contenidoExtra .'
                    </div>
                    
                    
                     <div align="center" class="indicadores-publicacion" style="text-position: center;">
                     Ultima modificacion: '. $this->fechaUltimaPublicacion . ' 
                     </div>
                     '.$bloqueColeccion.'
                     <br>
                     <script>verComentariosPublicacion(\''. $this->id.'\', '. $this->nivel .', 1);</script>
                    <div align="center" id="divComentarios" class="div-comentarios-publicacion">
                    </div>
                </div>
            
                ';
        
        return $salida;
    }


}

class PublicacionResumen2SoloConID {
    var $id;
    var $usuario;
    var $nivel;
    var $pagina;
    var $ref;
    function __construct($id, $usuario, $nivel, $pagina, $ref=null) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nivel = $nivel;
        $this->pagina = $pagina;
        $this->ref = $ref;
        
    }
    function getHtml(){
        $publicacion = getPublicacion($this->id);
        $elemento = new PublicacionResumen2($publicacion, $this->usuario, 
                $this->nivel, $this->pagina,  $this->ref);
        return $elemento->getHtml();
    }
    
}



class PublicacionResumen2  {
    var $id;
    var $titulo;
    var $tipoDocumento;
    
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
    var $dir;
    var $nivel;
    var $nivelUsuario;
    var $s;
    var $visitas;
    var $idReferencia;
    var $ref;
    var $pagina;
    var $dif;
    
    
    function __construct($publicacion, $usuario, $nivel, $pagina, $ref=null) {

        //la pagina es para que todos los toolTip de esta publicacion
        //coincidan con el script generado para cada pagina. Sería
        //la pagina 1 en la portada, la pagina 2 cuando das una vez a cargarMas
        //etc
        $this->pagina = $pagina;
        $id = $publicacion['id'];
        $this->titulo = subirImagenesDeFoolder($publicacion['titulo'], $nivel);
        $this->dir = $publicacion['dir'];
        $this->dif = $publicacion['dificultad'];
        $this->tipoDocumento = $publicacion['tipo_documento'];
        
        $this->cuerpo = subirImagenesDeFoolder($publicacion['cuerpo'], $nivel);
        $this->autor = $publicacion['autor'];
        $this->fecha = getFechaFormatoClaro($publicacion['fecha']);
        $this->fechaUltimaModificacion = getFechaFormatoClaro($publicacion['fecha_ultima_modificacion']);
        $this->visitas = $publicacion['visitas'];
            
        
        
        $this->id = $id;
        $this->nivel = $nivel;
        $this->nivelUsuario = getNivelUsuario($usuario);
        $this->s = getCadenaSubirNivel($nivel);
        $this->usuario = $usuario;
        $this->guardadoParaMasTarde = comprobarSiPublicacionGuardadaParaMasTarde($usuario, $id);
        $this->realizado = comprobarSiUsuarioHaRealizadoPublicacion($usuario, $id);
        
        $this->ref = $ref;
        
        
        $this->imagen = 'youtube';
        if($this->tipoDocumento==2){
            $this->imagen = 'pdf';
        }
    }
    
    
    function getHtml(){
        
        $s = $this->s;
        $imgGuardadoParaMasTarde = "";
        if($this->usuario!=null){
            if($this->guardadoParaMasTarde){
                $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion-no-opaco" src="'.$s.'images/header/guardado_later.png">';
            }else{
                $imgGuardadoParaMasTarde = '<img class="imagen-menus-publicacion" src="'.$s.'images/header/guardado_later.png">';
            }
        }
        
        $imgRealizado = "";
        if($this->usuario!=null){
            if($this->realizado){
                $imgRealizado = '<img class="imagen-menus-publicacion-no-opaco" src="'.$s.'images/header/marcado_realizado.png">';
            }else{
                $imgRealizado = '<img class="imagen-menus-publicacion" src="'.$s.'images/header/marcado_realizado.png">';
            }
        }
      
        $extraGuardadoParaMasTarde = "";
        $extraMarcarRealizado = "";
        $bloqueEditor = "";
        if($this->usuario!=null){
            if($this->ref==3){
                $extraGuardadoParaMasTarde = ',1';
            }
            $extraMarcarRealizado = null;
            if($this->ref==4){
                $extraMarcarRealizado = ',1';
            }

            $bloqueEditor = "";
            if($this->nivelUsuario==3){
                $bloqueEditor = '<div class="masterTooltip'. $this->pagina .'" title="Editar"  style="display:inline-block;" ><a href="'.$s.'admin/s/publicaciones_aprobadas.php?id='.$this->id.'"><img class="imagen-menus-publicacion-no-opaco" src="'. $s . 'images/header/editar.png"></a></div>';
            }
        }
        
        
        $bloqueDificultad = "";
        switch ($this->dif) {
            case 0:
                $bloqueDificultad = '☆☆☆☆☆';

                break;
            case 1:
                $bloqueDificultad = '★☆☆☆☆';

                break;
            case 2:
                $bloqueDificultad = '★★☆☆☆';

                break;
            case 3:
                $bloqueDificultad = '★★★☆☆';

                break;
            case 4:
                $bloqueDificultad = '★★★★☆';

                break;
            case 5:
                $bloqueDificultad = '★★★★★';

                break;
           
            default:
                break;
        }
        
        $visitas = $this->visitas;
        $palabraVisitas = "visitas";
        if($visitas==1){
            $palabraVisitas = "visita";
        }
       
        $imagenes = $this->getThumbails();
        
        $numComentarios = getNumeroDeComentarios_Publicaciones($this->id);
        if($numComentarios==1){
            $palabraComentarios = "comentario";
        }else{
            $palabraComentarios = "comentarios";
        }
        
        $bloqueMenusInferior = "";
        if($this->usuario!=null){
        $bloqueMenusInferior = '<div id="imgGuardarParaMasTarde' . $this->id .'" class="masterTooltip'. $this->pagina .'" title="Guardar para más tarde" style="display:inline-block;" onclick="guardarParaMasTarde(\''. $this->id .'\' , '. $this->nivel . $extraGuardadoParaMasTarde . ');">'. $imgGuardadoParaMasTarde . '</div>
                    <div id="imgMarcarRealizado' . $this->id .'" class="masterTooltip'. $this->pagina .'" title="Marcar realizado"  style="display:inline-block;" onclick="marcarRealizado(\''. $this->id .'\', '. $this->nivel . $extraMarcarRealizado .');">'. $imgRealizado . '</div>
                    '.$bloqueEditor;
        }
        
        $salida = '
            <div id="divPublicacionResumen'.$this->id.'" class="div-contenedor-estandar">
                <div style="margin-right:10px; float: left">
                    <img  style="padding-top: 10px; height: 40px; width: 40px;" src="'.$s.'images/'. $this->imagen . '.png">
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px; margin-right:10px;">
                Publicación ' . $this->id  . " " . $bloqueDificultad . " " .  $this->titulo . '
                    <div id="div-thumbnail-pub'. $this->id .'" style="width: 100%; margin-top:10px; text-align: center;">
                    '. $imagenes . '
                    </div>
                </div>
                
                <div style="width: 100%; text-align: center; margin-top:10px;">
                '.$bloqueMenusInferior.'    
                </div>
                <div style="width: 100%">
                    <div style="display: inline-block; width: 28%; text-align: right">
                    @'. $this->autor .'
                    </div>
                    <div style="display: inline-block; width: 40%; text-align: center">
                    '. $this->fechaUltimaModificacion .'
                    </div>
                    
                    <div style="display: inline-block; width: 28%; text-align: left;">
                    '. $numComentarios .' '. $palabraComentarios .'
                    </div>
                </div>
            </div>
            

                    ';
        
        return $salida;
    }
    
    
  
    
    function getThumbails(){
        $s = $this->s;
         switch ($this->tipoDocumento) {
            case 1:
                 $this->imagen = 'youtube';
                    $idReferencia = getIdentificativoReferenciaVideoPublicacion($this->id);
                    $salida = '<a href="' . $s . '/p/' . $this->dir . '"><img class="imagen-thumbnail" width="180"  src="http://img.youtube.com/vi/'. $idReferencia .'/hqdefault.jpg"></a>';
                
                
                break;
            case 2:
                 
                    $salida = "";
                    $idPdf = getNombrePDFPublicacion($this->id);
                    $dir = ''.$s.'images/pdf/img/thumb';
                    $empiezan = $idPdf . '_';

                    $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);
                    sort($imagenes, SORT_ASC);

                    for($i=0; $i<count($imagenes); $i++){
                        $nombre = $imagenes[$i];
                        $salida .= '
                            <a href="' . $s . '/p/' . $this->dir . '">
                            <div class="imagen-thumbnail">
                                <img width="120" src="'.$s.'images/pdf/img/thumb/'. $nombre . '"></td>
                            </div>
                            </a>';
                    }
                break;
            default:
                break;
        }
        return $salida;
    }
    
    
}