<?php


function getNumeroDeComentariosDeUsuario($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}

function sustituirCitasNueva($cuerpo, $idPublicacion, $posicionSiguiente, $comentarios){
    
    $citas = array();
    $salida = " " . $cuerpo . " ";
    //preg_match_all('/(?<=\s)(@[^@\s]+)(?=\s)/', 
    //        '<span class="mencion_usuario_no_enlace">$0</span>' ,$menciones);
    
    preg_match_all('/(#\w+)/', $salida ,$citas);
    for($i=0; $i<count($citas[0]); $i++){
        $cita = $citas[0][$i];
        $numero = substr($cita, -(sizeof($cita)-2));
        if($numero<$posicionSiguiente){
        $salida = str_replace($cita . " ", ";';#$" . $numero . ";';#$", $salida );
        }
    }
    
    for($i=0; $i<count($citas[0]); $i++){

            $cita = $citas[0][$i];

            $numero = substr($cita, -(sizeof($cita)-2));
            
        if(comprobarSiCitaExiste($idPublicacion, $numero)){   
            
            $pos = 0;
            for ($j = 0; $j < count($comentarios); $j++) {
                
                if((int)$comentarios[$j]["posicion"]==$numero){
                    $pos = $j;
                    break 1;
                }
            }
            
            $textoMencionado = $comentarios[$pos]["cuerpo"];
            
            $textoMencionado = str_replace("<br>", "", $textoMencionado);
            
            $codigoSpan = '<div class="masterTooltipComentarios" style="display: inline-block;" title="'.$textoMencionado.'"><span class="mencion-hastag-comentario">' . $cita.  '</span></div> ';

            $aReemplazar = $codigoSpan;
            $salida = str_replace(";';#$" . $numero . ";';#$", $aReemplazar, $salida );
        }else{
            $salida = str_replace(";';#$" . $numero . ";';#$", "#" . $numero . " ", $salida );
        }
    }
    
    return $salida;
    
}

function sustituirCitas($cuerpo, $idPublicacion, $posicionSiguiente, $comentarios){
    
    $citas = array();
    $salida = " " . $cuerpo . " ";
    //preg_match_all('/(?<=\s)(@[^@\s]+)(?=\s)/', 
    //        '<span class="mencion_usuario_no_enlace">$0</span>' ,$menciones);
    
    preg_match_all('/(#\w+)/', $salida ,$citas);
    for($i=0; $i<count($citas[0]); $i++){
        $cita = $citas[0][$i];
        $numero = substr($cita, -(sizeof($cita)-2));
        if($numero<$posicionSiguiente){
        $salida = str_replace($cita . " ", ";';#$" . $numero . ";';#$", $salida );
        }
    }
    
    for($i=0; $i<count($citas[0]); $i++){

            $cita = $citas[0][$i];

            $numero = substr($cita, -(sizeof($cita)-2));
            
        if(comprobarSiCitaExiste($idPublicacion, $numero)){   
            
            
            
            $textoMencionado = getComentarioEnPosicion($idPublicacion, $numero);
            
            
            
            $codigoDiv = '<div class="div_mencion" id="divCita'. $posicionSiguiente .'_'. $numero .'">
                    '. $textoMencionado .'
                    </div>';
            $codigoScript = '<script>'
                    . '     $("#spanMencion'. $posicionSiguiente .'_'. $numero .'").hover(function(e) {
                                var divPopup = document.getElementById("divPopUp").getBoundingClientRect();
                                    var top = divPopup.top;
                                    var left = divPopup.left;
                                    $($(this).data("tooltip")).css({
                                        left: e.clientX - left + 10,
                                        top: e.clientY - top + 10
                                        }).stop().show(100);
                                        }, function() {
                                    $($(this).data("tooltip")).hide();
                                });
                            </script>';
            $codigoSpan = '<span data-tooltip="#divCita'. $posicionSiguiente .'_'. $numero .'" id="spanMencion'. $posicionSiguiente .'_'. $numero .'" class="mencion_hastag_comentario">' . $cita.  '</span> ';

            $aReemplazar = $codigoDiv . $codigoScript . $codigoSpan;
            $salida = str_replace(";';#$" . $numero . ";';#$", $aReemplazar, $salida );
        }
    }
    
    return $salida;
    
}


