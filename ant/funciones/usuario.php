<?php

function getHashUnicoImagenUsuario(){
    
    global $pdo;
    
    
    $salida = array("1");
    $contador = 0;
    a: while(count($salida)>0){
        $hash = cadenaAleatoria();
        
        $consulta = $pdo->prepare("SELECT id FROM web.db_imagenes_usuarios "
                . "WHERE hash = :hash");
        $consulta->bindParam(":hash", $hash);
        $consulta->execute();
        $salida = $consulta->fetchAll();
        $contador++;
        if($contador>1000){
            break a;
        }
    }
    return $hash;
    
}



function actualizarAceptacionTerminosYCondiciones($usuario){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET fecha_aceptacion_terminos = now() "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);

    $consulta->execute();
}


function getNumeroDeComentariosDeUsuario_ResultadoBusqueda($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_comentarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return count($encontrados);
}
function getNumeroMencionesHistorico_ResultadoBusqueda($usuario){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT menciones FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);

    return $encontrados["menciones"];
}


function busquedaPersonas($usuario, $persona, $pagina){
        global $pdo;
        global $numeroResultadosPorPagina;
        global $arrayAmigos;
        $inicio = $numeroResultadosPorPagina*($pagina-1);
        $final = $numeroResultadosPorPagina+1;
        
        if(strlen($persona)>2){
            
            
            
            $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
                    . "( usuario = :usuario ) AND (amigo LIKE :persona) AND (activo=1)"
                    . "");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);


            $consulta->execute();

            $amigos = $consulta->fetchAll();
            $arrayAmigos = $amigos;
            
            

            



            $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios WHERE"
                    . " (usuario LIKE :persona) AND (usuario <> :usuario)  AND (activo=1)"
                    . "  LIMIT :inicio, :numres");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);
            $consulta->bindValue(":numres", (int)$final, PDO::PARAM_INT);
            $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
            $consulta->execute();
            $noamigos = $consulta->fetchAll();
            //echo "<br>-----<br>";
            //var_dump($noamigos);
            //echo "<br>-----<br>";

            $salida = array();

            
            if($pagina == 1){
                for($i=0; $i<count($amigos); $i++){
                    $linea = array();
                    $linea["amigo"] =$amigos[$i]["amigo"];
                    $salida[] = $linea;

                }
            }

            for($i=0; $i<count($noamigos); $i++){

                if(!in_array_2d($noamigos[$i]["usuario"], $arrayAmigos)){
                   
                        $linea = array();
                        $linea["amigo"] =$noamigos[$i]["usuario"];
                        $salida[] = $linea;
                    
                }
            }


            
            //var_dump($salida);
            //echo "<br>-----<br>";
            return $salida;
        }else{
            return null;
        }
}

$globalUltimaBusqueda = "" ;
$globalArrayUltimaBusqueda = Array();

function busquedaPersonasSoloNoAmigos($usuario, $persona, $pagina, $arrayAmigos = null){
        global $pdo;
        global $numeroResultadosPorPagina;
        
        global $globalArrayUltimaBusqueda;
        global $globalUltimaBusqueda;
        
        
            if(strlen($persona)>2){


                if($arrayAmigos==null){
                    $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
                            . "( usuario = :usuario ) AND (amigo LIKE :persona)  AND (activo=1)"
                            . "");
                    $consulta->bindParam(":usuario", $usuario);
                    $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);


                    $consulta->execute();

                    $amigos = $consulta->fetchAll();
                    $arrayAmigos = $amigos;
                }

                //var_dump($arrayAmigos);





                $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios WHERE"
                        . " (usuario LIKE :persona) AND (usuario <> :usuario)  AND (activo=1) "
                        . " ");
                        //. "  LIMIT :inicio, :numres");
                $consulta->bindParam(":usuario", $usuario);
                $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);
                //$consulta->bindValue(":numres", (int)$final, PDO::PARAM_INT);
                //$consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
                $consulta->execute();
                $noamigos = $consulta->fetchAll();
                //var_dump($noamigos);

                //echo $pretty($noamigos);
                //echo "-----<br>";


                $numMetidos = 0;
                a: for($i=0; $i<count($noamigos); $i++){

                    if(!in_array_2d($noamigos[$i]["usuario"], $arrayAmigos)){
                            $numMetidos++;
                            $linea = array();
                            $linea["amigo"] =$noamigos[$i]["usuario"];
                            $salida[] = $linea;

                    }

                }

                $inicio = $numeroResultadosPorPagina*($pagina-1);
                $salida2 = array();
                for($i=$inicio; $i<min($inicio + $numeroResultadosPorPagina+1 , count($salida) ); $i++){
                    $salida2[] = $salida[$i];
                }

                $globalUltimaBusqueda = $persona;
                $globalArrayUltimaBusqueda = $salida;

                return $salida2;
            
        }else{
            return null;
        }
}

function busquedaPersonasSoloAmigos($usuario, $persona){
        global $pdo;
        
        
        if(strlen($persona)>2){
            
            
            
            $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
                    . "( usuario = :usuario ) AND (amigo LIKE :persona) AND (estado = 2 )  AND (activo=1)"
                    . "");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);


            $consulta->execute();

            $amigos = $consulta->fetchAll();
            $arrayAmigos = $amigos;
            
            
            $salida = array();

            
            
            for($i=0; $i<count($amigos); $i++){
                $linea = array();
                $linea["amigo"] =$amigos[$i]["amigo"];
                $salida[] = $linea;

            }
            

            return $salida;
        }else{
            return null;
        }
}





