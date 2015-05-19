<?php


class MencionMuro{
    
    var $usuario;
    var $publicacion;
    var $posicion;
    var $imagen;
    var $comentario;
    var $mencionador;
    var $fecha;
    var $idMencionador;
    var $tituloPublicacion;
    
    function __construct($usuario, $publicacion, $posicion,$mencionador, $fecha, $pagina) {
        $this->usuario = $usuario;
        $this->publicacion = $publicacion;
        $this->posicion = $posicion;
        $this->idMencionador = getID($mencionador);
        $this->imagen = getImagenDeUsuario($mencionador);;
        $this->mencionador = $mencionador;
        $this->comentario = getComentario($mencionador, $publicacion, $posicion);
        $this->fecha = $fecha;
        $this->comentario = sustituirMenciones($publicacion, $this->comentario, $posicion);
        $this->comentario = sustituirCitasMuro($this->comentario, $publicacion, $posicion);
        $this->tituloPublicacion = getTituloPublicacion($publicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
    }
    
    
    function getHTML(){
        
        $salida = '
                <div>
                    <div style=""><img src="images/header/mencion.png" class="imagen-izquierda-muro"><b>Ha sido mencionado por el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->mencionador .'</span><b> en la publicacion '. $this->publicacion . '</b>:  '. $this->tituloPublicacion . ' 
                    </div>
                    <div onclick="javascript:verAmigo(\''. $this->idMencionador .'\')" style="cursor: pointer; float: left;"><img style="height: 50px; width: 50px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                    
                    <div class="div-mostrar-comentario-muro" style="margin-left: 60px;">
                    '. $this->comentario .'
                    </div>
                    <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                </div>
                <hr>
                ';
        return $salida;
    }
    
}




class ComentarioMuro{
    
    var $usuario;
    var $publicacion;
    var $posicion;
    var $imagen;
    var $comentario;
    var $fecha;
    var $tituloPublicacion;
    
    function __construct($usuario, $publicacion, $posicion, $imagen, $fecha, $pagina) {
        $this->usuario = $usuario;
        $this->publicacion = $publicacion;
        $this->posicion = $posicion;
        $this->imagen = $imagen;
        $this->comentario = getComentario($usuario, $publicacion, $posicion);
        $this->fecha = $fecha;
        $this->comentario = sustituirMenciones($publicacion, $this->comentario, $posicion);
        $this->comentario = sustituirCitasMuro($this->comentario, $publicacion, $posicion);
        $this->tituloPublicacion = getTituloPublicacion($publicacion);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
    }
    
    
    function getHTML(){
        
        $salida = '
                <div>
                    <div style=""><img  src="images/header/menu_editor.png" class="imagen-izquierda-muro"><b>Comentario en la publicacion '. $this->publicacion . '</b>:  '. $this->tituloPublicacion . ' 
                    </div>
                    <div style="float: left;"><img style="height: 50px; width: 50px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                    
                    <div class="div-mostrar-comentario-muro" style="margin-left: 60px;">
                    '. $this->comentario .'
                    </div>
                    <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                </div>
                <hr>
                ';
        return $salida;
    }
    
}


class AmistadMuro{
    
    var $usuario;
    var $amigo;
    
    var $imagen;
    var $imagen2;
    var $idAmigo;
    var $fecha;
    
    
    function __construct($usuario, $amigo, $imagen, $fecha) {
        
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->imagen2 = getImagenDeUsuario($amigo);
        $this->imagen = $imagen;
        $this->idAmigo = getID($amigo);
        $this->fecha = $fecha;
        
        
        
    }
    
    
    function getHTML(){
        
        $salida = '
                <div>
                    <div style=""><img src="images/header/amigos.png" class="imagen-izquierda-muro"><b>Nueva amistad con el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->amigo .'</span>
                    </div>
                    <div style="float: left;"><img style=" height: 50px; width: 50px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="display: inline;"><img  style=" padding-left: 10px; padding-right: 10px; height: 50px; width: 50px;" src="images/header/amistad_usuarios.png"><img onclick="javascript:verAmigo(\''. $this->idAmigo .'\')"  style="cursor: pointer; height: 50px; width: 50px;" src="images/imagenes_usuarios/'. $this->imagen2 .'">
                    
                    <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                </div>
                <hr>
                ';
        return $salida;
    }
    
}