function sustituirCitasMuroNueva($cuerpo, $idPublicacion, $posicionSiguiente, $pagina){
    
    $citas = array();
    $salida = " " . $cuerpo . " ";
    //preg_match_all('/(?<=\s)(@[^@\s]+)(?=\s)/', 
    //        '<span class="mencion_usuario_no_enlace">$0</span>' ,$menciones);
    
    preg_match_all('/(#\w+)/', $salida ,$citas);
    for($i=0; $i<count($citas[0]); $i++){
        $cita = $citas[0][$i];
        $numero = substr($cita, -(sizeof($cita)-2));
        if($numero<$posicionSiguiente){
        $salida = str_replace($cita . " ", ";';#$" . $numero . ";';#$", $salida );
        }
    }
    
    for($i=0; $i<count($citas[0]); $i++){

            $cita = $citas[0][$i];

            $numero = substr($cita, -(sizeof($cita)-2));
            
        if(comprobarSiCitaExiste($idPublicacion, $numero)){   
            
            $textoMencionado = getComentarioEnPosicion($idPublicacion, $numero);

            
            $textoMencionado = str_replace("<br>", "", $textoMencionado);
            
            $codigoSpan = '<div class="masterTooltip'. $pagina .'" style="display: inline-block;" title="'.$textoMencionado.'"><span class="mencion-hastag-comentario">' . $cita.  '</span></div> ';

            $aReemplazar = $codigoSpan;
            $salida = str_replace(";';#$" . $numero . ";';#$", $aReemplazar, $salida );
        }else{
            $salida = str_replace(";';#$" . $numero . ";';#$", "#" . $numero . " ", $salida );
        }
    }
    
    return $salida;
    
}

function sustituirCitasMuro($cuerpo, $idPublicacion, $posicionSiguiente){
    
    $citas = array();
    $salida = " " . $cuerpo . " ";
    //preg_match_all('/(?<=\s)(@[^@\s]+)(?=\s)/', 
    //        '<span class="mencion_usuario_no_enlace">$0</span>' ,$menciones);
    
    preg_match_all('/(#\w+)/', $salida ,$citas);
    for($i=0; $i<count($citas[0]); $i++){
        $cita = $citas[0][$i];
        $numero = substr($cita, -(sizeof($cita)-2));
        if($numero<$posicionSiguiente){
        $salida = str_replace($cita . " ", ";';#$" . $numero . ";';#$", $salida );
        }
    }
    
    for($i=0; $i<count($citas[0]); $i++){

            $cita = $citas[0][$i];

            $numero = substr($cita, -(sizeof($cita)-2));
            
        if(comprobarSiCitaExiste($idPublicacion, $numero)){   
            
            
            
            $textoMencionado = getComentarioEnPosicion($idPublicacion, $numero);
            
            
            
            $codigoDiv = '<div class="div_mencion" id="divCita'. $posicionSiguiente .'_'. $numero .'">
                    '. $textoMencionado .'
                    </div>';
            $codigoScript = '<script>'
                    . '     $("#spanMencion'. $posicionSiguiente .'_'. $numero .'").hover(function(e) {
                                var divContenedorMuro = document.getElementById("divContenedorMuro").getBoundingClientRect();
                                    var top = divContenedorMuro.top;
                                    var left = divContenedorMuro.left;
                                    $($(this).data("tooltip")).css({
                                        left: e.clientX -left   + 10 ,
                                        top: e.clientY -top  + 10
                                        }).stop().show(100);
                                        }, function() {
                                    $($(this).data("tooltip")).hide();
                                });
                            </script>';
            $codigoSpan = '<span data-tooltip="#divCita'. $posicionSiguiente .'_'. $numero .'" id="spanMencion'. $posicionSiguiente .'_'. $numero .'" class="mencion_hastag_comentario">' . $cita.  '</span> ';

            $aReemplazar = $codigoDiv . $codigoScript . $codigoSpan;
            $salida = str_replace(";';#$" . $numero . ";';#$", $aReemplazar, $salida );
        }else{
            $salida = str_replace(";';#$" . $numero . ";';#$", "#" . $numero, $salida );
        }
    }
    
    return $salida;
    
}