function busquedaPersonasSoloPendientes($usuario, $persona){
        global $pdo;
        
        
        if(strlen($persona)>2){
            
            
            
            $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
                    . "( usuario = :usuario ) AND (amigo LIKE :persona) AND (estado = 1 ) AND (activo=1)"
                    . "");
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindValue(":persona","%$persona%", PDO::PARAM_STR);


            $consulta->execute();

            $amigos = $consulta->fetchAll();
            $arrayAmigos = $amigos;
            
            
            $salida = array();

            
            
            for($i=0; $i<count($amigos); $i++){
                $linea = array();
                $linea["amigo"] =$amigos[$i]["amigo"];
                $salida[] = $linea;

            }
            

            return $salida;
        }else{
            return null;
        }
}



function in_array_2d($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_2d($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function getNickMencionado($nick){
    return '<span class="mencion_usuario_no_enlace">@' . $nick . '</span>';
}

function comprobarSiUsuarioExiste($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
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

function getNivelUsuario($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT nivel_usuario FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);

    return $encontrados["nivel_usuario"];
}

function getFechaIngreso($usuario){
     global $pdo;
        
    $consulta = $pdo->prepare("SELECT fecha_ingreso FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);

    return $encontrados["fecha_ingreso"];
}

function getFechaUltimaVisita($usuario){
     global $pdo;
        
    $consulta = $pdo->prepare("SELECT fecha_ultima_visita FROM web.db_usuarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);

    return $encontrados["fecha_ultima_visita"];
}



function getAmigosDe($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT amigo FROM web.db_amigos WHERE "
            . "( usuario= :usuario ) AND ( estado=2 )  AND (activo=1)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $vector = $consulta->fetchAll();
    $amigos = $vector;
    
    return $amigos;
}



function getEstadoAmistad($usuario, $amigo){
    // estado = 0 no se han solicitado amistad
    // estado = 1 se han solciitado amistad
    // estado = 2 se han aceptado
    // estado = 3 el amigo ha solicitado pero usuario borro solcitud
    
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT estado FROM web.db_amigos WHERE"
            . " (usuario= :usuario ) AND ( amigo= :amigo)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":amigo", $amigo);
    $consulta->execute();
    $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
    $salida = $resultado["estado"];
    if($resultado["estado"] == null){
        $consulta = $pdo->prepare("SELECT estado FROM web.db_amigos WHERE"
            . " (amigo= :usuario ) AND ( usuario= :amigo)");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":amigo", $amigo);
        $consulta->execute();
        $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
        
        if($resultado["estado"]==1){
            $salida = 3;
        }else{
            $salida = 0;
        }
    }
    
    return $salida;
       
}
function getNombre($usuario){
    //devuelve nick, valoracion, imagen, numero de amigos
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT nombre FROM web.db_usuarios WHERE"
            . " usuario= :usuario ");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
    return $resultado["nombre"];
       
}
function getID($usuario){
    
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT id FROM web.db_usuarios WHERE"
            . " usuario= :usuario ");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $resultado = $consulta->fetch(pdo::FETCH_ASSOC);
    return $resultado["id"];
       
}
function getNombreUsuario($id){
    
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios WHERE"
            . " id = :id ");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
    return $resultado["usuario"];
       
}
function getImagenDeUsuario ($usuario){
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT imagen FROM web.db_usuarios_preferencias WHERE usuario= :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $linea = $consulta->fetch(PDO::FETCH_ASSOC);
    $urlImagen = $linea["imagen"];
    return $urlImagen;
    
}
function getNumeroDeAmigos ($usuario){
    
    global $pdo;

    $consulta = $pdo->prepare("SELECT * FROM web.db_amigos WHERE "
            . "(usuario= :usuario) AND (estado = 2)");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();

    return count($respuesta);
}




function sonAmigos($persona1, $persona2){
    
    $amigosDe1 = getAmigosDe($persona1);
    $amigosDe2 = getAmigosDe($persona2);
    
    
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


function getValoracionUsuario($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_comentarios "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    $votosPos = 0;
    $votosNeg = 0;

    for($i=0; $i<count($encontrados);$i++){
        $votosPos += $encontrados[$i]["votos_positivos"];
        $votosNeg += $encontrados[$i]["votos_negativos"];
    }

    $balance = 1.5*$votosPos - $votosNeg;
    if($balance==0){
        $valoracion = 0;
    }else{
        if($balance>0){
            $x = $balance;
            $valoracion =  (int)(100 * pow($x, 1000))/(pow($x, 1000)+1000*pow($x, 999));
        }else{
            $x = -$balance;
            $valoracion =  -(int)(100 * pow($x, 1000))/(pow($x, 1000)+1000*pow($x, 999));
        }
    }
    $valoracion = (int)($valoracion);
   
    return $valoracion;
}


function editarEmail ($usuario, $email){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET email = :email "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":email", $email);


    $consulta->execute();
  
        
}


function editarEstado ($usuario, $estado){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET estado = :estado "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":estado", $estado);


    $consulta->execute();
  
        
}


function comprobarSiUsuarioConfirmado_usuario($usuario){
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



function eliminarCuenta($usuario){
    
}