<?php


function eliminarMensaje($usuario, $id){
    
    global $pdo;

    $consulta = $pdo->prepare("DELETE FROM web.db_mensajes WHERE "
            . "id = :id AND usuario = :usuario ");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->execute();
        
       
}

function comprobarSiMensajeEsDeUsuario($id, $usuario){
    global $pdo;
        
        
        $consulta = $pdo->prepare("SELECT * FROM web.db_mensajes WHERE "
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


function getMensajes($usuario){
    
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_mensajes WHERE "
            . "( usuario = :usuario ) ORDER BY fecha DESC");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $mensajes = $consulta->fetchAll();
    return $mensajes;
    
}
function setTodosMensajesVistos($usuario){
    
    
    
    global $pdo;
   
        
    $consulta = $pdo->prepare("UPDATE web.db_mensajes SET estado = 1 WHERE "
            . "usuario = :usuario;");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
    
      
}
function getNumeroMensajes($usuario){
    $mensajes = getMensajes($usuario);
    
    return count($mensajes);
    
}
function getNumeroMensajesNoVistos($usuario){
    
    $numMensajesNoVistos=0;
    
    
    $mensajes = getMensajes($usuario);
   
    for($i=0; $i<count($mensajes); $i++){
        if($mensajes[$i]["estado"]==0){
            $numMensajesNoVistos++;
        }
    }
    

   
    return $numMensajesNoVistos;
}
function enviarMensaje($destinatario, $mandatario, $cuerpo){
    global $pdo;
        
      
        
    $consulta = $pdo->prepare("INSERT INTO web.db_mensajes "
            . "(usuario, mandatario, fecha, cuerpo) VALUES "
            . "(:usuario, :mandatario,  now(), :cuerpo)");
    $consulta->bindParam(":usuario", $destinatario);
    $consulta->bindParam(":mandatario", $mandatario);
    $consulta->bindParam(":cuerpo", $cuerpo);
    $consulta->execute();


        
        
        
}