function getComentarioEnPosicion($idPublicacion, $posicion){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT cuerpo FROM web.db_comentarios "
            . "WHERE id_publicacion = :id_publicacion AND posicion = :posicion");
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":posicion", $posicion);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);




    $salida = $encontrados["cuerpo"];

    return $salida;
}
function comprobarSiCitaExiste($idPublicacion, $posicionCita){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_comentarios "
            . "WHERE id_publicacion = :id_publicacion "
            . "AND posicion = :posicion AND visible = 1");
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":posicion", $posicionCita);

    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    $salida = false;

    if(count($encontrados)==1){
        $salida = true;
    }
    return $salida;
    
}
function sustituirMenciones($idPublicacion, $cuerpo, $posicionSiguiente, $fecha){
    
    //$mencionador = $_SESSION["usr"];
    
    $menciones = array();
    $salida = " " . $cuerpo . " ";
  
    
    preg_match_all('/(@\w+)/', $salida ,$menciones);
    
    
    for($i=0; $i<count($menciones[0]); $i++){

            $mencion = $menciones[0][$i];
            $usuario = substr($mencion, -(sizeof($mencion)-2));
        if(comprobarSiUsuarioExisteParaMencion($usuario, $fecha) ){   
            
            $aReemplazar = '<span class="mencion-usuario-no-enlace">@' . $usuario.  '</span> ';
            $salida = str_replace($mencion . " ", $aReemplazar, $salida);

        }
    }
    //echo $salida;
    return $salida;
    
}



function enviarMencionesComentario($idPublicacion, $cuerpo, $posicionSiguiente){
    
    $mencionador = $_SESSION["usr"];
    
    $menciones = array();
 
    preg_match_all('/(@\w+)/', $cuerpo ,$menciones);
    
    $yaMencionado = array();
    
    for($i=0; $i<count($menciones[0]); $i++){
            $mencion = $menciones[0][$i];
            $usuario = substr($mencion, -(sizeof($mencion)-2));
        if(comprobarSiUsuarioExisteParaMencion($usuario) AND $mencionador!=$usuario){
            if(!in_array($usuario, $yaMencionado)){
                $yaMencionado[] = $usuario;
                
                enviarMencion($usuario, $mencionador, $idPublicacion, $posicionSiguiente);
                addMencionMuro($usuario, $idPublicacion, $posicionSiguiente, $mencionador);
            }
        }
    }
    

    
}

function comprobarSiUsuarioExisteParaMencion($usuario, $fecha){
    global $pdo;
        
    $date = date_create($fecha);
    
    $dia = $date->format("d");
    $ano = $date->format("Y");
    
    $mes = $date->format("m");
    $seg = $date->format("s");
    $min = $date->format("i");
    $hor = $date->format("H");
    
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
            . "WHERE usuario = :usuario AND activo=1 AND TIMESTAMP(fecha_ingreso) < "
//            . "'$ano-$mes-$dia $hor:$min:$seg'");
            . "'$ano-$mes-$dia $hor:$min:$seg'");
    $consulta->bindParam(":usuario", $usuario);
    //$consulta->bindParam(":fecha", $fecha);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    $salida = false;

    if(count($encontrados)==1){
        $salida = true;
    }
    return $salida;
}
function enviarComentario($usuario, $idPublicacion, $cuerpo, $posicionSiguiente){
    
    global $pdo;

    $consulta = $pdo->prepare("INSERT INTO web.db_comentarios "
            . "(usuario, id_publicacion, fecha, cuerpo, posicion) VALUES "
            . "(:usuario, :id_publicacion,  now(), :cuerpo, :posicion)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":cuerpo", $cuerpo);
    $consulta->bindParam(":posicion", $posicionSiguiente);
    $consulta->execute();
        
        
    
}
function getPosicionSiguienteComentario($idPublicacion){
    
    global $pdo;
        
    
    $consulta = $pdo->prepare("SELECT posicion FROM web.db_comentarios"
            . " WHERE id_publicacion = :id_publicacion ORDER BY fecha DESC");
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    $posicion = $respuesta["posicion"] +1;
    return $posicion;
    
}
function getComentariosPorFecha($id_publicacion){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion AND visible = 1 ORDER BY fecha ASC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();
    return $comentarios;
    
}
function getComentariosPorRelevancia($id_publicacion){
    global $pdo;

    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion AND visible = 1 ORDER BY "
            . "(votos_positivos*1.5 - votos_negativos) DESC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();
    return $comentarios;
    
}
function getComentariosSoloMenciones($id_publicacion, $usuario){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion AND visible = 1 ORDER BY "
            . "fecha ASC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();

    $aEncontrar = "@" . $usuario ;
    $salida = array();
    for($i=0; $i<count($comentarios); $i++){
        $cuerpo = $comentarios[$i]["cuerpo"];
        if(strpos($cuerpo, $aEncontrar)!==false){
            array_push($salida, $comentarios[$i]);
        }

    }


    return $salida;
}

function getComentariosSoloAmigos($id_publicacion, $usuario){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion AND visible = 1 ORDER BY "
            . "fecha ASC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();

    $aEncontrar = "@" . $usuario . "</span>";
    $salida = array();
    for($i=0; $i<count($comentarios); $i++){
        $amigo = $comentarios[$i]["usuario"];

        $sonAmigos = sonAmigosParaFiltroComentarios($usuario, $amigo);

        if($sonAmigos){ 
            array_push($salida, $comentarios[$i]);
        }

    }


    return $salida;
}
function getNumeroDeComentarios($id_publicacion){
    global $pdo;

    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion ORDER BY fecha ASC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();
    return count($comentarios);
}


function getAmigosDeParaFiltroComentarios($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
            . "( usuario= :usuario ) AND ( estado=2 )");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $vector = $consulta->fetchAll();
    $amigos = $vector;
    return $amigos;
}


