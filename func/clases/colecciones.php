<?php

class ColeccionResumen2SoloConID {
    var $id;
    var $usuario;
    var $nivel;
    var $pagina;
    var $ref;
    function __construct($id, $usuario, $nivel) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nivel = $nivel;
        
        
    }
    function getHtml(){
        $coleccion = getColeccion($this->id);
        $elemento = new ColeccionResumen2($coleccion, $this->usuario, 
                $this->nivel);
        return $elemento->getHtml();
    }
    
}



class ColeccionResumen2  {
    var $id;
    var $nombre;
    
    var $clase;
    var $descripcion;
    var $autor;
    var $encabezado;
    var $fecha;
    var $resumen;
    var $imagen;
   
    var $fechaUltimaModificacion;
    var $guardadoParaMasTarde;
    var $realizado;
    var $usuario;
    var $numPublicaciones;
    var $visitas;
    var $profundidad;
    var $nivel;
    var $formato;
    var $tipoColeccion;
    var $ids;
    var $s;
    function __construct($coleccion, $usuario, $nivel) {
        
        $id = $coleccion["id"];
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->id = $id;
        $this->nombre = subirImagenesDeFoolder($coleccion["nombre"], $nivel);
        $this->descripcion = subirImagenesDeFoolder($coleccion["descripcion"], $nivel);
        $this->autor = $coleccion["autor"];;
        
        $this->visitas = $coleccion["visitas"];;
        $this->fecha = getFechaFormatoClaro($coleccion["fecha_creacion"]);
        $this->fechaUltimaModificacion = getFechaFormatoClaro($coleccion["fecha_ultima_modificacion"]);;
        $this->imagen = $coleccion["imagen"];
        $this->formato = $coleccion["formato"]; 
        $this->s = getNiveles($nivel);
        
        $this->tipoColeccion = $coleccion["coleccion"];
        
        if($this->tipoColeccion==1){
            //$titulos = getTitulosColeccion($this->id);
            $this->ids = getReferenciasColeccion($this->id);
            $this->ids = explode(" ", $this->ids);
           
        }elseif($this->tipoColeccion==2){
            //$titulos = getTitulosColeccionColeccion($this->id);
            //var_dump($titulos);
            $this->ids = getIDsColeccionColeccion($this->id);
            $this->ids = array_interseccion_colecciones($this->ids, $this->ids);

        }
        
        
        
    }
    
    
    function getHtml(){
        
        $salida = $this->getTabla();
        //$salida .= $this->getScriptLinkVerPublicacion();
        return $salida;
    }
    
    
    
    
    function getTabla(){
        
        
        $s = getNiveles($this->nivel);
       $img = "";
        if($this->formato==1){
            $img = '<img  style="padding-top: 10px; height: 40px; width: 40px;" src="'.$s.'images/youtube.png">';
        }elseif($this->formato==2){
            $img = '<img  style="padding-top: 10px; height: 40px; width: 40px;" src="'.$s.'images/pdf.png">';

        }elseif($this->formato==3){
            $img = '<img  style="padding-top: 10px; height: 40px; width: 40px;" src="'.$s.'images/youtube.png">'
                    . '<img  style="padding-top: 10px; height: 40px; width: 40px;" src="'.$s.'images/pdf.png">';

        }
        
        
        
        
        $col = getColeccionColeccion($this->id);
        
        if($col==1){
            $titulos = getTitulosColeccion($this->id);
            $ids = getReferenciasColeccion($this->id);
            $ids = explode(" ", $ids);
            $primerID = $ids[0];
        }
        if($col==2){
            $titulos = getTitulosColeccionColeccion($this->id);
            //var_dump($titulos);
            $ids = getIDsColeccionColeccion($this->id);
            $ids = array_interseccion_colecciones($ids, $ids);
            
            $primerID = $ids[0];
        }
        
        //$this->numPublicaciones = getNumeroDePublicacionesEnColeccion($this->id);
        $this->numPublicaciones = count($ids);
        
        $this->profundidad = getProfundidadColeccion($this->id);
        
        
        
        
        $txtTitulos = "";
        //for($i=0; $i<count($titulos); $i++){
        //    
        //    $txtTitulos .= str_replace("<br>", " | ", $titulos[$i]);
        //    if($i<count($titulos)-1){
        //        $txtTitulos .=  ' <span class="mencion_hastag_comentario">*</span> ';
        //    }
        //}
        
        
        
        if($this->visitas==1){
            $palabraVisitas = "visita";
        }else{
            $palabraVisitas = "visitas";
        }
        
        $imagenes = $this->getThumbails();
        
        $salida = '
            <div class="div-contenedor-estandar">
                <div onclick="" style="margin-right:10px; float: left">
                    '.$img.'
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px; margin-right:10px;">
                Colección ' . $this->id . ". " .  $this->nombre . '.<br> ' . $this->descripcion . '
                    <div id="div-thumbnail-pub'. $this->id .'" style="width: 100%; margin-top:10px; text-align: center;">
                    '. $imagenes . '
                    </div>
                </div>
                
                
                <div style="width: 100%">
                    <div style="display: inline-block; width: 28%; text-align: right">
                    @'. $this->autor .'
                    </div>
                    <div style="display: inline-block; width: 40%; text-align: center">
                    '. $this->fechaUltimaModificacion .'
                    </div>
                    <div style="display: inline-block; width: 28%; text-align: left;">
                    '. $this->visitas .' '. $palabraVisitas .'
                    </div>
                </div>
            </div>
            
                    ';
        
      
        return $salida;
    }
    
