<?php

class PersonaAmigoNoAmigoResumen{
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $nivel;
    function __construct($usuario, $amigo, $nivel) {
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        
    }
    
    function getHTML(){
        if($this->usuario!=null){
            switch ($this->estadoAmistad) {
            case 0:
                $elemento = new PersonaResumen($this->usuario, $this->amigo, $this->nivel);
                return $elemento->getHtml();
                break;
            case 1:
                $elemento = new PendienteAmigoResumen($this->usuario, $this->amigo, $this->nivel);
                return $elemento->getHtml();
                break;
            case 2:
                $elemento = new AmigoResumen2($this->usuario, $this->amigo, $this->nivel);
                return $elemento->getHtml();
                break;
            case 3:
                $elemento = new PersonaResumen($this->usuario, $this->amigo, $this->nivel);
                return $elemento->getHtml();
                break;
            default:
                break;
            }
        }else{
            $elemento = new UsuarioVistoPorNull($this->usuario, $this->amigo, $this->nivel);
            return $elemento->getHtml();
        }
        
    }
    
}


class UsuarioVistoPorNull {
    //put your code here
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    var $nivel;
    var $s;
    
    function __construct($usuario, $amigo, $nivel) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        $this->nivel = $nivel;
        $this->s = getNiveles($nivel);
    }
    

    
    function getHtml(){
        
        $salida = '           
            <div class="div-contenedor-estandar" style="min-height: 180px;">
            <div style="background-image:  url('.$this->s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <a href="'. $this->s .'s/muro/?u='.$this->id.'"><div class="div-nombre-usuario" >@'.$this->amigo.'</div></a>
              </div>
            </div>';
        
        
        return $salida;
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
    var $nivel;
    var $s;
    
    function __construct($usuario, $amigo, $nivel) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        $this->nivel = $nivel;
        $this->s = getNiveles($nivel);
    }
    

    
    function getHtml(){
        
        $salida = '           
            <div class="div-contenedor-estandar" style="min-height: 180px;">
            <div style="background-image:  url('.$this->s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <a href="'. $this->s .'s/muro/?u='.$this->id.'"><div class="div-nombre-usuario" >@'.$this->amigo.'</div></a>
                <div id="divSolcitudAmistad'. $this->id .'" style="text-align: right; padding-right: 30px;">Solicitud enviada!</div>
              </div>
            </div>';
        
        
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
    var $s;
    
    function __construct($usuario, $amigo, $nivel) {
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        $this->nivel = $nivel;
        $this->s = getNiveles($nivel);
    }
    
    
    
    
    
    
    function getHtml(){
        //para un desconocido puede haber 2 opciones. Que sea totalmente desconocido (estado
        //amistad = 0 o NULL, y que hayas rechazado anteriormente su peticion de amistad
        // en cuyo caso estado amistad = 3;
        if($this->estadoAmistad==3){
                
            $idSolicitud = getIDSolicitudAmistad($this->usuario, $this->amigo);
            
            
            
            $salida = '           
            <div class="div-contenedor-estandar" style="min-height: 180px;">
            <div style="background-image:  url('.$this->s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <a href="'. $this->s .'s/muro/?u='.$this->id.'"><div class="div-nombre-usuario" >@'.$this->amigo.'</div></a>
                <div id="divAceptarAmistad'. $idSolicitud .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-estandar" onclick="javascript:aceptarSolicitudAmistad(\''. $idSolicitud .'\', '. $this->nivel .', \''. $this->id .'\' );return false;">Aceptar solicitud de amistad</div></div>
                <div style="margin-left: 195px; min-height: 120px;">Este usuario te ha solicitado amistad con anterioridad pero aun no se ha aceptado</div>
                
                
            </div>
            </div>';
            
        }else{
        
            $salida = '           
            <div class="div-contenedor-estandar" style="min-height: 180px;">
            <div style="background-image:  url('.$this->s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <a href="'. $this->s .'s/muro/?u='.$this->id.'"><div class="div-nombre-usuario" >@'.$this->amigo.'</div></a>
                <div id="divSolcitudAmistad'. $this->id .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-estandar" onclick="javascript:solicitarAmistad(\''. $this->id .'\', '. $this->nivel .');return false;">Solicitar amistad</div></div>
              </div>
            </div>';

        }
        return $salida;
    }
    
}