function sonAmigosParaFiltroComentarios($persona1, $persona2){
    
    $amigosDe1 = getAmigosDeParaFiltroComentarios($persona1);
    $amigosDe2 = getAmigosDeParaFiltroComentarios($persona2);
    
    
    $salida = false;
    for($i=0; $i<count($amigosDe1); $i++){
        if($amigosDe1[$i]["amigo"]==$persona2){
            $salida = true;
        }
    }
    for($i=0; $i<count($amigosDe2); $i++){
        if($amigosDe2[$i]["amigo"]==$persona1){
            $salida = true;
        }
    }
    
    return $salida;
    
    
}


function setTodasMencionesVistas($usuario){
 
    global $pdo;
   
        
    $consulta = $pdo->prepare("UPDATE web.db_menciones SET estado = 1 WHERE "
            . "usuario = :usuario;");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
    

}

function comprobarSiMencionEsDeUsuario($id, $usuario){
    global $pdo;
        
        
        $consulta = $pdo->prepare("SELECT * FROM web.db_menciones WHERE "
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



function eliminarMencion($id, $usuario){
    
        global $pdo;

        $consulta = $pdo->prepare("DELETE FROM web.db_menciones WHERE "
                . "id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
    
}

function enviarMencion($usuario, $mencionador, $idPublicacion, $posicion){
    
        global $pdo;
        
        
        
        
        $consulta = $pdo->prepare("INSERT INTO web.db_menciones "
                . "(usuario, mencionador, id_publicacion, posicion, fecha) VALUES "
                . "(:usuario, :mencionador, :id_publicacion, :posicion, now())");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id_publicacion", $idPublicacion);
        $consulta->bindParam(":mencionador", $mencionador);
        $consulta->bindParam(":posicion", $posicion);
        $consulta->execute();
        
        
        //incrementamos en 1 el valor de menciones absoluto

        $consulta = $pdo->prepare("UPDATE web.db_usuarios "
                . "SET menciones= menciones +1 WHERE usuario= :usuario");
        $consulta->bindParam(":usuario", $usuario);
        
        $consulta->execute();
        
        
}

function getMenciones($usuario){
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_menciones "
            . "WHERE usuario = :usuario AND visible = 1 ORDER BY fecha DESC");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
    
}
function getNumeroMencionesNoVistas($usuario){
    
    $numMencionesNoVistas=0;
    
    
    $menciones = getMenciones($usuario);
   
    for($i=0; $i<count($menciones); $i++){
        if($menciones[$i]["estado"]==0){
            $numMencionesNoVistas++;
        }
    }

    return $numMencionesNoVistas;
}
function getNumeroMenciones($usuario){
    
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_menciones "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
    
}
function getNumeroMencionesHistorico($usuario){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT menciones FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);

    return $encontrados["menciones"];
}