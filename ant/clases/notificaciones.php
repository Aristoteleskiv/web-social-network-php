<?php




class NotificacionAceptacionSolicitudAmistad {
    
    var $tipo;
    var $fecha;
    var $usuario;
    var $aceptante;
    var $id;
    var $imagenAceptante;
    
    
    function __construct($id, $usuario, $aceptante, $fecha) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->aceptante = $aceptante;
        $this->tipo = 2; //aceptacion solicitud amistad
        $this->imagenAceptante = getImagenDeUsuario($aceptante);
        $this->idUsuario = getID($aceptante);
        
    }
    
    function getHTML(){
        
        
        
        
        $salida = '
            <div style="min-height: 160px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->idUsuario .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagenAceptante .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->aceptante .'</span></div>
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px;">
                    El usuario <span class="mencion_usuario_no_enlace">@'. $this->aceptante .'</span> ha aceptado su solicitud de amistad.
                </div>
                <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                <div style="text-align: center; margin-top: 10px;">
                    <div class="div-boton-enviar-mensaje" style="display: inline;" onclick="javascript:enviarMensaje(\''. $this->idUsuario .'\');return false;">Enviar mensaje</div>
                    <div class="div-boton-enviar-mensaje" style="display: inline;"  onclick="javascript:eliminarNotificacion(\''. $this->id .'\' , \''. $this->tipo .'\');return false;">Eliminar notificación</div>
                </div>
            </div>
            <br>

                    ';
        
        
        return $salida;
        
    }
}



class NotificacionSolicitudAmistad {
    
    var $tipo;
    var $fecha;
    var $usuario;
    var $solicitante;
    var $id;
    var $estado;
    var $imagenSolicitante;
    var $idUsuario;
    var $nivel;
    
    function __construct($notificacion, $nivel) {
        
        
        $this->nivel = $nivel;
        $this->id = $notificacion["id"];;
        $this->fecha = $notificacion["fecha"];
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
            <div style="min-height: 160px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->idUsuario .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="'.$s.'images/imagenes_usuarios/'. $this->imagenSolicitante .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->solicitante .'</span></div>
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px;">
                    Solicitud de amistad del usuario <span class="mencion_usuario_no_enlace">@'. $this->solicitante .'</span> .
                </div>
                <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                <div style="text-align: center; margin-top: 10px;" id="divAceptarAmistad'. $this->id .'">
                    <div class="div-boton-enviar-mensaje" style="display: inline;"  onclick="javascript:aceptarSolicitud(\''. $this->idUsuario .'\' , \''. $this->id .'\');return false;">Aceptar</div>
                    <div class="div-boton-enviar-mensaje" style="display: inline;"   onclick="javascript:eliminarNotificacion(\''. $this->id .'\' , \''. $this->tipo .'\');return false;">Eliminar notificación</div>
                </div>
            </div>
            <br>

                    ';
        
        
        return $salida;
}
    
    
    
}
    




    
class NotificacionErrorProblema {
    
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
    
    function __construct($id, $idPublicacion, $usuario, $informante, $fecha, $descripcion ) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->informate = $informante;
        
        $this->tipo = 3; //errorPoblema
        $this->descripcion = $descripcion;
        $this->idPublicacion = $idPublicacion;
        
        $this->tituloPublicacion = getTituloPublicacion($idPublicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
        $this->imagenInformante = getImagenDeUsuario($informante);
        $this->idUsuario = getID($informante);
        
    }
    
    function getHTML(){
        
        
     
        
        $salida = '
            <div style="min-height: 160px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->idUsuario .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagenInformante .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->informate .'</span></div>
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px;">
                    <b>Aviso de error</b> en publicacion '. $this->idPublicacion .':  '.$this->tituloPublicacion .' .
                <br>'. $this->descripcion .'
                </div>
                
               
                <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                <div style="text-align: center; margin-top: 10px;" id="divAceptarAmistad'. $this->id .'">
                    <div class="div-boton-enviar-mensaje" style="display: inline;"  onclick="javascript:verPublicacion(\''. $this->idPublicacion .'\');return false;">Ver publicacion</div>
                    <div class="div-boton-enviar-mensaje" style="display: inline;"   onclick="javascript:eliminarNotificacion(\''. $this->id .'\' , \''. $this->tipo .'\');return false;">Eliminar notificación</div>
                </div>
            </div>
            <br>

                    ';
        
        
        return $salida;
    }
    
}

