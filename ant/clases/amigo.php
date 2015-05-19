<?php

class PersonaAmigoNoAmigoResumen{
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    function __construct($usuario, $amigo) {
        
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        
    }
    
    function getHTML(){
        switch ($this->estadoAmistad) {
            case 0:
                $elemento = new PersonaResumen($this->usuario, $this->amigo);
                return $elemento->getHtml();
                break;
            case 1:
                $elemento = new PendienteAmigoResumen($this->usuario, $this->amigo);
                return $elemento->getHtml();
                break;
            case 2:
                $elemento = new AmigoResumen($this->usuario, $this->amigo);
                return $elemento->getHtml();
                break;
            case 3:
                $elemento = new PersonaResumen($this->usuario, $this->amigo);
                return $elemento->getHtml();
                break;
            default:
                break;
        }
    }
    
}


class PendienteAmigoResumen {
    //put your code here
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    
    
    function __construct($usuario, $amigo) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        
        
    }
    
    
    
    
    
    
    function getHtml(){
        
        
        
        
        
        $salida = '
            
            <div style="overflow: hidden; height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->id .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->amigo .'</span></div>
                </div>
                <div style="text-align: right; padding-right: 30px;">Solicitud enviada!</div>
                <div style="margin-top: 10px; margin-left: 20px;">
                '.'
                </div>
            </div><br>
                ';
        
        
        return $salida;
    }
    
}



class PersonaResumen {
    //put your code here
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    
    
