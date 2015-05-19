<?php


function comprobarIDSolicitudAmistadUsuario($id, $usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_notificaciones_solicitud_amistad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    $salida = false;
    if($publicaciones["usuario"]==$usuario){
        $salida = true;
    }
    
    return $salida;
}

function getSolicitanteSolicitudAmistad($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT solicitante FROM web.db_notificaciones_solicitud_amistad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $publicaciones["solicitante"];
}

function getIDSolicitudAmistad($usuario, $amigo){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_solicitud_amistad "
            . "WHERE usuario = :usuario AND solicitante = :solicitante");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":solicitante", $amigo);
    
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $publicaciones["id"];
    
}



function notificacionAceptacionSolicitudAmistad ($usuario, $aceptante){
         
    global $pdo;
        
        
        
    $consulta = $pdo->prepare("INSERT INTO web.db_notificaciones_aceptacion_solicitud_amistad "
            . "(usuario, aceptante,  fecha, estado) VALUES "
            . "(:usuario, :aceptante,  now(), 0)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":aceptante", $aceptante);
    $consulta->execute();
    

}
function getNumeroDeNotificacionesAceptacionSolicitudDeAmistad($usuario){
    
    
    global $pdo;
        
    
    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_aceptacion_solicitud_amistad WHERE "
            . "( usuario = :usuario )");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $amigos = $consulta->fetchAll();
    $numero += count($amigos);

    return $numero;
    
}
function getNotificacionesAceptacionSolicitudDeAmistad($usuario){
    
    global $pdo;

    $consulta = $pdo->prepare("SELECT * FROM web.db_notificaciones_aceptacion_solicitud_amistad WHERE "
            . "( usuario = :usuario )  AND visible = 1");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $amigos = $consulta->fetchAll();
    return $amigos;
    
}
function eliminarNotificacionAceptacionSolicitudDeAmistad($usuario, $id){
    
    
    global $pdo;
        
      
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_aceptacion_solicitud_amistad WHERE "
            . "id = :id AND usuario = :usuario");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->execute();
    
       
    
}
function comprobarSiNotificacionAceptacionSolicitudDeAmistadEsDeUsuario($id, $usuario){
    global $pdo;

    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_aceptacion_solicitud_amistad WHERE "
            . "( usuario = :usuario ) AND (id = :id)");

    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();
     if(count($respuesta)==1){
         return true;
     }else{
         return false;
     }
}



//solcitud de amistad
function getNotificacionesSolicitudDeAmistad($usuario){
    
    
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_notificaciones_solicitud_amistad WHERE "
            . "( usuario = :usuario ) AND visible = 1");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $amigos = $consulta->fetchAll();
    return $amigos;
    
}
function getNumeroDeNotificacionesSolicitudDeAmistad($usuario){
    
    
    global $pdo;
    
    //notificaciones solicitud amistad
    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_solicitud_amistad WHERE "
            . "( usuario = :usuario )");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $amigos = $consulta->fetchAll();
    $numero = count($amigos);

    return $numero;
    
}
function crearReciprocoAceptacionAmistad($usuario, $solicitante){
    global $pdo;
    
    $consulta = $pdo->prepare("INSERT INTO web.db_amigos "
                . "(usuario, amigo,  fecha_aceptado, estado) VALUES "
                . "(:usuario, :amigo,  now(), 2)");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":amigo", $solicitante);
        $consulta->execute();
}


function comprobarSiNotificacionSolicitudDeAmistadEsDeUsuario($id, $usuario){
    global $pdo;

    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_solicitud_amistad WHERE "
            . "( usuario = :usuario ) AND (id = :id)");

    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();
     if(count($respuesta)==1){
         return true;
     }else{
         return false;
     }
}

function setInvisibleNotificacionSolicitudDeAmistad($usuario, $id){
    
    
    global $pdo;
  
    
    $consulta = $pdo->prepare("UPDATE web.db_notificaciones_solicitud_amistad "
             . "SET visible = 0 WHERE "
            . "id = :id AND usuario = :usuario");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->execute();
        
        
    
}

function eliminarNotificacionSolicitudDeAmistad($id){
    
    
    global $pdo;
  
    
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_solicitud_amistad "
             . " WHERE "
            . "id = :id ");
    $consulta->bindParam(":id", $id);
    
    
    $consulta->execute();
        
        
    
}
function aceptarSolicitudAmistad($usuario, $solicitante, $id){
    
    
    global $pdo;
      
    $consulta = $pdo->prepare("SELECT id FROM web.db_amigos WHERE "
            . "( usuario = :usuario ) AND (amigo = :amigo)");

    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":amigo", $solicitante);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    if(count($respuesta)==1){
        
    }else{
       $consulta = $pdo->prepare("UPDATE web.db_amigos SET estado = 2, fecha_aceptado = now() WHERE "
            . "(usuario = :usuario) AND (amigo = :amigo) ");
        $consulta->bindParam(":usuario", $solicitante);
        $consulta->bindParam(":amigo", $usuario);
        $consulta->execute();

        crearReciprocoAceptacionAmistad($usuario, $solicitante);
        
        
    }
    notificacionAceptacionSolicitudAmistad($solicitante, $usuario); 
    eliminarNotificacionSolicitudDeAmistad($id);
    
    

    
       
    
}
function notificacionSolicitudAmistad ($usuario, $solicitante){
         
    global $pdo;
        
        //añadimos la amistad con estado 0
        
        $consulta = $pdo->prepare("INSERT INTO web.db_notificaciones_solicitud_amistad "
                . "(usuario, solicitante,  fecha, estado) VALUES "
                . "(:usuario, :solicitante,  now(), 0)");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":solicitante", $solicitante);
        $consulta->execute();
    

}

