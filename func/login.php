<?php

function generarClaveRecuperarPassword($usuario, $email){
    
    global $pdo;
    
    $hash = getHashUnicoRecuperarPasswordUsuario();
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_solicitudes_recuperar_password "
    . "(usuario, fecha, hash) VALUES "
    . "(:usuario, now(), :hash)");
    
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    
    
    $textoMail = getTextoEmailRecuperarPassword($usuario, $hash);
    mail($email, "Recuperar password. Seistemas.com", $textoMail);
    
    
    
    
}


function getHashUnicoRecuperarPasswordUsuario(){
    
    global $pdo;
    
    
    $salida = array("1");
    $contador = 0;
    while(count($salida)>0){
        $hash = cadenaAleatoria();
        
        $consulta = $pdo->prepare("SELECT id FROM web.db_solicitudes_recuperar_password "
                . "WHERE hash = :hash");
        $consulta->bindParam(":hash", $hash);
        $consulta->execute();
        $salida = $consulta->fetchAll();
        $contador++;
        if($contador>1000){
            break;
        }
    }
    return $hash;
    
}

function generarClaveConfirmacionEmail($usuario, $email){
    
    
    global $pdo;
    
    
    
    $hash = cadenaAleatoria();
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_solicitudes_confirmar_correo "
    . "(usuario, fecha, hash) VALUES "
    . "(:usuario, now(), :hash)");
    
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    
    
    $textoMail = getTextoEmailConfirmacionEmail($usuario, $hash);
    mail($email, "Confirmacion de correo Seistemas.com", $textoMail);
    
    
    
    
}



function getDatosHashRecuperarPassword($hash){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_solicitudes_recuperar_password "
            . "WHERE hash = :hash");
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    if($encontrados==false){$encontrados = null;}
    return $encontrados;
    
}


function getDatosHashConfirmacionCorreo($hash){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_solicitudes_confirmar_correo "
            . "WHERE hash = :hash");
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    if($encontrados==false){$encontrados = null;}
    return $encontrados;
    
}


function eliminarSolicitudesRecuperarPassword ($usuario){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_recuperar_password "
       . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);


    $consulta->execute();
}

function eliminarSolicitudesConfirmacionCorreo ($usuario){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_confirmar_correo "
       . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);


    $consulta->execute();
}

function getTextoEmailRecuperarPassword($usuario, $hash){
    
    
    $salida = '
            Estimado usuario.
            
            Nos ponemos en contacto con usted porque ha solicitado un cambio de contraseña en nuestro servicio. A continuacion le mostramos los datos del a cuenta. Si usted no hubiese solicitado este cambio, por favor, no pulse sobre el enlace que se le muestra.
            
            Usuario: '. $usuario .'
            Para reestabecer la contraseña pulse en el siguiente enlace: 
            http://www.seistemas.com/user/recuperar/?h='. $hash . '
            El equipo de http://www.seistemas.com
            
            Reciba un cordial saludo.
 
            ';
    
    return $salida;

}

function getTextoEmailConfirmacionEmail($usuario, $hash){
    global $redirectorConfirmarEmail;
    
    $salida = '
            Estimado usuario.
            
            Nos ponemos en contacto con usted porque ha solicitado un confirmar su cuenta de correo. Si usted no hubiese solicitado nada, por favor ignore este email.
            
            Usuario: '. $usuario .'
            Para confirmar la cuenta de correo por favor pulse el siguiente enlace: 
            http://www.servidor.com/?r='. $redirectorConfirmarEmail . '&h='. $hash . '
                
            El equipo de http://www.servidor.com
            
            Reciba un cordial saludo.
            ';
    
    return $salida;

}


