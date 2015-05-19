<?php




class resultadoBusquedaPersona {
    
    var $imagen;
    var $numAmigos;
    var $numMenciones;
    var $numComentarios;
    var $valoracion;
    var $nombre;
    var $usuario;
    var $amigo;
    var $id;
    var $estadoAmistad;
    var $pdo;
    
    function __construct($usuario, $amigo,  $id) {
        
        
        //el usuario $usuario busca a una persona llamada $amigo que se mostrara
        //en la posicion $i
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->nombre = getNombre($amigo);
        $this->valoracion = (int)getValoracionUsuario($amigo);
        $this->id = $id;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->numAmigos = getNumeroDeAmigos($amigo);
        $this->numMenciones = getNumeroMencionesHistorico_ResultadoBusqueda($amigo);
        $this->numComentarios = getNumeroDeComentariosDeUsuario_ResultadoBusqueda($amigo);
    }
    
    function getHtml(){
        
        
        $scriptSolicitudAmistad = $this->getScriptSolicitudAmistad();
        $tabla = $this->getTabla();
        $salida = $tabla;
       
        
        
        return $salida;
    }
    
    
    function getTabla (){
        $estado = $this->estadoAmistad;
        $salida = "";
        switch ($estado) {
            case 0:  // no se han solcitado nada

                $salida = $this->getTablaNoAmigos();

                break;
            case 1:   //se han enviado la solcitud
                
                $salida .= $this->getTablaSolicitudEnviada();
                
                break;
            case 2:   //ya son amigos
                
                $salida .= $this->getTablaAmigos();
                
                break;

            default:
                break;
        }
        return $salida;
        
        
    }
    
    function getTablaAmigos(){
        
        
        $boton = $this->getBotonEnviarMensaje();
        $salida = $this->getScriptVerPerfil();
        $salida .= '
        <div style="float: left; margin-right: 30px; margin-bottom: 30px;">
                <div>
                    <img border="1" src="images/imagenes_usuarios/' . $this->imagen . '">
                </div>
                <div>
                <div class="div-nombre-usuario"><span class="nombre-usuario">@' . $this->amigo . '</span></div>
                </div>
                '. $boton . '
                <table style="font-family: sans-serif; font-size: 12px; font-weight: bold; color: rgba( 0, 0, 0, 0.53 );">
                <tr><td width="50%">Amigos: '. $this->numAmigos . '</td><td>Comentarios: '. $this->numComentarios . '</td>
                </tr>
                <tr><td>Menciones: '. $this->numMenciones . '</td><td>Valoracion: '. $this->valoracion . '</td>
                </tr>
                </table>
            </div>'
                ;
        

        
        $salida .= $this->getScriptEnviarMensaje();
        
        return $salida;
    }
    function getTablaSolicitudEnviada(){
        
        
        $boton = $this->getBotonAddAmigo();
        $salida = '
            <div style="float: left; margin-right: 30px; margin-bottom: 30px;">
                <div>
                    <img border="1" src="images/imagenes_usuarios/' . $this->imagen . '">
                </div>
                <div>
                <div class="div-nombre-usuario"><span class="nombre-usuario">@' . $this->amigo . '</span></div>
                </div>
                '. "Solicitud enviada!" . '
                <table style="font-family: sans-serif; font-size: 12px; font-weight: bold; color: rgba( 0, 0, 0, 0.53 );">
                <tr><td width="50%">Amigos: '. $this->numAmigos . '</td><td>Comentarios: '. $this->numComentarios . '</td>
                </tr>
                <tr><td>Menciones: '. $this->numMenciones . '</td><td>Valoracion: '. $this->valoracion . '</td>
                </tr>
                </table>
            </div>';
        
        return $salida;
    }
    
    
    
