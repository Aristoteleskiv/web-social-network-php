<?php

function actualizarPrivacidadMuro2($usuario, $evento, $comentario, $mencion, $amistad){
    global $pdo;

     $consulta = $pdo->prepare("UPDATE web.db_usuarios_preferencias"
            . " SET mostrar_menciones_muro = '$mencion' ,"
            . " mostrar_eventos_muro = '$evento' ,"
            . " mostrar_amistades_muro = '$amistad' ,"
            . " mostrar_comentarios_muro = '$comentario' "
            . " WHERE "
            . "usuario = :usuario");
     $consulta->bindParam(":usuario", $usuario);
     $consulta->execute();
     

}




function getMostrarEventosMuro($usuario){
    global $pdo;
    $consulta = $pdo->prepare("SELECT mostrar_eventos_muro FROM web.db_usuarios_preferencias "
    . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["mostrar_eventos_muro"];
    
}



function getMostrarComentariosMuro($usuario){
    global $pdo;
    $consulta = $pdo->prepare("SELECT mostrar_comentarios_muro FROM web.db_usuarios_preferencias "
    . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["mostrar_comentarios_muro"];
    
}

function getMostrarMencionesMuro($usuario){
    global $pdo;
    $consulta = $pdo->prepare("SELECT mostrar_menciones_muro FROM web.db_usuarios_preferencias "
    . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["mostrar_menciones_muro"];
    
}
function getMostrarAmistadesMuro($usuario){
    global $pdo;
    $consulta = $pdo->prepare("SELECT mostrar_amistades_muro FROM web.db_usuarios_preferencias "
    . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["mostrar_amistades_muro"];
    
}


function getMuro($usuario, $pagina){
    
    //terminar de implementar el muro poniendo las publicaciones realizadas
    
    global $pdo;
    global $numeroResultadosPorPaginaMuro;
    
    
    
    $verComentarios = getMostrarComentariosMuro($usuario);
    $verEventos = getMostrarEventosMuro($usuario);
    $verMenciones = getMostrarMencionesMuro($usuario);
    $verAmistades = getMostrarAmistadesMuro($usuario);

    $inicio = $numeroResultadosPorPaginaMuro*($pagina-1);
    $numres = 1E10;
    
    $msgComentarios = "";
    if(!$verComentarios){
       $msgComentarios = " AND hecho != 'comentario' ";
    }
    $msgEventos = "";
    if(!$verEventos){
       $msgEventos = " AND hecho != 'evento' ";
    }
    $msgMenciones = "";
    if(!$verMenciones){
       $msgMenciones = " AND hecho != 'mencion' ";
    }
    $msgAmistades = "";
    if(!$verAmistades){
       $msgAmistades = " AND hecho != 'amistad' ";
    }
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_muro "
    . "WHERE usuario = :usuario AND visible = 1 AND "
            . "hecho != 'publicacionrealizada' AND hecho != 'cambioimagen' " 
            . $msgComentarios 
            . $msgEventos 
            . $msgMenciones 
            . $msgAmistades 
            . "ORDER BY fecha DESC LIMIT :inicio, :numres");
    
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindValue(":numres", (int)$numres, PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    $consulta->execute();
//    echo $usuario;
    $elementos = $consulta->fetchAll();
    
//    echo $inicio . "<br>";
//    echo count($elementos) . "<br>";
    
    
    //$elementos = $consulta->fetchAll();
    
//    var_dump($elementos);
    $salida = array();
//    $incorporados = 0;
    
    for($i=0; $i< min (count($elementos), $numeroResultadosPorPaginaMuro+1); $i++){
//        if($elementos[$i]["visible"]==1){
//            $salida[] = $elementos[$i];
//            $incorporados++;
//        }
//        if($incorporados >= $numeroResultadosPorPaginaMuro+1){
//            break 1;
//        }
        $salida[] = $elementos[$i];
    }
    
    return $salida;
    
}



function ordenarArrayNumerico ($arrayMultidimensional, $columnaAOrdenar, $inverse = false) {
    $position = array();
    $newRow = array();
    foreach ($arrayMultidimensional as $key => $row) {
            $position[$key]  = $row[$columnaAOrdenar];
            $newRow[$key] = $row;
    }
    if ($inverse) {
        arsort($position);
    }
    else {
        asort($position);
    }
    $returnArray = array();
    foreach ($position as $key => $pos) {     
        $returnArray[] = $newRow[$key];
    }
    return $returnArray;
}


function getMuroUltimosXDias($usuario, $x){
    global $pdo;
    
    
    global $pdo;
    global $minutosParaConsiderarOnline;
    

    $consulta = $pdo->prepare("SELECT hecho FROM web.db_muro "
            . 'WHERE ((YEAR(fecha)= :ano '
            . 'AND MONTH(fecha)= :mes '
            . 'AND :dia - DAY(fecha)<= :x ) AND (usuario = :usuario)) OR '
            . '((YEAR(fecha)= :ano '
            . 'AND MONTH(fecha) + 1 = :mes '
            . 'AND 30 - DAY(fecha) + :dia <= :x ) AND (usuario = :usuario))');
    $y = date('Y');
    $m = date('m');
    $d = date('d');
    $H = date('H');
    $i = date('i');
    
    $consulta->bindParam(":ano", $y);
    $consulta->bindParam(":mes", $m);
    $consulta->bindParam(":dia", $d);
    $consulta->bindParam(":hora", $H);
    $consulta->bindParam(":minuto", $i);
    $consulta->bindParam(":usuario", $usuario);
       
    $consulta->bindParam(":x", $x);
    $consulta->execute();
   
    return $consulta->fetchAll();
    
    
}





function addComentarioMuro($usuario, $publicacion, $posicion){
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_int, arg2_int) VALUES "
    . "(:usuario, now(), 'comentario', :publicacion, :posicion )");
    
        $consulta->bindParam(":publicacion", $publicacion);
        $consulta->bindParam(":posicion", $posicion);
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
        
}

function addAmistadMuro($usuario, $amigo){
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_varchar) VALUES "
    . "(:usuario, now(), 'amistad', :amigo )");
    
        
        $consulta->bindParam(":amigo", $amigo);
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
        
}

