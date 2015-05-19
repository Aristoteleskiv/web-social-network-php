<?php




function getEncuesta ($usuario){
    //noticias activas
    
    
    global $pdo;
    
    if($usuario != null){
        $consulta = $pdo->prepare("SELECT * FROM web.db_encuestas_admin "
                . "WHERE estado = 1");

        $consulta->execute();
        $encontrados = $consulta->fetchAll();

        $deUsuario = array();
        for($i=0; $i<count($encontrados); $i++){
            if(comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $encontrados[$i]["usuarios"])){
                $deUsuario[] = $encontrados[$i];
            }
        }

        $salida = array();
        for($i=0; $i<count($deUsuario); $i++){

            if(!comprobarSiRegistroDeUsuarioAbiertoEnEncuesta($usuario, $deUsuario[$i]["id"])){
                $salida[] = $deUsuario[$i];
            }else{

                if(!comprobarSiEncuestaVotada($usuario, $deUsuario[$i]["id"])){
                    $salida[] = $deUsuario[$i];
                }
            }
        }
        if(count($salida)>=1){
            return $salida[0];
        }else{
            return null;
        }
    }else{
        return null;
    }
    
    
    
}



function getNumeroDeVotosEncuesta($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT id FROM web.db_encuestas_usuarios "
            . "WHERE id_encuesta = :id AND voto != -1");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}


function getResultadosVotacionEncuesta($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT voto FROM web.db_encuestas_usuarios "
            . "WHERE id_encuesta = :id AND voto != -1");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $votos = $consulta->fetchAll();

    
    $opciones = getOpcionesEncuesta($id);
    $opcionesVector = explode("\n", $opciones);
    $numOpciones = count($opcionesVector);
    $salida = array();
    for($i=0; $i<$numOpciones; $i++){
       
        $salida[]=0;
    }
    for($i=0; $i<$numOpciones; $i++){
        for($j=0; $j<count($votos); $j++){
            if($votos[$j]["voto"]==$i){
                $salida[$i]++;
            }
        }
    }
    
    return $salida;
}



function getEncuestasPendientes(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_encuestas_admin "
            . "WHERE estado = 0");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}




function getEncuestasAprobadas(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_encuestas_admin "
            . "WHERE estado = 1");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}


function getVistasEncuesta($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT id FROM web.db_encuestas_usuarios "
            . "WHERE id_encuesta = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}





function crearEncuesta($creador, $titulo){
    
    
    global $pdo;
    
    
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_encuestas_admin "
    . "(autor, fecha_creacion, fecha_ultima_modificacion, titulo) VALUES "
    . "(:creador, now(), now(), :titulo)");
    
    $consulta->bindParam(":creador", $creador);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->execute();

    
    
}

function editarTituloEncuesta ($id, $titulo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET titulo = :titulo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":titulo", $titulo);


    $consulta->execute();
  
        
}
function editarCuerpoEncuesta ($id, $cuerpo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET cuerpo = :cuerpo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":cuerpo", $cuerpo);


    $consulta->execute();
  
        
}

function editarTipoEncuesta ($id, $tipo){
    global $pdo;
    
    
    
    
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET tipo = :tipo "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":tipo", $tipo);


    $consulta->execute();
  
        
}

function editarOpcionesEncuesta ($id, $opciones){
    global $pdo;
    
    
    
    
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET opciones = :opciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":opciones", $opciones);


    $consulta->execute();
  
        
}

function editarUsuariosEncuesta ($id, $usuarios){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET usuarios = :usuarios , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuarios", $usuarios);


    $consulta->execute();
  
        
}


function marcarVotadaEncuesta ($id, $usuario, $voto){
    
    global $pdo;
        
        if(comprobarSiRegistroDeUsuarioAbiertoEnEncuesta($usuario, $id)){
            
            
            $consulta = $pdo->prepare("UPDATE web.db_encuestas_usuarios "
            . "SET voto = :voto , fecha = now() "
            . "WHERE id_encuesta = :id AND usuario = :usuario");
            $consulta->bindParam(":voto", $voto);
            $consulta->bindParam(":id", $id);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            
            
        }else{
            return "Ha habido un fallo en el sistema";
        }
        
        
        
}

function marcarVistaEncuesta($id, $usuario){
    
    global $pdo;
    
    
    if(!comprobarSiRegistroDeUsuarioAbiertoEnEncuesta($usuario, $id)){
        
        $consulta = $pdo->prepare("INSERT INTO web.db_encuestas_usuarios "
        . "(usuario, id_encuesta, fecha) VALUES "
        . "(:usuario, :id, now())");

        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

    }
    
    
}

function comprobarSiEncuestaVotada($usuario, $id){
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT id FROM web.db_encuestas_usuarios "
            . "WHERE (id_encuesta = :id AND usuario = :usuario AND voto != -1)");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuario", $usuario);

    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    
    
    
    $salida = false;
    if(count($respuesta)>=1){
        $salida = true;
    }
    return $salida;
    
}


function comprobarSiEncuestaExiste($id){
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT id FROM web.db_encuestas_admin "
            . "WHERE (id = :id )");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    
    
    
    $salida = false;
    if(count($respuesta)>=1){
        $salida = true;
    }
    return $salida;
    
}

function comprobarSiRegistroDeUsuarioAbiertoEnEncuesta($usuario, $id){
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT id FROM web.db_encuestas_usuarios "
            . "WHERE id_encuesta = :id AND usuario = :usuario");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuario", $usuario);

    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    
    $salida = false;
    if(count($respuesta)>=1){
        $salida = true;
    }
    
    return $salida;
    
}


function getTituloEncuesta ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_encuestas_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["titulo"];
        
}

function getOpcionesEncuesta ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT opciones FROM web.db_encuestas_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["opciones"];
        
}

function getFechaUltimaModificacionEncuesta ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT fecha_ultima_modificacion FROM web.db_encuestas_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["fecha_ultima_modificacion"];
        
}


function getTipoEncuesta ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT tipo FROM web.db_encuestas_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["tipo"];
        
}

function getCuerpoEncuesta ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT cuerpo FROM web.db_encuestas_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["cuerpo"];
        
}

function getCampoUsuariosEncuesta ($id){
    global $pdo;
    
    
    $consulta = $pdo->prepare("SELECT usuarios FROM web.db_encuestas_admin "
    . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);


    return $respuesta["usuarios"];

    
        
}


function aprobarEncuesta ($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET estado = 1 , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}

function desaprobarEncuesta ($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_encuestas_admin "
            . "SET estado = 0 , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}

function eliminarEncuesta ($id){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_encuestas_admin "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}