    function getTablaNoAmigos(){
        
        
        $boton = $this->getBotonAddAmigo();
        
        
        $salida='
            
            <div style="float: left; margin-right: 30px; margin-bottom: 30px;">
                <div>
                    <img border="1" src="images/imagenes_usuarios/' . $this->imagen . '">
                </div>
                <div>
                <div class="div-nombre-usuario"><span class="nombre-usuario">@' . $this->amigo . '</span></div>
                </div>
                '. $boton . '
                <table style="font-family: sans-serif; font-size: 12px; font-weight: bold; color: rgba( 0, 0, 0, 0.53 );">
                <tr><td width="50%">Amigos: '. $this->numAmigos . '</td><td>Comentarios: '. $this->numComentarios . '</td>
                </tr>
                <tr><td>Menciones: '. $this->numMenciones . '</td><td>Valoracion: '. $this->valoracion . '</td>
                </tr>
                </table>
            </div>
            
                ';
        
        $scriptSolicitudAmistad = $this->getScriptSolicitudAmistad();
        $salida .= $scriptSolicitudAmistad;
                
        return $salida;
    }
    
    function getScriptSolicitudAmistad(){
        $salida = '<script>
            function solcitudAmistad' . $this->id . '() {

                $.ajax({
                    type: "POST",
                    url: "acciones/solicitud_amistad.php",
                    data: $("#formSolicitudAmistad' . $this->id . '").serialize(),
                    success: function(msg){
                      $("#divSolicitudAmistad' . $this->id . '").html(msg);
                    }
                });
                
            }
        </script>';
        return $salida;
    }
    
