<?php




function getNoticias ($usuario){
    //noticias activas
    
    
    global $pdo;
    
    $salida = array();
    
    if($usuario!=null){
        $consulta = $pdo->prepare("SELECT id, tipo, fecha1, fecha2, usuarios FROM web.db_noticias_admin "
                . "WHERE estado = 1");

        $consulta->execute();
        $encontrados = $consulta->fetchAll();

        $activas = array();
        for($i=0;$i<count($encontrados); $i++){

            switch ($encontrados[$i]["tipo"]) {
                case 2:
                    $fecha1 = $encontrados[$i]["fecha1"];
                    $fecha2 = $encontrados[$i]["fecha2"];
                    $time1 = strtotime($fecha1);
                    $time2 = strtotime($fecha2);

                    $ahora = time();


                    if($ahora>=$time1 AND $ahora < $time2){
                       $activas[] = $encontrados[$i];
                    }

                    break;
                case 3:
                case 4:

                    $consulta = $pdo->prepare("SELECT cerrado FROM web.db_noticias_usuarios "
                    . "WHERE id_noticia = :id AND usuario = :usuario");
                    $consulta->bindParam(":id", $encontrados[$i]["id"]);
                    $consulta->bindParam(":usuario", $usuario);
                    $consulta->execute();
                    $encontrados2 = $consulta->fetch(PDO::FETCH_ASSOC);
                    if($encontrados2["cerrado"]==0){
                        $activas[] = $encontrados[$i];
                    }
                    break;

                default:
                    $activas[] = $encontrados[$i];
                    break;
            }
        }

        //campo usuario de noticias activas

        

        for($i=0; $i<count($activas); $i++){
            if(comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $activas[$i]["usuarios"])){

                //el usuario es objetivo de la noticia
                $salida[] = $activas[$i];

            }
        }
    }
    
    
    return $salida;
    
    
}



function getNoticiasPendientes(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_noticias_admin "
            . "WHERE estado = 0");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}




function getNoticiasAprobadas(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_noticias_admin "
            . "WHERE estado = 1");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}


function getVistasNoticia($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT id FROM web.db_noticias_usuarios "
            . "WHERE id_noticia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}


function getCerradosNoticia($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT id FROM web.db_noticias_usuarios "
            . "WHERE id_noticia = :id AND cerrado=1");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}

function crearNoticia($creador, $titulo){
    
    
    global $pdo;
    
    
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_noticias_admin "
    . "(autor, fecha_creacion, fecha_ultima_modificacion, titulo) VALUES "
    . "(:creador, now(), now(), :titulo)");
    
    $consulta->bindParam(":creador", $creador);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->execute();

    
    
}

function editarTituloNoticia ($id, $titulo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET titulo = :titulo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":titulo", $titulo);


    $consulta->execute();
  
        
}
function editarCuerpoNoticia ($id, $cuerpo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET cuerpo = :cuerpo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":cuerpo", $cuerpo);


    $consulta->execute();
  
        
}

function editarTipoNoticia ($id, $tipo, $dia1, $dia2, $mes1, $mes2, $ano1, $ano2){
    global $pdo;
    
    if($tipo==2){
        $fecha1 = "$ano1-$mes1-$dia1 00:00:00";
        $fecha2 = "$ano2-$mes2-$dia2 00:00:00";
    }else{
        $fecha1 = null;
        $fecha2 = null;
    }
    
    
    
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET tipo = :tipo , "
            . "fecha1 = :fecha1 , "
            . "fecha2 = :fecha2 , "
            . "fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":tipo", $tipo);
    $consulta->bindParam(":fecha1", $fecha1);
    $consulta->bindParam(":fecha2", $fecha2);


    $consulta->execute();
  
        
}

function editarUsuariosNoticia ($id, $usuarios){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET usuarios = :usuarios , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuarios", $usuarios);


    $consulta->execute();
  
        
}


function marcarCerradoNoticia ($id, $usuario){
    
    global $pdo;
        
        if(comprobarSiRegistroDeUsuarioAbiertoEnNoticia($usuario, $id)){
            
            
            $consulta = $pdo->prepare("UPDATE web.db_noticias_usuarios "
            . "SET cerrado = 1 , fecha = now() "
            . "WHERE id_noticia = :id AND usuario = :usuario");
            $consulta->bindParam(":id", $id);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->execute();
            
        }else{
            return "Ha habido un fallo en el sistema";
        }
        
        
        
}

function marcarVistaNoticia($id, $usuario){
    
    global $pdo;
    
    
    if(!comprobarSiRegistroDeUsuarioAbiertoEnNoticia($usuario, $id)){

        $consulta = $pdo->prepare("INSERT INTO web.db_noticias_usuarios "
        . "(usuario, id_noticia, fecha) VALUES "
        . "(:usuario, :id, now())");

        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

    }
    
}


function comprobarSiRegistroDeUsuarioAbiertoEnNoticia($usuario, $id){
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT id FROM web.db_noticias_usuarios "
            . "WHERE id_noticia = :id AND usuario = :usuario");
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


function getTituloNoticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["titulo"];
        
}

function getFecha1Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT fecha1 FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["fecha1"];
        
}
function getDiaFecha1Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT DAY(fecha1) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["DAY(fecha1)"];
        
}
function getDiaFecha2Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT DAY(fecha2) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["DAY(fecha2)"];
        
}
function getMesFecha1Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT MONTH(fecha1) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["MONTH(fecha1)"];
        
}
function getMesFecha2Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT MONTH(fecha2) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["MONTH(fecha2)"];
        
}
function getAnoFecha1Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT YEAR(fecha1) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["YEAR(fecha1)"];
        
}
function getAnoFecha2Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT YEAR(fecha2) FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["YEAR(fecha2)"];
        
}
function getFecha2Noticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT fecha2 FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["fecha2"];
        
}

function getFechaUltimaModificacionNoticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT fecha_ultima_modificacion FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["fecha_ultima_modificacion"];
        
}


function getTipoNoticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT tipo FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["tipo"];
        
}

function getCuerpoNoticia ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT cuerpo FROM web.db_noticias_admin "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["cuerpo"];
        
}

function getCampoUsuariosNoticia ($id){
    global $pdo;
    
    
    $consulta = $pdo->prepare("SELECT usuarios FROM web.db_noticias_admin "
    . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);


    return $respuesta["usuarios"];

    
        
}


function aprobarNoticia ($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET estado = 1 , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}

function desaprobarNoticia ($id){
     global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_noticias_admin "
            . "SET estado = 0 , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
}

function eliminarNoticia ($id){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_noticias_admin "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}
