<?php


function getPlanesPublicidadAprobados(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicidad "
            . "WHERE estado = 1");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}

function getPlanesPublicidadPendientes(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicidad "
            . "WHERE estado = 0");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}

function crearPlanPublicidad($creador, $titulo){
    
    
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_publicidad "
    . "(autor, fecha, fecha_ultima_modificacion, titulo) VALUES "
    . "(:creador, now(), now(), :titulo)");
    
    $consulta->bindParam(":creador", $creador);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->execute();
    
}

function getTituloPlanPublicidad ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_publicidad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["titulo"];
        
}

function getCampoUsuariosPlanPublicidad ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT usuarios FROM web.db_publicidad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["usuarios"];
        
}

function getAccionPlanPublicidad ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT accion FROM web.db_publicidad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["accion"];
        
}

function getModulosPlanPublicidad ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT publicidad FROM web.db_publicidad "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["publicidad"];
        
}

function editarTituloPlanPublicidad ($id, $titulo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET titulo = :titulo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->execute();
  
        
}

function editarCampoUsuariosPlanPublicidad ($id, $usuarios){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET usuarios = :usuarios , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuarios", $usuarios);
    $consulta->execute();
  
        
}

function editarAccionPlanPublicidad ($id, $accion){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET accion = :accion , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":accion", $accion);
    $consulta->execute();
  
        
}

function editarModulosPlanPublicidad ($id, $publicidad){
    global $pdo;
       
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET publicidad = :publicidad , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":publicidad", $publicidad);
    $consulta->execute();
  
        
}


function aprobarPlanPublicidad($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET estado = 1 , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}
function desaprobarPlanPublicidad($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicidad "
            . "SET estado = 0, fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}

function eliminarPlanPublicidad ($id){
    global $pdo;
        
    $consulta = $pdo->prepare("DELETE FROM web.db_publicidad "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}


function getPublicidadUsuario($usuario){
    $salida = array();
    if($usuario==null){
        $salida = array(1,1,1,1,1);
    }else{
        $planes = getPlanesPublicidadAprobados();
        for($i=0; $i<count($planes); $i++){
            $usuarios = $planes[$i]["usuarios"];
            $accion = $planes[$i]["usuarios"];
            $pertenece = comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $usuarios);
            if($pertenece){
                echo "SI";
            }else{
                echo "no";
            }
        }
    }
    
    
}