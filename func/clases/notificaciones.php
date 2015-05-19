<?php




class NotificacionAceptacionSolicitudAmistad2 {
    
    var $tipo;
    var $fecha;
    var $usuario;
    var $aceptante;
    var $id;
    var $imagenAceptante;
    var $nivel;
    
    function __construct($notificacion, $nivel) {
        
        $this->nivel = $nivel;
        $this->id = $notificacion["id"];
        $this->fecha = getFechaFormatoClaro($notificacion["fecha"]);
        $this->usuario = $notificacion["usuario"];
        $this->aceptante = $notificacion["aceptante"];
        $this->estado = $notificacion["estado"];
        $this->tipo = 2; //solicitud amista
        $this->imagenAceptante = getImagenDeUsuario($this->aceptante);
        $this->idUsuario = getID($this->aceptante);
        
    }
    
    function getHTML(){
        
        $s = getNiveles($this->nivel);
        
        
        $salida = '
            
            <div class="div-contenedor-estandar" style="min-height: 180px;" id="divNotificacion'.$this->tipo.'_'.$this->id.'">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagenAceptante . '); background-repeat: no-repeat; width:  100%; float: left; min-height: 180px;">
                <div class="div-nombre-usuario" >@'.$this->aceptante.'</div>
                <div style="margin-top: 0px; margin-left: 185px; min-height: 120px;">
                     <b>Solicitud de amistad. </b> El usuario <span class="mencion_usuario_no_enlace">@'. $this->aceptante .'</span> ha aceptado su solicitud de amistad.
                </div>
                <div style="margin-left: 185px; text-align: center;" class="fecha-mensaje">'. $this->fecha .'</div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;" id="divAceptarAmistad'. $this->id .'">
                    <a href="'.$s.'s/mensajes/?u='.$this->idUsuario.'"><div class="div-boton-estandar" style="display: inline;">Enviar mensaje</div></a>
                    <div class="div-boton-estandar" style="display: inline;"   onclick="javascript:eliminarNotificacion(\''.$this->id .'\',\''.$this->nivel.'\',\''.$this->tipo.'\');">Eliminar notificación</div>
                </div>
            </div>
            </div>
            

                    ';
        
        return $salida;
        
    }
}



class NotificacionSolicitudAmistad2 {
    
    var $tipo;
    var $fecha;
    var $usuario;
    var $solicitante;
    var $id;
    var $estado;
    var $imagenSolicitante;
    var $idUsuario;
    var $nivel;
    
    
    function __construct($notificacion, $nivel ) {
        $this->nivel = $nivel;
        $this->id = $notificacion["id"];;
        $this->fecha = getFechaFormatoClaro($notificacion["fecha"]);
        $this->usuario = $notificacion["usuario"];
        $this->solicitante = $notificacion["solicitante"];
        $this->estado = $notificacion["estado"];
        $this->tipo = 1; //solicitud amista
        $this->imagenSolicitante = getImagenDeUsuario($this->solicitante);
        $this->idUsuario = getID($this->solicitante);
        
    }
    
    function getHTML(){
        
        
        $s = getNiveles($this->nivel);
       
        
        $salida = '
            
            <div class="div-contenedor-estandar" style="min-height: 180px;" id="divNotificacion'.$this->tipo.'_'.$this->id.'">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagenSolicitante . '); background-repeat: no-repeat; width:  100%; float: left; min-height: 180px;">
                <div class="div-nombre-usuario" >@'.$this->solicitante.'</div>
                <div style="margin-top: 0px; margin-left: 185px; min-height: 120px;">
                    <b>Solicitud de amistad. </b>El usuario <span class="mencion_usuario_no_enlace">@'. $this->solicitante .'</span> ha solicitado ser tu amigo.
                </div>
                <div style="margin-left: 185px; text-align: center;" class="fecha-mensaje">'. $this->fecha .'</div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;" id="divAceptarAmistad'. $this->id .'">
                    <div class="div-boton-estandar" style="display: inline;"  onclick="javascript:aceptarSolicitudAmistad(\''.$this->id .'\',\''.$this->nivel.'\',\''.$this->idUsuario.'\');">Aceptar</div>
                    <div class="div-boton-estandar" style="display: inline;"   onclick="javascript:eliminarNotificacion(\''.$this->id .'\',\''.$this->nivel.'\',\''.$this->tipo.'\');">Eliminar notificación</div>
                </div>
            </div>
            </div>
                    ';
        
        
        return $salida;
}
    
    
    
}
    




    
class NotificacionErrorProblema2 {
    
    var $tipo;
    var $fecha;
    var $usuario;
    var $informate;
    var $id;
    
    var $descripcion;
    var $idPublicacion;
    var $imagenInformante;
    var $idUsuario;
    var $tituloPublicacion;
    var $nivel;
    var $dir;
    function __construct($notificacion, $nivel ) {
        
        $this->nivel = $nivel;
     
        
        $this->id = $notificacion["id"];
        $this->fecha = getFechaFormatoClaro( $notificacion["fecha"]);
        $this->usuario = $notificacion["usuario"];
        $this->informate = $notificacion["informante"];
        
        $this->tipo = 3; //errorPoblema
        $this->descripcion = $notificacion["descripcion"];
        $this->idPublicacion = $notificacion["id_publicacion"];
        $this->dir = getDirPublicacion($this->idPublicacion);
        $this->tituloPublicacion = getTituloPublicacion($this->idPublicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
        $this->imagenInformante = getImagenDeUsuario($this->informate);
        $this->idUsuario = getID($this->informate);
        
        
    }
    
    function getHTML(){
        
        
     $s = getNiveles($this->nivel);
       
        $salida = '
            
            <div class="div-contenedor-estandar" style="min-height: 180px;" id="divNotificacion'.$this->tipo.'_'.$this->id.'">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagenInformante . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <div class="div-nombre-usuario" >@'.$this->informate.'</div>
                <div style="margin-top: 0px; margin-left: 185px; min-height: 120px; display: inline-block">
                    <b>Aviso de error</b> en publicacion '. $this->idPublicacion .':  '. subirImagenesDeFoolder($this->tituloPublicacion, $this->nivel)  .' .
                <br><div class="div-mostrar-comentario-muro">'. $this->descripcion .'</div>
                </div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;" class="fecha-mensaje">'. $this->fecha .'</div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;">
                    <a href="'.$s. 'p/' . $this->dir  .'"><div class="div-boton-estandar" style="display: inline;"  onclick="">Ver publicacion</div></a>
                    <div class="div-boton-estandar" style="display: inline;"  onclick="javascript:eliminarNotificacion(\''.$this->id .'\',\''.$this->nivel.'\',\''.$this->tipo.'\');">Eliminar notificación</div>
                </div>
            </div>
            </div>';
      
        
        
        return $salida;
    }
    
}