function solicitudAmistad($usuario, $amigo){
        global $pdo;
        
        
        
        $consulta = $pdo->prepare("INSERT INTO web.db_amigos "
                . "(usuario, amigo,  fecha_solicitud, estado) VALUES "
                . "(:usuario, :amigo, now(), 1)");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":amigo", $amigo);
        $consulta->execute();
        
       
        
        //enviamos notificacion al otro usuario
        
        notificacionSolicitudAmistad($amigo, $usuario);
    
}


//cuentas con notificaciones
function setTodasNotificacionesVistas($usuario){
    
    
    
    global $pdo;
        
    $consulta = $pdo->prepare("UPDATE web.db_notificaciones_solicitud_amistad SET estado = 1 WHERE "
            . "usuario = :usuario;");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("UPDATE web.db_notificaciones_aceptacion_solicitud_amistad SET estado = 1 WHERE "
            . "usuario = :usuario;");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    $consulta = $pdo->prepare("UPDATE web.db_notificaciones_error_problema SET estado = 1 WHERE "
            . "usuario = :usuario;");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
      
}
function getNumeroNotificaciones($usuario){
    $solicitudAmistad = getNumeroDeNotificacionesSolicitudDeAmistad($usuario);
    $aceptacionSolicitudAmistad = getNumeroDeNotificacionesAceptacionSolicitudDeAmistad($usuario);
    $errores = getNumeroNotificacionesErrorProblema($usuario);
    $suma = $solicitudAmistad+$aceptacionSolicitudAmistad + $errores;
    return $suma;
}
function getNumeroNotificacionesNoVistas($usuario){
    
    $solicitudAmistad=0;
    $aceptacionSolicitudAmistad=0;
    
    $notSolAmistad = getNotificacionesSolicitudDeAmistad($usuario);
    $notAcepSolAmistad = getNotificacionesAceptacionSolicitudDeAmistad($usuario);
    $notErrorProblema = getNotificacionesErrorProblema($usuario);
    for($i=0; $i<count($notSolAmistad); $i++){
        if($notSolAmistad[$i]["estado"]==0){
            $solicitudAmistad++;
        }
    }
    for($i=0; $i<count($notAcepSolAmistad); $i++){
        if($notAcepSolAmistad[$i]["estado"]==0){
            $aceptacionSolicitudAmistad++;
        }
    }
    for($i=0; $i<count($notErrorProblema); $i++){
        if($notErrorProblema[$i]["estado"]==0){
            $solicitudAmistad++;
        }
    }

    $suma = $solicitudAmistad+$aceptacionSolicitudAmistad;
    return $suma;
}


//notificacion error en problema
function getAutorPublicacion_Notificaciones($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT autor FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["autor"];
}
function notificacionErrorProblema ($informante, $idPublicacion, $descripcion){
         
    global $pdo;
        
        //añadimos la amistad con estado 0
        $usuario = getAutorPublicacion_Notificaciones($idPublicacion);
    
        $consulta = $pdo->prepare("INSERT INTO web.db_notificaciones_error_problema "
                . "(usuario, informante, id_publicacion, fecha, estado, descripcion) VALUES "
                . "(:usuario, :informante, :id,  now(), 0, :descripcion)");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":informante", $informante);
        $consulta->bindParam(":id", $idPublicacion);
        $consulta->bindParam(":descripcion", $descripcion);
        $consulta->execute();
    

}
function getNotificacionesErrorProblema($usuario){
    
    
    global $pdo;
        
        
        $consulta = $pdo->prepare("SELECT * FROM web.db_notificaciones_error_problema WHERE "
                . "( usuario = :usuario )");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
        $notificaciones = $consulta->fetchAll();
        return $notificaciones;
    
}
function getNumeroNotificacionesErrorProblema($usuario){
    $not = getNotificacionesErrorProblema($usuario);
    return count($not);
}


function comprobarSiNotificacionErrorProblemaEsDeUsuario($id, $usuario){
    global $pdo;

    $consulta = $pdo->prepare("SELECT id FROM web.db_notificaciones_error_problema WHERE "
            . "( usuario = :usuario ) AND (id = :id)");

    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();
     if(count($respuesta)==1){
         return true;
     }else{
         return false;
     }
}



function eliminarNotificacionErrorProblema($usuario, $id){
    global $pdo;
    $consulta = $pdo->prepare("DELETE FROM web.db_notificaciones_error_problema WHERE "
            . "id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
 
    
}