function getIDUnica(){
    
    global $pdo;
    
    $salida = array("1");
    $contador = 0;
    while(count($salida)!=0){
        $id = cadenaAleatoria();
        
        $consulta = $pdo->prepare("SELECT id FROM web.db_usuarios "
            . "WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $salida = $consulta->fetchAll();
        $contador++;
        if($contador>1000){
            break;
        }
    }
    return $id;
    
    
}

function rehabilitarUsuario($usuario, $password){
    global  $pdo;
    

    //le ponemos como inactivo y le cambiamos el password
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET password = :password , activo = 1 "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":password", $password);
    $consulta->execute();
    
    //desactivamos todos sus comentarios. Tambien se desactivarán todas las 
    //mencioens a sus comentarios
    $consulta = $pdo->prepare("UPDATE web.db_comentarios "
            . "SET visible = 1 "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las amistades del resto de usuarios con este
    $consulta = $pdo->prepare("UPDATE web.db_muro "
            . "SET visible = 1 "
            . "WHERE arg1_varchar = :usuario AND hecho = 'amistad'");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todas las menciones del muro que ha hecho
    $consulta = $pdo->prepare("UPDATE web.db_muro "
            . "SET visible = 1 "
            . "WHERE arg1_varchar = :usuario AND hecho = 'mencion'");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las amistades
    $consulta = $pdo->prepare("UPDATE web.db_amigos "
            . "SET activo = 1 "
            . "WHERE usuario = :usuario OR amigo = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //cambiamos la imagen a eliminado
    $consulta = $pdo->prepare("UPDATE web.db_usuarios_preferencias "
            . "SET imagen = '1.jpg' "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
 
    //eliminamos todas las menciones que cualquier otro usuario pudiese tener
    $consulta = $pdo->prepare("UPDATE web.db_menciones "
            . "SET visible = 1 "
            . "WHERE mencionador = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
}

function deshabilitarUsuario($usuario){
    global  $pdo;
    

    $password = getIDUnica();
    $passmd5 = md5($password);
    
    //le ponemos como inactivo y le cambiamos el password
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET password = :password , activo = 0 "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":password", $passmd5);
    $consulta->execute();
    
    //desactivamos todos sus comentarios. Tambien se desactivarán todas las 
    //mencioens a sus comentarios
    $consulta = $pdo->prepare("UPDATE web.db_comentarios "
            . "SET visible = 0 "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las amistades del resto de usuarios con este
    $consulta = $pdo->prepare("UPDATE web.db_muro "
            . "SET visible = 0 "
            . "WHERE arg1_varchar = :usuario AND hecho = 'amistad'");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todas las menciones del muro que ha hecho
    $consulta = $pdo->prepare("UPDATE web.db_muro "
            . "SET visible = 0 "
            . "WHERE arg1_varchar = :usuario AND hecho = 'mencion'");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //desactivamos las amistades
    $consulta = $pdo->prepare("UPDATE web.db_amigos "
            . "SET activo = 0 "
            . "WHERE usuario = :usuario OR amigo = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las amistades no confirmadas
    $consulta = $pdo->prepare("DELETE FROM web.db_amigos "
            . " WHERE ((usuario = :usuario OR amigo = :usuario) AND estado = 1)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //cambiamos la imagen a eliminado
    $consulta = $pdo->prepare("UPDATE web.db_usuarios_preferencias "
            . "SET imagen = 'usuario_eliminado.jpg' "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todo tipo de notificaciones que cualquier otro usuario pudiese tener de él
    
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_solicitud_amistad "
            . " WHERE solicitante = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_error_problema "
            . " WHERE informante = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_aceptacion_solicitud_amistad "
            . " WHERE aceptante = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todas las menciones que cualquier otro usuario pudiese tener
    $consulta = $pdo->prepare("UPDATE web.db_menciones "
            . "SET visible = 0 "
            . "WHERE mencionador = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todos los mensajes que él ha enviado
    $consulta = $pdo->prepare("DELETE FROM web.db_mensajes "
            . " WHERE mandatario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
 
    //eliminamos todos los "realizados" que ha hecho
    $consulta = $pdo->prepare("DELETE FROM web.db_publicaciones_realizadas "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todos los "guardados" que ha hecho
    $consulta = $pdo->prepare("DELETE FROM web.db_guardar_para_mas_tarde "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todas sus respuestas de las encuentas
    $consulta = $pdo->prepare("DELETE FROM web.db_encuestas_usuarios "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();

    
    //eliminamos toda su informacion de lectura de noticias
    $consulta = $pdo->prepare("DELETE FROM web.db_noticias_usuarios "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las solicitudes de confirmar correo
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_confirmar_correo "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos las solicitudes de recuperar password
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_recuperar_password "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //eliminamos todas sus entradas vistas
    $consulta = $pdo->prepare("DELETE FROM web.db_visto "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
}
function eliminacionTotalUsuario($usuario){
    global $pdo;
    
    $consulta = $pdo->prepare("DELETE FROM web.db_votos "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_visto "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_usuarios_preferencias "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //$consulta = $pdo->prepare("DELETE FROM web.db_usuarios "
    //        . " WHERE usuario = :usuario");
    //$consulta->bindParam(":usuario", $usuario);
    //$consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_recuperar_password "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_solicitudes_confirmar_correo "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_seguimiento_usuario "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_seguimiento_ip "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_seguimiento "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_publicaciones_realizadas "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_solicitud_amistad "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_aceptacion_solicitud_amistad "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_noticias_usuarios "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_mensajes "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_menciones "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_guardar_para_mas_tarde "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //$consulta = $pdo->prepare("DELETE FROM web.db_encuestas_usuarios "
    //        . " WHERE usuario = :usuario");
    //$consulta->bindParam(":usuario", $usuario);
    //$consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_cookies_mantener_conectado "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_cookies_aceptar_cookies "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    //$consulta = $pdo->prepare("DELETE FROM web.db_comentarios "
    //        . " WHERE usuario = :usuario");
    //$consulta->bindParam(":usuario", $usuario);
    //$consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_amigos "
            . " WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("DELETE FROM web.db_amigos "
            . " WHERE amigo = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    return "Eliminado correctamente";
}


function registrarNuevoUsuario($nombre, $usuario, $email, $passwordMD5, $anoNacimiento, $sexo){
    
    global $pdo;
    global $numeroImagenesIniciales;
    //base de datos de usuario
    
   
    $idUnica = getIDUnica();
    
    $consulta = $pdo->prepare("INSERT INTO web.db_usuarios "
    . "(id, nombre, usuario, email, password, fecha_ingreso, fecha_ultima_visita, estado, valoracion, numero_visitas, ano_nacimiento, sexo) VALUES "
    . "(:id, :nombre, :usuario, :email, :password, now(), now(), 0, 0, 1, :ano_nacimiento, :sexo)");
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":email", $email);
    $consulta->bindParam(":sexo", $sexo);
    $consulta->bindParam(":password", $passwordMD5);
    $consulta->bindParam(":ano_nacimiento", $anoNacimiento);
    $consulta->bindParam(":id", $idUnica);
    
    $consulta->execute();
    
     
   
    
    //base de datos de preferencias de usuario
    
    $consulta2 = $pdo->prepare("INSERT INTO web.db_usuarios_preferencias "
    . "(usuario, imagen) VALUES "
    . "(:usuario, :imagen)");
    $imagen = mt_rand(1, $numeroImagenesIniciales);
    
    $imagen .= ".jpg";
    $consulta2->bindParam(":usuario", $usuario);
    $consulta2->bindParam(":imagen", $imagen);
    $consulta2->execute();
   
                    
}
function nickPermitido($nick){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_nicks_no_permitidos "
            . "WHERE nick = :nick");
    $consulta->bindParam(":nick", $nick);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
        
    if(count($encontrados)>=1){
        $salida = false;
       
    }else{
        $salida = true;
        
    }
    return $salida;
    
}
function addNickProhibido($nick){
    global $pdo;
        
    $consulta = $pdo->prepare("INSERT INTO web.db_nicks_no_permitidos "
    . "(nick) VALUES "
    . "(:nick)");
    $consulta->bindParam(":nick", $nick);
    $consulta->execute();
    
   
    
}
function getNicksProhibidos(){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_nicks_no_permitidos "
            . "");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
        
    
    return $encontrados;
    
}



function eliminarNickProhibido ($id){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_nicks_no_permitidos "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}

function getNickProhibido($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT nick FROM web.db_nicks_no_permitidos "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
        
    
    return $encontrados["nick"];
    
}

function getEstadoCuentaUsuario($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT activo FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
        
    
    return $encontrados["activo"];
    
}

function validarEmail($email){
    $salida=false;
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
        $salida = false; 
    }else{
        $salida = true;
    }
   if(strlen($email)<8){$salida=false;}
     
   return $salida;
   
}
function validarNombre($name){
    $salida=false;
    if (preg_match("/^[a-zA-Z-]+$/",$name)){
        $salida = false; 
    }else{
        $salida = true;
    }
   if(strlen($name)==0){$salida=false;}
   return $salida;
   
}
function validarNick($nick){
    $salida=false;
    $p = substr($nick, 0,1);
    $u = substr($nick, -1,1);
    
    if (!preg_match("/^[a-zA-Z0-9-_]{4,20}+$/D",$nick)){
        $salida = false; 
    }else{
        if(is_numeric($p) OR $p=="_" OR $p=="-" OR $u=="_" OR $u=="-"){
            $salida = false; 
        }else{
            $salida = true;
        }
       
    }
    if($salida){
        if(!nickPermitido($nick)){
            $salida = false;
        }
    }
    
    
    
   
   return $salida;
   
}
function validarURL($url){
    $salida=false;
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)){
        $salida = false; 
    }else{
        $salida = true;
    }
   
   return $salida;
   
}
function validarPassword($password){
    $salida = false;
    if (preg_match("/^[a-z0-9_-]{6,40}$/i", $password)){
       $salida = true; 
    }else{
       $salida = false;
   }
   return $salida;
    
    
    
}

function comprobarSiUsuarioExiste_Login($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    $salida = false;

    if(count($encontrados)==1){
        $salida = true;
    }
    
    
    return $salida;
}

function comprobarSiUsuarioDeshabilitado($usuario){
    global $pdo;
        
    
        
    $consulta = $pdo->prepare("SELECT activo FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    var_dump($encontrados);
    $salida = false;
    if($encontrados["activo"]==0 ){
        $salida = true;
    }
    return $salida;
}

function comprobarUsuarioMail($usuario, $mail){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    
    $salida = false;
    if($mail == $encontrados["email"] ){
        $salida = true;
    }
    return $salida;
}


function comprobarSiMailExiste_Login($mail){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_usuarios "
            . "WHERE email = :email");
    $consulta->bindParam(":email", $mail);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    $salida = false;

    if(count($encontrados)>=1){
        $salida = true;
    }
    return $salida;
}


function cambiarPassword ($usuario, $password){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET password = :password "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":password", $password);


    $consulta->execute();
  
        
}

function comprobarUsuarioPassword($usr, $pwd){
    
        
        global $pdo;
    
        $consulta = $pdo->prepare("SELECT password FROM web.db_usuarios WHERE"
                . " usuario= :usuario ");
        $consulta->bindParam(":usuario", $usr);
        $consulta->execute();
        $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
        
        $salida = false;
        if( $resultado["password"]==$pwd){
            $salida = true;
        }
        
        
        
        return $salida;
        
        
        
}

function getEmailUsuario($usuario){
    
        
        global $pdo;
    
        $consulta = $pdo->prepare("SELECT email FROM web.db_usuarios WHERE"
                . " usuario= :usuario ");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
        $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
        
        
        return $resultado["email"];
        
        
        
}

function comprobarSiUsuarioConfirmado($usuario){
    //todos los usuarios
    
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
            . "WHERE estado = 1 AND usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    
    if (count($encontrados)>=1){
        return true;
    }else{
        return false;
    }
    
    
    
}