class AmigoResumen2 {
    
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    var $nivel;
    
    
    function __construct($usuario, $amigo, $nivel) {
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        
        $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->id = getID($amigo);
        $this->muro = getMuroUltimosXDias($amigo, 3);
        
    }
    
    
    function getHtml(){
        
        $s = getNiveles($this->nivel);
        
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
            <div class="div-contenedor-estandar" style="min-height: 180px;">
            <div style="background-image:  url('.$s.'images/imagenes_usuarios/'. $this->imagen . '); background-repeat: no-repeat; width:  100%; min-height: 180px;">
                <a href="'. $s .'s/muro/?u='.$this->id.'"><div class="div-nombre-usuario" >@'.$this->amigo.'</div></a>
                <div style="text-align: right; padding-right: 5px;"><a href="'.$s.'s/mensajes/?u='.$this->id.'"><div class="div-boton-estandar">Enviar mensaje</div></a></div>    
                <a href="'. $s .'s/muro/?u='.$this->id.'"><div style="margin-top: 0px; margin-left: 195px; min-height: 120px; display: inline-block">
                    '.  $resumen . '
                </div></a>
                
                
            </div>
            </div>';
        
        
        return $salida;
    }
    
}



class AmigoMuro2{
    
    
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    var $estadoCuenta;
    var $nivel;
    var $s;
    var $cargarMas;
    var $pagina;
    
    function __construct($usuario, $amigo, $nivel, $pagina) {
        global $numeroResultadosPorPaginaMuro;
        $this->pagina = $pagina;
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->s = getNiveles($nivel);
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
        
        if(count($this->muro)>= $numeroResultadosPorPaginaMuro){
        $this->cargarMas = '<div id="pag2">
                                <div style="text-align: center;">
                                    <div onclick="cargarMasMuro(\'2\',\''. $this->nivel .'\', \''. $this->id .'\')" class="div-boton-estandar">Cargar más</div>
                                </div>
                            </div>';
        }else{
            $this->cargarMas = "";
        }
        
    }
    
    function getHTML(){
        if($this->usuario!=null){
            if($this->estadoCuenta==1){
                if($this->usuario!=$this->amigo){
                    switch ($this->estadoAmistad) {
                        case 0:

                            return $this->getHTML0(); //viendo muro de uusario no amigo
                            break;
                         case 1:

                             return $this->getHTML1(); //viendo muro usuario que aun no ha aceptado
                            break;
                         case 2:
                            return $this->getHTML2(); //viendo muro de amigo

                            break;
                        case 3:
                            return $this->getHTML3();  //viendo muro de uusario a quien aun no has aceptado

                            break;

                        default:
                            break;
                    }
                }else{
                    return $this->getHTML4();  //viendo muro de uno mismo
                }
            }else{
                return $this->getHTMLInactivo(); //viendo muro de un user inactivo
            }
        }else{
            return $this->getHTMLNull(); //viendo muro siendo usr=null
        }
    }
    