function addEventoMuro($usuario, $evento){
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_varchar) VALUES "
    . "(:usuario, now(), 'evento', :evento )");
    
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":evento", $evento);
        $consulta->execute();
        
}

function addMencionMuro($usuario, $publicacion, $posicion, $mencionador){
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_int, arg2_int, arg1_varchar) VALUES "
    . "(:usuario, now(), 'mencion', :publicacion, :posicion, :mencionador )");
    
        $consulta->bindParam(":publicacion", $publicacion);
        $consulta->bindParam(":posicion", $posicion);
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":mencionador", $mencionador);
        $consulta->execute();
        
}


function addCambioImagenMuro($usuario, $imagen){
    global $pdo;
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_tiny_text) VALUES "
    . "(:usuario, now(), 'cambioimagen', :imagen )");
    
        $consulta->bindParam(":imagen", $imagen);
        
        $consulta->bindParam(":usuario", $usuario);
        
        $consulta->execute();
        
}

function deletePublicacionRealizadaMuro($usuario, $publicacion){
    global $pdo;
    
    //eliminamos una anterior si la hubiese
    $consulta = $pdo->prepare("DELETE FROM web.db_muro WHERE "
    . " hecho = 'publicacionrealizada' AND usuario = :usuario AND arg1_int = :publicacion");
    
    $consulta->bindParam(":publicacion", $publicacion);
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
   
        
}



function addPublicacionRealizadaMuro($usuario, $publicacion){
    global $pdo;
    
    
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_muro "
    . "(usuario, fecha, hecho, arg1_int) VALUES "
    . "(:usuario, now(), 'publicacionrealizada', :publicacion )");
    
    $consulta->bindParam(":publicacion", $publicacion);
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
        
}






function getComentario($usuario, $publicacion, $posicion){
    
    global $pdo;
    
    
    $consulta = $pdo->prepare("SELECT cuerpo FROM web.db_comentarios "
    . "WHERE usuario = :usuario AND id_publicacion = :publicacion AND posicion = :posicion");
    
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":publicacion", $publicacion);
    $consulta->bindParam(":posicion", $posicion);
    
    $consulta->execute();
    
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    
    return $salida["cuerpo"];
    
}