    function getThumbails(){
        $s = $this->s;
        global $numeroDeThumbsVideosPorColeccion;
        global $numeroDeThumbsPDFPorColeccion;
        
        $salida = "";
        
        if($this->formato==1){
            for ($i = 0; $i < min(count($this->ids), $numeroDeThumbsVideosPorColeccion-1); $i++) {
                $idReferencia = getIdentificativoReferenciaVideoPublicacion($this->ids[$i]);
                $dirUrl = getDirPublicacion($this->ids[$i]) . '/?c=' . $this->id;
                $salida .= '<a href="'. $s . 'p/' . $dirUrl .'"><img class="imagen-thumbnail"  width="180" style="display: inline-block; margin-right:2px;"  src="http://img.youtube.com/vi/'. $idReferencia .'/hqdefault.jpg"></a>';
            }
            if(count($this->ids)>=$numeroDeThumbsVideosPorColeccion){
                $dirUrl = getDirPublicacion($this->ids[$numeroDeThumbsVideosPorColeccion]). '/?c=' . $this->id;
                $salida .= '<a href="'. $s . 'p/' . $dirUrl .'"><img  class="imagen-thumbnail" width="180" style="border: 1 black; display: inline-block; margin-right:2px;"  src="'.$s.'images/header/mas_thumbs_video.png"></a>';
            }
        }elseif($this->formato==2){
            for ($i = 0; $i < min(count($this->ids), $numeroDeThumbsPDFPorColeccion-1); $i++) {
                $imagenes = array();
                $idPdf = getNombrePDFPublicacion($this->ids[$i]);
                $dir = ''.$s.'images/pdf/img/thumb';
                $empiezan = $idPdf . '_';
                $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);
                sort($imagenes, SORT_ASC);
                
                $dirUrl = getDirPublicacion($this->ids[$i]). '/?c=' . $this->id;
                
                $nombre = $imagenes[0];
                $salida .= '
                    <a href="'. $s . 'p/' . $dirUrl .'"><div style="vertical-align: top; width: 120px; height: 168px" class="imagen-thumbnail">
                        <img src="'.$s.'images/pdf/img/thumb/'. $nombre . '"></td>
                    </div></a>';
            }
            if(count($this->ids)>=$numeroDeThumbsPDFPorColeccion){
                $dirUrl = getDirPublicacion($this->ids[$numeroDeThumbsPDFPorColeccion-1]). '/?c=' . $this->id;
                $salida .= '
                    <a href="'. $s . 'p/' . $dirUrl .'"><div style="vertical-align: top; width: 120px; height: 168px" class="imagen-thumbnail">
                        <img src="'.$s.'images/header/mas_thumbs_pdf.png"></td>
                    </div></a>';
            }
            
        }elseif($this->formato==3){
            
        }
        
         switch ($this->formato) {
            case 1:
                 $this->imagen = 'youtube';
                    
                
                
                break;
            case 2:
                 
                break;
            default:
                break;
        }
        return $salida;
    }
    
}