    function getScriptEnviarMensaje(){
        $salida = '<script>
            function enviarMensaje' . $this->id . '() {
                
                $.ajax({
                    type: "POST",
                    url: "mensajes.php",
                    data: $("#formEnviarMensaje' . $this->id . '").serialize(),
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
                
            }
        </script>';
        return $salida;
    }
    
    function getScriptVerPerfil(){
        $salida = '<script>
            
            
        $("#linkVerPerfil'. $this->id .'").click(function(){
            
            $.ajax({
                    type: "POST",
                    url: "amigos.php",
                    data: $("#formEnviarMensaje' . $this->id . '").serialize(),
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
        return false; 
        });
        </script>';
       return $salida;
    }
    
    function getBotonAddAmigo(){
        
        $salida = '
            <div style="text-align: center;" id="divSolicitudAmistad' . $this->id . '">
                <form id="formSolicitudAmistad'. $this->id . '">
                
                <input type="hidden" name="amigo" value="'  . $this->amigo . '">
                <input type="submit" value="Añadir a amigos!" onclick="javascript:solcitudAmistad' . $this->id . '(); return false;">
                </form>
            </div>

                         ';
        return $salida;
        
    }
    
    function getBotonEnviarMensaje(){
        
        $salida = '
            
                <form style="text-align: center;" id="formEnviarMensaje'. $this->id . '">
                
                <input type="hidden" name="amigo" value="'  . $this->amigo . '">
                <input type="submit" value="Enviar mensaje" onclick="javascript:enviarMensaje' . $this->id . '(); return false;">
                </form>
           

                         ';
        return $salida;
        
    }
    
    
}





class resultadoBusquedaPublicacionEmergente{
    
    var $id;
    
    var $imagen;
    var $titulo;
    var $fecha;
    var $fechaUltimaModificacion;
    var $autor;
    var $s;
    var $tipo;
    
    var $dir;
    
    function __construct($id, $nivel) {
        $this->id = $id;
        $this->dir = getDirPublicacion($id);
        $this->s = getNiveles($nivel);
        $this->titulo = subirImagenesDeFoolder( getTituloPublicacion($id), $nivel);
        $this->tipo = getTipoDocumentoPublicacion( $this->id );
        if($this->tipo==1){
            $this->imagen = '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/youtube.png">';
        }elseif($this->tipo==2){
            $this->imagen = '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/pdf.png">';
        }
        
    }
    
    
    
    function getHtml(){
        $salida = '
            <a href="'. $this->s . 'p/' . $this->dir . '"><div class="div-resultado-busqueda-publicacion-emergente">
                    <div style=" margin-top: 0px; vertical-align: top; display: inline-block; height: 70px; width: 600px;">
                        <div>'.$this->imagen.'<h2 style="vertical-align: top; display:inline-block">Publicación '. $this->id .'</h2></div>
                        <div>'. $this->titulo .'</div>
                    </div>
            </div></a>';
        return $salida; 

    }
    
        
}


class resultadoBusquedaColeccionEmergente{
    
    var $id;
    var $imagen;
    var $titulo;
    var $enlace;
    var $s;
    var $formato;
    var $dir;
    function __construct($id, $nivel) {
        $this->id = $id;
        $this->s = getNiveles($nivel);
        $this->titulo = subirImagenesDeFoolder(getNombreColeccion($id), $nivel);
        $this->enlace = getDirPublicacion($id);
        $this->formato = getFormatoColeccion($id);
        $this->tipoColeccion = getColeccionColeccion($id);
        if($this->tipoColeccion==1){
            
            //$titulos = getTitulosColeccion($this->id);
            $this->ids = getReferenciasColeccion($this->id);
            $this->ids = explode(" ", $this->ids);
        }elseif($this->tipoColeccion==2){
            
            //$titulos = getTitulosColeccionColeccion($this->id);
            $this->ids = getIDsColeccionColeccion($this->id);
            $this->ids = array_interseccion_colecciones($this->ids, $this->ids);
        }
        $dirPubli = getDirPublicacion($this->ids[0]);
        
        $this->dir = "p/" . $dirPubli . "?c=" . $this->id;;
        
        if($this->formato==1){
            $this->imagen = '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/youtube.png">';
        }elseif($this->formato==2){
            $this->imagen = '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/pdf.png">';

        }elseif($this->formato==3){
            $this->imagen = '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/youtube.png">'
                    . '<img  style="padding-top: 0px; height: 28px; width: 28px;" src="'.$this->s.'images/pdf.png">';
        }
    }
    function getHtml(){
        $salida = '
            <a href="'. $this->s  . $this->dir . '"><div class="div-resultado-busqueda-publicacion-emergente">
                    <div style=" margin-top: 0px; vertical-align: top; display: inline-block; height: 70px; width: 600px;">
                        <div>'.$this->imagen.'<h2 style="vertical-align: top; display:inline-block">Colección '. $this->id .'</h2></div>
                        <div>'. $this->titulo .'</div>
                    </div>
            </div></a>';
        return $salida; 
    }
   
}




class resultadoBusquedaAmigoEmergente{
    
    var $usuario;
    var $persona;
    var $imagen;
    var $estadoRelacion;
    var $amigos;
    var $valoracion;
    var $comentarios;
    var $menciones;
    var $id;
    var $s;
    
    
    function __construct($usuario, $persona, $nivel) {
        $this->usuario = $usuario;
        $this->persona = $persona;
        $this->estadoRelacion = getEstadoAmistad($usuario, $persona);
        $this->imagen = getImagenDeUsuario($persona);
        $this->s = getNiveles($nivel);
        $this->id = getID($persona);
        
        
    }
    
    
    
    function getHtml(){
        $amigos = "";
        if($this->estadoRelacion==2){
            $fecha = getFechaAmistad($this->usuario, $this->persona);
            $amigos .= 'Amigos desde ' . getFechaFormatoClaro($fecha);
        }
        $salida = '
            <a href="'. $this->s .'s/muro/?u='. $this->id .'"><div class="div-resultado-busqueda-amigo-emergente">
                    <div style="display: inline-block; margin: 5px;height: 100px; " >
                        <img style="height: 90px;" src="'.$this->s.'images/imagenes_usuarios/'. $this->imagen .'">
                    </div>
                    <div style=" margin-top: 5px; vertical-align: top; display: inline-block; height: 100px; width: 250px;">
                        <div><h2>@'. $this->persona .'</h2></div>
                        <div>'. $amigos .'</div>
                    </div>
            </div></a>

            ';
        return $salida;
        
    }
    
    
    
        
}