    function __construct($usuario, $amigo) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        
        
    }
    
    
    
    
    
    
    function getHtml(){
        //para un desconocido puede haber 2 opciones. Que sea totalmente desconocido (estado
        //amistad = 0 o NULL, y que hayas rechazado anteriormente su peticion de amistad
        // en cuyo caso estado amistad = 3;
        if($this->estadoAmistad==3){
                
            $idSolicitud = getIDSolicitudAmistad($this->usuario, $this->amigo);
            
            
            $salida = '

                <div style="overflow: hidden; height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                    <div onclick="javascript:verAmigo(\''. $this->id .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                        <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                        <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->amigo .'</span></div>
                    </div>
                    <div id="divAceptarAmistad'. $idSolicitud .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:aceptarSolicitud(\''. $this->id .'\', \''. $idSolicitud .'\');return false;">Aceptar solicitud de amistad</div></div>
                    <div style="margin-top: 10px; margin-left: 20px;">
                    '.'Este usuario te ha solicitado amistad con anterioridad pero aun no se ha aceptado
                    </div>
                </div><br>
                    ';
        }else{
        
        
            $salida = '

                <div style="overflow: hidden; height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                    <div onclick="javascript:verAmigo(\''. $this->id .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                        <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                        <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->amigo .'</span></div>
                    </div>
                    <div id="divSolcitudAmistad'. $this->id .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:solicitarAmistad(\''. $this->id .'\');return false;">Solicitar amistad</div></div>
                    <div style="margin-top: 10px; margin-left: 20px;">
                    '.'
                    </div>
                </div><br>
                    ';

        }
        return $salida;
    }
    
}






class AmigoResumen {
    //put your code here
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    
    
    function __construct($usuario, $amigo) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        $this->muro = getMuroUltimosXDias($amigo, 3);
        
    }
    
    
    
    
    
    
    function getHtml(){
        
        $numAmistades = 0;
        $numMenciones = 0;
        $numComentarios = 0;
        $numEventos = 0;
        
        for($i=0; $i<count($this->muro); $i++){
            $linea = $this->muro[$i];
            
            
            switch ($linea["hecho"]) {
                case "comentario":
                    
                        $numComentarios++;
                    
                    
                    break;
                case "amistad":
                        $numAmistades++;
                    break;
                case "mencion":
                        $numMenciones++;
                    break;
                case "evento":
                        $numEventos++;
                    
                    break;
                case "cambioimagen":
                    
                    break;
                case "publicacionrealizada":
                    
                    break;
                default:
                    break;
            }
           
        }
        
        
        $resumen = '';
        
        if($numAmistades>0){
            $resumen.= '<div><span class="numero-cantidad-menu">'. $numAmistades .'</span> nuevos amigos</div>';
        }
        if($numMenciones>0){
            $resumen.= '<div><span class="numero-cantidad-menu">'. $numMenciones .'</span> nuevas menciones</div>';
        }
        if($numComentarios>0){
            $resumen.= '<div><span class="numero-cantidad-menu">'. $numComentarios .'</span> nuevos comentarios</div>';
        }
        if($numAmistades==0 AND $numMenciones==0 AND $numComentarios==0){
            $resumen.= '<div>No ha habido actividad del usuario en las ultimas 48 horas</div>';
        }
        
        
        
        
        
        
        $salida = '
            
            <div style="overflow: hidden; height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <div onclick="javascript:verAmigo(\''. $this->id .'\');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@'. $this->amigo .'</span></div>
                </div>
                <div style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:enviarMensaje(\''. $this->id .'\');return false;">Enviar mensaje</div></div>
                <div style="margin-top: 10px; margin-left: 20px;">
                '. $resumen .'
                </div>
            </div><br>
                ';
        
        
        return $salida;
    }
    
}



class AmigoMuro{
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    var $estadoCuenta;
    
    function __construct($usuario, $amigo) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->imagen = getImagenDeUsuario($amigo);
        $this->estadoCuenta = getEstadoCuentaUsuario($amigo);
        
        if($this->estadoCuenta==1){
        
            $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);

            $this->id = getID($amigo);
            $this->muro = getMuro($amigo, 1);
            
            $amigosTodos = getAmigosDe($amigo);



            $amigos = array();
            $this->numeroResultadosAmigos = min(4, count($amigosTodos));
            $inicio = rand(0, count($amigosTodos) - 1 - $this->numeroResultadosAmigos);
            for($i= $inicio; $i<$inicio + $this->numeroResultadosAmigos; $i++){
                $amigos[] = $amigosTodos[$i];
            }
            if(count($amigosTodos)>$this->numeroResultadosAmigos){
                $amigos[] = "0";
            }
            $this->amigos = $amigos;
        }
        
    }
    
    
    
    
    
    function getHTML(){
        if($this->estadoCuenta==1){
            if($this->usuario!=$this->amigo){
                switch ($this->estadoAmistad) {
                    case 0:

                        return $this->getHTML0();
                        break;
                     case 1:

                         return $this->getHTML1();
                        break;
                     case 2:
                        return $this->getHTML2();

                        break;
                    case 3:
                        return $this->getHTML3();

                        break;

                    default:
                        break;
                }
            }else{
                return $this->getHTML4();
            }
        }else{
            return $this->getHTMLInactivo();
        }
        
        
    }
    
    function getHTML4(){
        
        $verComentarios = getMostrarComentariosMuro($this->amigo);
        $verEventos = getMostrarEventosMuro($this->amigo);
        $verMenciones = getMostrarMencionesMuro($this->amigo);
        $verAmistades = getMostrarAmistadesMuro($this->amigo);
        
        $muroExt = "";
        for($i=0; $i<count($this->muro); $i++){
            $linea = $this->muro[$i];
            $salida = "";
            
            switch ($linea["hecho"]) {
                case "comentario":
                    if($verComentarios=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $elemento = new ComentarioMuro($this->amigo, $publicacion, $posicion,
                                                            $this->imagen, $linea["fecha"]);
                        $salida = $elemento->getHTML();
                    }
                    
                    break;
                case "amistad":
                    if($verAmistades=="1"){
                        $amigo = $linea["arg1_varchar"];
                        $elemento = new AmistadMuro($this->amigo, $amigo, $this->imagen, $linea["fecha"]);
                        $salida = $elemento->getHTML(); 
                    }
                    break;
                case "mencion":
                    if($verMenciones=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $mencionador = $linea["arg1_varchar"];
                        $elemento = new MencionMuro($this->amigo, $publicacion, $posicion, $mencionador, $linea["fecha"]); 
                        $salida = $elemento->getHTML();
                    }
                    break;
                case "evento":
                    if($verEventos=="1"){
                        $evento = $linea["arg1_varchar"];
                        $salida = $evento;
                    }
                    break;
                case "cambioimagen":
                    $imagen = $linea["arg1_tiny_text"];
                    //$salida = "Ha cambiado la imagen por $imagen";
                    break;
                case "publicacionrealizada":
                    $publicacion = $linea["arg1_int"];
                    //$salida = "Ha marcado la publicacion $publicacion realizada";
                    break;
                default:
                    break;
            }
            $muroExt .= $salida ;
        }
        
        
        $txtImagenes = '<script>
                        
                            function actualizarPrivacidad() {

                                $.ajax({
                                    type: "GET",
                                    url: "acciones/actualizar_privacidad_muro.php",
                                    data: $("#privacidadMuro").serialize(),
                                    success: function(msg){
                                      
                                      $("#divResultadoActualizarPrivacidad").html(msg);
                                      
                                    }
                                    
                                });

                            }
                        
                            
                            </script>';
        //
        
        
        for($i=0; $i<min(count($this->amigos) , $this->numeroResultadosAmigos); $i++){
            $imagen = getImagenDeUsuario($this->amigos[$i]["amigo"]);
            $id = getID($this->amigos[$i]["amigo"]);
            $txtImagenes .= '<div onclick="javascript:verAmigo(\''. $id .'\')" style="cursor: pointer; background-color: #fff; display: inline"><img class="imagen-amigo-muro-emergente" src="images/imagenes_usuarios/'. $imagen .'"></div>
                            
                            ';
        }
        if(count($this->amigos)>$this->numeroResultadosAmigos){
            $txtImagenes .= '<div onclick="javascript:verAmigos(\''. $this->id .'\')" style="cursor: pointer; background-color: #fff; display: inline">MAS</div>';
        }
        
        
        
        $txtAmigos = '<div><div style="padding-bottom: 10px;">Amigos</div><div>
                            ' . $txtImagenes . '</div></div>';
        
        $checkEventos = getMostrarEventosMuro($this->usuario);
        if($checkEventos=="1"){
            $checkEventos = "checked";
        }else{
            $checkEventos = "";
        }
        $checkComentarios = getMostrarComentariosMuro($this->usuario);
        if($checkComentarios=="1"){
            $checkComentarios = "checked";
        }else{
            $checkComentarios = "";
        }
        $checkMenciones = getMostrarMencionesMuro($this->usuario);
        
        if($checkMenciones=="1"){
            $checkMenciones = "checked";
        }else{
            $checkMenciones = "";
        }
        $checkAmistades = getMostrarAmistadesMuro($this->usuario);
        if($checkAmistades=="1"){
            $checkAmistades = "checked";
        }else{
            $checkAmistades = "";
        }
        
       
        
        $salida = '
                
                <div class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <h1>@'. $this->amigo .'</h1>  
                <div>
                    <div style="margin-top: 10px; padding-right: 10px;float: left"><img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="margin-left: 60px;">
                        <div style="display: inline;">
                        <form id="privacidadMuro">
                                Mostrar menciones <input value="1" id="m" name="m" type="checkbox" '. $checkMenciones .'><br>
                                Mostrar comentarios <input value="1" id="c" name="c" type="checkbox" '. $checkComentarios .'><br>
                                Mostrar nuevas amistades <input value="1" id="a" name="a" type="checkbox" '. $checkAmistades .'><br>
                                Mostrar eventos <input value="1" id="e" name="e" type="checkbox" '. $checkEventos .'><br>
                                <input style="display: inline;" type="button" value="Actualizar" onclick="actualizarPrivacidad(); return false;">
                                <div style="display: inline;" id="divResultadoActualizarPrivacidad"></div>
                         </form>
                        </div>
                        
                    <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                        
                        '. $txtAmigos .'
                        

                    </div>

                    </div>
                 
                    <div style="padding-top: 20px;  padding-left: 20px; padding-right: 20px;">
                       '. $muroExt .'
                    </div>
                 </div>
                ';
        
        return $salida;
    }
    
    function getHTML2(){
        
        
        $verComentarios = getMostrarComentariosMuro($this->amigo);
        $verEventos = getMostrarEventosMuro($this->amigo);
        $verMenciones = getMostrarMencionesMuro($this->amigo);
        $verAmistades = getMostrarAmistadesMuro($this->amigo);
        
        
        $muroExt = "";
        for($i=0; $i<count($this->muro); $i++){
            $linea = $this->muro[$i];
            $salida = "";
            switch ($linea["hecho"]) {
                case "comentario":
                    if($verComentarios=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $elemento = new ComentarioMuro($this->amigo, $publicacion, $posicion,
                                                            $this->imagen, $linea["fecha"]);
                        $salida = $elemento->getHTML();
                    }
                    
                    break;
                case "amistad":
                    if($verAmistades=="1"){
                        $amigo = $linea["arg1_varchar"];
                        $elemento = new AmistadMuro($this->amigo, $amigo, $this->imagen, $linea["fecha"]);
                        $salida = $elemento->getHTML();
                    }
                    break;
                case "mencion":
                    if($verMenciones=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $mencionador = $linea["arg1_varchar"];
                        $elemento = new MencionMuro($this->amigo, $publicacion, $posicion, $mencionador, $linea["fecha"]); 
                        $salida = $elemento->getHTML();
                    }
                    break;
                case "evento":
                    if($verEventos=="1"){
                        $evento = $linea["arg1_varchar"];
                        $salida = $evento;
                    }
                    break;
                case "cambioimagen":
                    $imagen = $linea["arg1_tiny_text"];
                    //$salida = "Ha cambiado la imagen por $imagen";
                    break;
                case "publicacionrealizada":
                    $publicacion = $linea["arg1_int"];
                    //$salida = "Ha marcado la publicacion $publicacion realizada";
                    break;
                default:
                    break;
            }
            $muroExt .= $salida . "";
        }
        
        
        $txtImagenes = '';
        for($i=0; $i<min(count($this->amigos) , $this->numeroResultadosAmigos); $i++){
            $imagen = getImagenDeUsuario($this->amigos[$i]["amigo"]);
            $id = getID($this->amigos[$i]["amigo"]);
            $txtImagenes .= '<div onclick="javascript:verAmigo(\''. $id .'\')" style="cursor: pointer; background-color: #fff; display: inline"><img class="imagen-amigo-muro-emergente" src="images/imagenes_usuarios/'. $imagen .'"></div>
                            
                            ';
        }
        if(count($this->amigos)>$this->numeroResultadosAmigos){
            $txtImagenes .= '<div onclick="javascript:verAmigos(\''. $this->id .'\')" style="cursor: pointer; background-color: #fff; display: inline">MAS</div>';
        }
        
        
        
        $txtAmigos = '<div><div style="padding-bottom: 10px;">Amigos</div><div>
                            ' . $txtImagenes . '</div></div>';
        
        
        
        $salida = '
                
                <div class="div-contenedor-muro-usuario" id="divContenedorMuro">
                <h1>@'. $this->amigo .'</h1>  
                <div>
                    <div style="margin-top: 10px; padding-right: 10px;float: left"><img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                        <div style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:enviarMensaje(\''. $this->id .'\');return false;">Enviar mensaje</div></div>
                        '. $txtAmigos .'
                        

                    </div>

                    </div>
                 
                    <div style="padding-top: 20px;  padding-left: 20px; padding-right: 20px;">
                       '. $muroExt .'
                    </div>
                 </div>
                ';
        
        return $salida;
    }
    
    function getHTML1(){
        $salida = '
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    <div style="text-align: right; padding-right: 30px;">Solicitud enviada!</div>
                

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
    function getHTML3(){
        
       
        $idSolicitud = getIDSolicitudAmistad($this->usuario, $this->amigo);
        $salida = '
            
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    <div id="divAceptarAmistad'. $idSolicitud .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:aceptarSolicitud(\''. $this->id .'\', \''. $idSolicitud .'\');return false;">Aceptar solicitud de amistad</div></div>
                    Este usuario te ha solicitado amistad con anterioridad pero aun no se ha aceptado

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
    
    function getHTML0(){
        $salida = '
            
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    <div id="divSolcitudAmistad'. $this->id .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-enviar-mensaje" onclick="javascript:solicitarAmistad(\''. $this->id .'\');return false;">Solicitar amistad</div></div>
                

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
     function getHTMLInactivo(){
        $salida = '
            
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    La cuenta de este usuario ha sido deshabilitada.
                

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
    
    
}