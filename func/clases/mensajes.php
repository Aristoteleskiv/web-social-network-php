<?php


class Mensaje2 {
    //put your code here
    var $id;
    var $idUsuario;
    var $usuario;
    var $mandatario;
    var $fecha;
    var $cuerpo;
    var $imagen;
    var $nivel;
    
    function __construct($mensaje, $nivel) {
        $this->nivel = $nivel;
        $this->id = $mensaje["id"];
        $this->idUsuario = getID($mensaje["mandatario"]);
        $this->usuario = $mensaje["usuario"];
        $this->mandatario = $mensaje["mandatario"];
        $this->fecha = getFechaFormatoClaro($mensaje["fecha"]);
        $this->cuerpo = $mensaje["cuerpo"];
        $this->imagen = getImagenDeUsuario($mensaje["mandatario"]);
    }
    
    
    
    function getHtml(){
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    function getTabla(){
       
        $s = getNiveles($this->nivel);
        
        
        $salida = '
            
            <div class="div-contenedor-estandar" style="min-height: 180px;" id="divMensaje'.$this->id.'">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <div class="div-nombre-usuario" >@'.$this->mandatario.'</div>
                <div style="margin-top: 0px; margin-left: 185px; min-height: 120px; display: inline-block">
                    '.  $this->cuerpo . '
                </div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;" class="fecha-mensaje">'. $this->fecha .'</div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;">
                    <a href="'.$s.'s/mensajes/?u='.$this->idUsuario.'"><div class="div-boton-estandar" style="display: inline;">Responder</div></a>
                    <div class="div-boton-estandar" style="display: inline;"  onclick="javascript:eliminarMensaje(\''.$this->id .'\',\''.$this->nivel.'\');">Eliminar</div>
                </div>
            </div>
            </div>';
        
        return $salida;
        
        
    }

    
    
}
