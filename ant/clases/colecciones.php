<?php





class ColeccionResumen  {
    var $id;
    var $nombre;
    var $tipoDocumento;
    var $tipoClasificacion;
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
    
    
    function __construct($id, $usuario) {
        
        $this->usuario = $usuario;
        $this->id = $id;
        $this->nombre = getNombreColeccion($id);
        $this->descripcion = getDescripcionColeccion($id);
        $this->autor = getAutorColeccion($id);
        
        $this->visitas = getNumeroVisitasColeccion($id);
        $this->fecha = getFechaCreacionColeccion($id);
        $this->fechaUltimaModificacion = getFechaUltimaModificacionColeccion($id);
        $this->imagen = getImagenColeccion($id);
        
        
    }
    
    
    function getHtml(){
        
        $salida = $this->getTabla();
        //$salida .= $this->getScriptLinkVerPublicacion();
        return $salida;
    }
    
    
    
    
    function getTabla(){
        
        
        
        
        
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
        
        $this->numPublicaciones = getNumeroDePublicacionesEnColeccion($this->id);
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
        
        $salida = '
            
                    <div class="div-contenedor-coleccion-resumen">
                        <script>
                        $("#linkVerColeccion'. $this->id . '").click(function(){
                            
                                $("#divPopUp").bPopup({
                                    follow: [false, false],
                                    loadUrl: "publicacion.php?id='. $primerID . '&c='. $this->id . '&ci=0"
                                });
                        });   
                        $("#linkVerArbolColeccion'. $this->id . '").click(function(){
                            
                               $.ajax({
                                type: "POST",
                                url: "colecciones.php?a='. $this->id . '&a2='. $this->id . '",
                                data: "",
                                success: function(msg){

                                    $("#divCentro").html(msg);


                                }   
                });
                return false; 
                        });   
                        
                        </script>
                        
                        <div style="width: 100%;">
                            <div id="linkVerColeccion'. $this->id . '" style="float: left; " class="div-contenedor-imagen-publicacion"><img src="images/colecciones/'. $this->imagen . '"></div>
                            <div style="width: 100%; min-height: 180px;">
                                <div style="min-height: 124px; max-height:300px; overflow-y:hidden; padding-top: 20px;" ><b>' . $this->nombre . '</b> '. $this->descripcion . '<br>'. $txtTitulos .'</div>
                                
                                <div style="height: 18px; width: 100%; text-align: center;">Última modificación : '. $this->fechaUltimaModificacion . '</div>
                            </div>
                            <div class="div-pie-coleccion" style="color: #000">colección ' . $this->id . ' | '  . $this->numPublicaciones . ' publicaciones | <span id="linkVerArbolColeccion'. $this->id . '" style="cursor: pointer;">'.' niveles</span> | @'. $this->autor . ' | ' . $this->visitas .  ' visitas | fecha creación '. $this->fecha . '</div>

                        </div>
                    </div>

                    ';
        
        
      
        return $salida;
    }
    
    
    
}