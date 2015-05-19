<?php


class Mencion2 {
    
    
 
    var $fecha;
    var $usuario;
    var $mencionador;
    var $id;
    var $idPublicacion;
    var $posicion;
    var $imagen;
    var $tituloPublicacion;
    var $comentario;
    var $nivel;
    var $dir;
    function __construct($mencion, $nivel) {
        
        $this->nivel = $nivel;
        $this->id = $mencion["id"];
        $this->idPublicacion = $mencion["id_publicacion"];
        $this->usuario = $mencion["usuario"];
        $this->mencionador = $mencion["mencionador"];
        $this->fecha = getFechaFormatoClaro( $mencion["fecha"]);
        $this->posicion = $mencion["posicion"];
        $this->idUsuario = getID($this->mencionador);
        
        $comentarios = getComentariosPorFecha($this->idPublicacion);
                
        
        $this->tituloPublicacion = getTituloPublicacion($this->idPublicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
        $this->imagen = getImagenDeUsuario($this->mencionador);
        $this->comentario = getComentario($this->mencionador, $this->idPublicacion, $this->posicion);
        $this->comentario = sustituirMenciones($this->idPublicacion, $this->comentario, $this->posicion , $mencion["fecha"]);
        $this->comentario = sustituirCitasNueva($this->comentario, $this->idPublicacion, $this->posicion, $comentarios);
        $this->dir = getDirPublicacion($this->idPublicacion);
        
    }
    
    function getHTML(){
        
        
        $s = getNiveles($this->nivel);
       
        
        $salida = '
            
            <div class="div-contenedor-estandar" style="min-height: 180px;" id="divMencion'.$this->id.'">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <div class="div-nombre-usuario" >@'.$this->mencionador.'</div>
                <div style="margin-top: 0px; margin-left: 185px; min-height: 120px; display: inline-block">
                    <b>Ha sido mencionado por el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->mencionador .'</span><b> en la publicacion '. $this->idPublicacion . '</b>:  '. subirImagenesDeFoolder($this->tituloPublicacion,$this->nivel) . '<br>
                       <div class="div-mostrar-comentario-muro"> '. $this->comentario .' </div>
                </div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;" class="fecha-mensaje">'. $this->fecha .'</div>
                <div style="margin-left: 185px; text-align: center; margin-top: 10px;">
                    <a href="'.$s. 'p/' . $this->dir  .'"><div class="div-boton-estandar" style="display: inline;"  onclick="">Ver</div></a>
                    <div class="div-boton-estandar" style="display: inline;"  onclick="javascript:eliminarMencion(\''.$this->id .'\',\''.$this->nivel.'\');">Eliminar mención</div>
                </div>
            </div>
            </div>';
        
        
        
        
        
        return $salida;
        
    }
    
    
    
    
}


