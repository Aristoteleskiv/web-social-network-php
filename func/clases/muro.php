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
    var $s;
    var $nivel;
    var $pagina;
    
    function __construct($usuario, $publicacion, $posicion,$mencionador, $fecha, $nivel, $pagina) {
        $this->s = getNiveles($nivel);
        $this->nivel = $nivel;
        $this->pagina = $pagina;
        $this->usuario = $usuario;
        $this->publicacion = $publicacion;
        $this->posicion = $posicion;
        $this->idMencionador = getID($mencionador);
        $this->imagen = getImagenDeUsuario($mencionador);;
        $this->mencionador = $mencionador;
        $this->comentario = getComentario($mencionador, $publicacion, $posicion);
        $this->fecha = getFechaFormatoClaro( $fecha);
        $this->comentario = sustituirMenciones($publicacion, $this->comentario, $posicion, $fecha);
        $this->comentario = sustituirCitasMuroNueva($this->comentario, $publicacion, $posicion, $pagina);
        $this->tituloPublicacion = subirImagenesDeFoolder( getTituloPublicacion($publicacion), $nivel);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
    }
    
    
    function getHTML(){
        $id = getID($this->mencionador);
        $salida = '
                <div>
                    <div style=""><img src="'. $this->s .'images/header/mencion.png" class="imagen-izquierda-muro"><b>Ha sido mencionado por el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->mencionador .'</span><b> en la publicacion '. $this->publicacion . '</b>:  '. $this->tituloPublicacion . ' 
                    </div>
                    <a href="index.php?u='. $id .'"><div style="cursor: pointer; float: left;"><img style="height: 50px; width: 50px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div></a>
                    
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
    var $s;
    var $nivel;
    var $pagina;
    
    
    function __construct($usuario, $publicacion, $posicion, $imagen, $fecha, $nivel, $pagina) {
        $this->pagina = $pagina;
        $this->s = getNiveles($nivel);
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->publicacion = $publicacion;
        $this->posicion = $posicion;
        $this->imagen = $imagen;
        $this->comentario = getComentario($usuario, $publicacion, $posicion);
        $this->fecha = getFechaFormatoClaro( $fecha);
        $this->comentario = sustituirMenciones($publicacion, $this->comentario, $posicion, $fecha);
        $this->comentario = sustituirCitasMuroNueva($this->comentario, $publicacion, $posicion, $pagina);
        $this->tituloPublicacion = subirImagenesDeFoolder( getTituloPublicacion($publicacion), $nivel);
        $this->tituloPublicacion = str_replace("<br>", " | ", $this->tituloPublicacion);
    }
    
    
    function getHTML(){
        
        $salida = '
                <div>
                    <div style=""><img  src="'. $this->s .'images/header/menu_editor.png" class="imagen-izquierda-muro"><b>Comentario en la publicacion '. $this->publicacion . '</b>:  '. $this->tituloPublicacion . ' 
                    </div>
                    <div style="float: left;"><img style="height: 50px; width: 50px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                    
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
    var $s;
    var $nivel;
    
    
    function __construct($usuario, $amigo, $imagen, $fecha, $nivel) {
        $this->s = getNiveles($nivel);
        $this->nivel = $nivel;
        
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->imagen2 = getImagenDeUsuario($amigo);
        $this->imagen = $imagen;
        $this->idAmigo = getID($amigo);
        $this->fecha = getFechaFormatoClaro( $fecha);
    }

    function getHTML(){
        
        $salida = '
                <div>
                    <div style=""><img src="'. $this->s .'images/header/amigos.png" class="imagen-izquierda-muro"><b>Nueva amistad con el usuario </b><span class="mencion_usuario_no_enlace">@'. $this->amigo .'</span>
                    </div>
                    <div style="float: left;"><img style=" height: 50px; width: 50px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="display: inline;"><img  style=" padding-left: 10px; padding-right: 10px; height: 25px; width: 25px; padding-bottom: 12px;" src="'. $this->s .'images/header/amistad_usuarios.png"><a href="index.php?u='. $this->idAmigo .'"><img  style="cursor: pointer; height: 50px; width: 50px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen2 .'"></a>
                    </div>
                    <div style="width: 100%; text-align: center;" class="indicadores-publicacion">'. $this->fecha .'</div>
                </div>
                <hr>
                ';
        return $salida;
    }
    
}



