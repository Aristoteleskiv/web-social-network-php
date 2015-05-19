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
    
    function __construct($id) {
        $this->id = $id;
        
        $this->titulo = getTituloPublicacion($id);
        $this->fecha = getFechaPublicacion($id);
        $this->fechaUltimaModificacion = getFechaUltimaModificacionPublicacion($id);
        $this->autor = getAutorPublicacion($id);
    }
    
    
    
    function getHtml(){
       
        $tipo = getTipoDocumentoPublicacion( $this->id );
        $ttipo = "";
        switch ($tipo) {
            case 1:
                $ttipo = "<b>VIDEO</b> ";
                break;
            case 2:
                $ttipo = "<b>PDF</b> ";
                break;

            default:
                break;
        }

        $salida = '
                <div onclick="javascript:clickResultadoBusquedaPublicacion('. $this->id . ');"  class="div-resultado-busqueda-publicacion-emergente">
    
                        <b>ID:'. $this->id . '</b>. ' . $ttipo . $this->titulo . '
                </div>

                ';
        return $salida;
        
    }
    
        
}


class resultadoBusquedaColeccionEmergente{
    
    var $id;
    
    var $imagen;
    var $titulo;
    var $fecha;
    var $fechaUltimaModificacion;
    var $autor;
    
    function __construct($id) {
        $this->id = $id;
        
        $this->titulo = getNombreColeccion($id);
        $this->fecha = getFechaCreacionColeccion($id);
        $this->fechaUltimaModificacion = getFechaUltimaModificacionColeccion($id);
        $this->autor = getAutorColeccion($id);
    }
    
    
    
    function getHtml(){
       
        

        $salida = '
                <div onclick="javascript:clickResultadoBusquedaColeccion('. $this->id . ');"  class="div-resultado-busqueda-coleccion-emergente">
    
                        <b>ID:'. $this->id . '. Colección: </b>' . $this->titulo . '
                </div>

                ';
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
    
    
    function __construct($usuario, $persona) {
        $this->usuario = $usuario;
        $this->persona = $persona;
        $this->estadoRelacion = getEstadoAmistad($usuario, $persona);
        $this->imagen = getImagenDeUsuario($persona);
        $this->amigos = getNumeroDeAmigos($persona);
        $this->valoracion = getValoracionUsuario($persona);
        $this->comentarios = getNumeroDeComentariosDeUsuario($persona);
        $this->menciones = getNumeroMenciones($persona);
        $this->id = getID($persona);
    }
    
    
    
    function getHtml(){
        $fondo = "";
        if($this->estadoRelacion==2){
            $fondo .= ' style="background-color: #f1fde8;" ';
        }
        
        $salida = '
                <div '. $fondo .' class="div-resultado-busqueda-amigo-emergente" onclick="javascript:verAmigo(\''. $this->id .'\');" >
    
                        <div style="float: left;"><img class="imagen-resultado-busqueda-amigo-emergente" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                        <div style="width: 400px; text-align: center;">
                        
                            <div style="margin-top: 4px; display: inline; "><b>@'. $this->persona .'</b></div>
                            
                            <table align="center" style="padding-top: 20px; font-family: sans-serif; font-size: 12px;">
                                <tr style="text-align: left;"><td><img src="images/header/amigos.png" class="imagen-menus"><span class="numero-cantidad-busqueda-amigos-emergente">'. $this->amigos .'</span> Amigos
                                </td><td><img src="images/header/menu_editor.png" class="imagen-menus"><span class="numero-cantidad-busqueda-amigos-emergente">'. $this->comentarios .'</span> Comentarios
                                </td></tr>
                                <tr style="text-align: left;"><td><img src="images/header/mencion.png" class="imagen-menus"><span class="numero-cantidad-busqueda-amigos-emergente">'. $this->menciones .'</span> Menciones
                                </td><td><img src="images/header/corazon.png" class="imagen-menus"><span class="numero-cantidad-busqueda-amigos-emergente">'. $this->valoracion .'</span> Valoracion
                                </td></tr>
                            </table>
                            
                            
                        </div>
                </div>

                ';
        return $salida;
        
    }
    
    
    
        
}