    function getHTML4(){
        global $numeroResultadosPorPaginaMuro;
        
//        $verComentarios = getMostrarComentariosMuro($this->amigo);
//        $verEventos = getMostrarEventosMuro($this->amigo);
//        $verMenciones = getMostrarMencionesMuro($this->amigo);
//        $verAmistades = getMostrarAmistadesMuro($this->amigo);
        
        $muroExt = "";
        
        for($i=0; $i<min (count($this->muro), $numeroResultadosPorPaginaMuro); $i++){
            
            $linea = $this->muro[$i];
            $salida = "";
            
            switch ($linea["hecho"]) {
                 
                case "comentario":
                    
                    //if($verComentarios=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $elemento = new ComentarioMuro($this->amigo, $publicacion, $posicion,
                                $this->imagen, $linea["fecha"], $this->nivel, $this->pagina);
                        $salida = $elemento->getHTML();
                    //}
                    
                    break;
                case "amistad":
                    
                    //if($verAmistades=="1"){
                        $amigo = $linea["arg1_varchar"];
                        $elemento = new AmistadMuro($this->amigo, $amigo, 
                                $this->imagen, $linea["fecha"], $this->nivel, $this->pagina);
                        $salida = $elemento->getHTML(); 
                    //}
                    break;
                case "mencion":
                    //if($verMenciones=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $mencionador = $linea["arg1_varchar"];
                        $elemento = new MencionMuro($this->amigo, $publicacion, $posicion, 
                                $mencionador, $linea["fecha"], $this->nivel, $this->pagina); 
                        $salida = $elemento->getHTML();
                    //}
                    break;
                case "evento":
                    //if($verEventos=="1"){
                        $evento = $linea["arg1_varchar"];
                        $salida = $evento;
                    //}
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
        
       
        
        $scriptTextOver = '<script>'. getScriptOverText(1) .'</script>';
        $txtImagenes = "";
        for($i=0; $i<min(count($this->amigos) , $this->numeroResultadosAmigos); $i++){
            $imagen = getImagenDeUsuario($this->amigos[$i]["amigo"]);
            $id = getID($this->amigos[$i]["amigo"]);
            $txtImagenes .= '<a href="index.php?u='. $id .'"><div  style="cursor: pointer; background-color: #fff; display: inline;"><img class="masterTooltip1" title="@'.$this->amigos[$i]["amigo"].'"  style=" height: 50px; width: 50px;"  src="'. $this->s .'images/imagenes_usuarios/'. $imagen .'"></div></a>
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

        
        $salida = $scriptTextOver . '
                <div>
                <h1>@'. $this->amigo .'</h1>  
                <div>
                    <div style="margin-top: 10px; padding-right: 10px;float: left"><img  style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="margin-left: 60px; min-height: 100px;">
                        <div style="display: inline;">
                        <form id="formPrivacidadMuro">
                        <div><h2 style="display: inline-block; margin-right: 10px;">Privacidad </h2><div class="div-boton-estandar" onclick="actualizarPrivacidad('. $this->nivel.'); return false;">Actualizar</div><br>
                            <div style="display: inline-block; width: 200px"><input value="1" id="m" name="m" type="checkbox" '. $checkMenciones .'>Mostrar menciones </div>
                            <div style="display: inline-block; width: 200px"><input value="1" id="m" name="c" type="checkbox" '. $checkComentarios .'>Mostrar comentarios </div>
                            <div style="display: inline-block; width: 200px"><input value="1" id="m" name="a" type="checkbox" '. $checkAmistades .'>Mostrar amistades </div>
                            <div style="display: inline-block; width: 200px"><input value="1" id="m" name="e" type="checkbox" '. $checkEventos .'>Mostrar eventos </div>
                            <div style="" id="divResultadoActualizarPrivacidad"></div>
                        </div>
                         </form>
                        </div>
                    <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 100px">
                        '. $txtAmigos .'
                    </div>
                    </div>
                    <div style="padding-top: 20px;  padding-left: 20px; padding-right: 20px;">
                       '. $muroExt .'
                    </div>
                    '. $this->cargarMas .'
                 </div>
                ';
        
        return $salida;
    }
    
    function getHTML2(){
        global $numeroResultadosPorPaginaMuro;
        $idUsuario = getID($this->amigo);
//        $verComentarios = getMostrarComentariosMuro($this->amigo);
//        $verEventos = getMostrarEventosMuro($this->amigo);
//        $verMenciones = getMostrarMencionesMuro($this->amigo);
//        $verAmistades = getMostrarAmistadesMuro($this->amigo);
        
        $muroExt = "";
        for($i=0; $i<min(count($this->muro), $numeroResultadosPorPaginaMuro); $i++){
            $linea = $this->muro[$i];
            $salida = "";
            
            switch ($linea["hecho"]) {
                case "comentario":
                    //if($verComentarios=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $elemento = new ComentarioMuro($this->amigo, $publicacion, $posicion,
                                                            $this->imagen, $linea["fecha"], $this->nivel, $this->pagina);
                        $salida = $elemento->getHTML();
                    //}
                    
                    break;
                case "amistad":
                    //if($verAmistades=="1"){
                        $amigo = $linea["arg1_varchar"];
                        $elemento = new AmistadMuro($this->amigo, $amigo, $this->imagen, 
                                $linea["fecha"], $this->nivel, $this->pagina);
                        $salida = $elemento->getHTML(); 
                    //}
                    break;
                case "mencion":
                    //if($verMenciones=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $mencionador = $linea["arg1_varchar"];
                        $elemento = new MencionMuro($this->amigo, $publicacion, $posicion, 
                                $mencionador, $linea["fecha"], $this->nivel, $this->pagina); 
                        $salida = $elemento->getHTML();
                    //}
                    break;
                case "evento":
                    //if($verEventos=="1"){
                        $evento = $linea["arg1_varchar"];
                        $salida = $evento;
                    //}
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
        
        
        $txtImagenes = '';
        //
        $scriptTextOver = '<script>'. getScriptOverText(1) .'</script>';
        
        for($i=0; $i<min(count($this->amigos) , $this->numeroResultadosAmigos); $i++){
            $imagen = getImagenDeUsuario($this->amigos[$i]["amigo"]);
            $id = getID($this->amigos[$i]["amigo"]);
            $txtImagenes .= '<a href="index.php?u='. $id .'"><div  style="cursor: pointer; background-color: #fff; display: inline;"><img class="masterTooltip1" title="@'.$this->amigos[$i]["amigo"].'"  style=" height: 50px; width: 50px;"  src="'. $this->s .'images/imagenes_usuarios/'. $imagen .'"></div></a>
                            ';
        }
        if(count($this->amigos)>$this->numeroResultadosAmigos){
            $txtImagenes .= '<div onclick="javascript:verAmigos(\''. $this->id .'\')" style="cursor: pointer; background-color: #fff; display: inline">MAS</div>';
        }
        
        
        
        $txtAmigos = '<div><div style="padding-bottom: 10px;">Amigos</div><div>
                            ' . $txtImagenes . '</div></div>';

        
        $salida = $scriptTextOver . '
                
                <div>
                <h1>@'. $this->amigo .'</h1>  
                <div>
                    <div style="float: right; margin-right: 10px;"><a href="'.$this->s.'s/mensajes/?u='.$idUsuario.'"><div class="div-boton-estandar" style="display: inline;">Enviar mensaje</div></a></div>
                    <div style="margin-top: 10px; padding-right: 10px;float: left"><img  style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                    <div style="margin-left: 60px;">
                    <div style="min-height: 96px;"></div>
                    
                    <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 100px">
                        
                        '. $txtAmigos .'
                    </div>

                    </div>
                    <div style="padding-top: 20px;  padding-left: 20px; padding-right: 20px;">
                       '. $muroExt .'
                    </div>
                    '. $this->cargarMas .'
                 </div>
                ';
        
        return $salida;
    }
    
    function getHTML1(){
        $salida = '
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
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
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    <div id="divAceptarAmistad'. $idSolicitud .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-estandar" onclick="javascript:aceptarSolicitudAmistad(\''. $idSolicitud .'\', '. $this->nivel .', \''. $this->id .'\' );return false;">Aceptar solicitud de amistad</div></div>
                    Este usuario te ha solicitado amistad con anterioridad pero aun no se ha aceptado
                </div>
                </div>
                ';

        return $salida;
    }
    
    
    function getHTML0(){
        $salida = '
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    <div id="divSolcitudAmistad'. $this->id .'" style="text-align: right; padding-right: 30px;"><div class="div-boton-estandar" onclick="javascript:solicitarAmistad(\''. $this->id .'\', '. $this->nivel .');return false;">Solicitar amistad</div></div>
                </div>
                ';
        
        return $salida;
    }
    
    function getHTMLInactivo(){
        $salida = '
            
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    La cuenta de este usuario ha sido deshabilitada.
                

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
    function getHTMLNull(){
        $salida = '
            
                
                <div class="div-contenedor-muro-usuario">
                <h1>@'. $this->amigo .'</h1>  
                <div style="margin-top: 10px; padding-right: 10px; float: left"><img style="height: 180px; width: 180px;" src="'. $this->s .'images/imagenes_usuarios/'. $this->imagen .'"></div>
                <div style="margin-top: 10px; margin-left: 10px; width: 100%; min-height: 180px">
                    Para poder interactuar con el resto de usuarios debes de estar registrado. 
                    <div style="width: 100%; text-align: center;"><a style="color: blue;" href="'.$this->s.'user/registro">Registro</a></div>
                

                </div>
                
                </div>
                ';
        
        return $salida;
    }
    
    
}

 
class AmigoMuroSinCabecera{
    var $usuario;
    var $amigo;
    var $estadoAmistad;
    var $imagen;
    var $muro;
    var $amigos;
    var $numeroResultadosAmigos;
    var $id;
    var $estadoCuenta;
    var $nivel;
    var $s;
    var $cargarMas;
    var $pagina;
    
    function __construct($usuario, $amigo, $nivel, $pagina) {
        global $numeroResultadosPorPaginaMuro;
        $this->pagina = $pagina;
        $this->nivel = $nivel;
        $this->usuario = $usuario;
        $this->amigo = $amigo;
        $this->s = getNiveles($nivel);
        $this->imagen = getImagenDeUsuario($amigo);
        $this->estadoCuenta = getEstadoCuentaUsuario($amigo);
        
        
        if($this->estadoCuenta==1){
        
            $this->estadoAmistad = getEstadoAmistad($usuario, $amigo);

            $this->id = getID($amigo);
            
            $this->muro = getMuro($amigo, (int)$pagina);
  
        }
        
        if(count($this->muro)>= $numeroResultadosPorPaginaMuro){
        $this->cargarMas = '<div id="pag'.(int)($pagina+1) .'">
                                <div style="text-align: center;">
                                    <div onclick="cargarMasMuro(\''. (int)($pagina+1) .'\',\''. $this->nivel .'\', \''. $this->id .'\')" class="div-boton-estandar">Cargar más</div>
                                </div>
                            </div>';
        }else{
            $this->cargarMas = "";
        }
        
    }
    
    function getHTML(){
        if($this->estadoCuenta==1){
            if($this->usuario!=$this->amigo){
                switch ($this->estadoAmistad) {
                    case 0:
                        
                        return "error.";
                        break;
                     case 1:

                         return "error.";
                        break;
                     case 2:
                         //se carga lo mismo sea para uno mismo o para otro usuario
                        return $this->getHTML4();

                        break;
                    case 3:
                        return "error.";

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
        global $numeroResultadosPorPaginaMuro;
//        $verComentarios = getMostrarComentariosMuro($this->amigo);
//        $verEventos = getMostrarEventosMuro($this->amigo);
//        $verMenciones = getMostrarMencionesMuro($this->amigo);
//        $verAmistades = getMostrarAmistadesMuro($this->amigo);
        
        $muroExt = "";
        for($i=0; $i<min(count($this->muro), $numeroResultadosPorPaginaMuro); $i++){
            $linea = $this->muro[$i];
            $salida = "";
            
            switch ($linea["hecho"]) {
                case "comentario":
                    //if($verComentarios=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $elemento = new ComentarioMuro($this->amigo, $publicacion, $posicion,
                                                            $this->imagen, $linea["fecha"], 
                                                            $this->nivel, $this->pagina);
                        $salida = $elemento->getHTML();
                    //}
                    
                    break;
                case "amistad":
                    //if($verAmistades=="1"){
                        $amigo = $linea["arg1_varchar"];
                        $elemento = new AmistadMuro($this->amigo, $amigo, $this->imagen, $linea["fecha"], $this->nivel);
                        $salida = $elemento->getHTML(); 
                    //}
                    break;
                case "mencion":
                    //if($verMenciones=="1"){
                        $publicacion = $linea["arg1_int"];
                        $posicion = $linea["arg2_int"];
                        $mencionador = $linea["arg1_varchar"];
                        $elemento = new MencionMuro($this->amigo, $publicacion, $posicion, $mencionador, 
                                $linea["fecha"], $this->nivel, $this->pagina); 
                        $salida = $elemento->getHTML();
                    //}
                    break;
                case "evento":
                    //if($verEventos=="1"){
                        $evento = $linea["arg1_varchar"];
                        $salida = $evento;
                    //}
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
        
        $scriptTextOver = '<script>'. getScriptOverText($this->pagina) .'</script>';
  
        $salida = $scriptTextOver .'
            <div style="padding-top: 20px;  padding-left: 20px; padding-right: 20px;">
               '. $muroExt .'
            </div>
            '. $this->cargarMas .'
                ';
        
        return $salida;
    }
    
 
    
}

