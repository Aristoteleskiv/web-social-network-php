<?php


class Mensaje {
    //put your code here
    var $id;
    var $usuario;
    var $mandatario;
    var $fecha;
    var $cuerpo;
    var $imagen;
    
    function __construct($id, $usuario, $mandatario, $fecha, $cuerpo ) {
        $this->id = $id;
        $this->idUsuario = getID($mandatario);
        $this->usuario = $usuario;
        $this->mandatario = $mandatario;
        $this->fecha = $fecha;
        $this->cuerpo = $cuerpo;
        $this->imagen = getImagenDeUsuario($mandatario);
    }
    
    
    
    function getHtml(){
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    function getTabla(){
       
        
        $salida = '
            <div style="min-height: 160px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->idUsuario .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->mandatario .'</span></div>
                </div>
                <div style="min-height: 130px; margin-top: 10px; margin-left: 20px;">
                '.  $this->cuerpo . '
                </div>
                <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                <div style="text-align: center; margin-top: 10px;">
                    <div class="div-boton-enviar-mensaje" style="display: inline;" onclick="javascript:enviarMensaje(\''. $this->idUsuario .'\');return false;">Contestar</div>
                    <div class="div-boton-enviar-mensaje" style="display: inline;"  onclick="javascript:eliminarMensaje(\''. $this->id .'\');return false;">Eliminar</div>
                </div>
            </div>
            <br>

                    ';
        
        return $salida;
        
        
    }

    
    
}
