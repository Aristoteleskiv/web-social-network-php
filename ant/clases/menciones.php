<?php


class Mencion {
    
    
 
    var $fecha;
    var $usuario;
    var $mencionador;
    var $id;
    var $idPublicacion;
    var $posicion;
    var $imagen;
    var $tituloPublicacion;
    var $comentario;
    
    function __construct($id, $idPublicacion, $usuario, $mencionador, $fecha, $posicion) {
        
        $this->id = $id;
        $this->idPublicacion = $idPublicacion;
        $this->idUsuario = getID($mencionador);
        $this->fecha = $fecha;
        $this->usuario = $usuario;
        $this->mencionador = $mencionador;
        $this->posicion = $posicion;
        $this->tituloPublicacion = getTituloPublicacion($idPublicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
        $this->imagen = getImagenDeUsuario($mencionador);
        
        
        $this->comentario = getComentario($mencionador, $idPublicacion, $posicion);
        
        $this->comentario = sustituirMenciones($idPublicacion, $this->comentario, $posicion);
        $this->comentario = sustituirCitasMuro($this->comentario, $idPublicacion, $posicion);
        
        
    }
    
    function getHTML(){
        
        

        
        
        
        
        $salida = '
            <div style="min-height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->idUsuario .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->mencionador .'</span></div>
                </div>
                <div style=" margin-top: 10px; margin-left: 20px;">
                <div style=""><b>Ha sido mencionado por el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->mencionador .'</span><b> en la publicacion '. $this->idPublicacion . '</b>:  '. $this->tituloPublicacion . ' 
                    </div>
                </div>
                <div class="div-mostrar-comentario-muro" style="margin-left: 60px;">
                    '. $this->comentario .'
                    </div>
                
                    <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                    <div style="text-align: center; margin-top: 10px;">
                        <div class="div-boton-enviar-mensaje" style="display: inline;" onclick="javascript:verMencion('. $this->idPublicacion .' , '. $this->posicion .')">Ver mencion</div>
                        <div class="div-boton-enviar-mensaje" style="display: inline;" onclick="javascript:eliminarMencion(\''. $this->id .'\');return false;">Eliminar</div>
                    </div>
                
            </div>
            <br>

                    ';
        
        
        return $salida;
        
    }
    
    
    
    
}


