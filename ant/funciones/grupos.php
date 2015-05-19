<?php





function getGrupos(){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_grupos_usuarios "
            . "");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    return $encontrados;
}

function crearGrupo($creador, $nombre){
    
    
    global $pdo;
    
    
    
    
    
    
    $consulta = $pdo->prepare("INSERT INTO web.db_grupos_usuarios "
    . "(creador, fecha_creacion, fecha_ultima_modificacion, nombre) VALUES "
    . "(:creador, now(), now(), :nombre)");
    
    $consulta->bindParam(":creador", $creador);
    $consulta->bindParam(":nombre", $nombre);
    $consulta->execute();

    
    
}

function editarNombreGrupo ($id, $nombre){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_grupos_usuarios "
            . "SET nombre = :nombre , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":nombre", $nombre);


    $consulta->execute();
  
        
}
function editarDescripcionGrupo ($id, $des){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_grupos_usuarios "
            . "SET descripcion = :descripcion , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":descripcion", $des);


    $consulta->execute();
  
        
}

function editarTipoGrupo ($id, $tipo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_grupos_usuarios "
            . "SET tipo = :tipo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":tipo", $tipo);


    $consulta->execute();
  
        
}

function editarUsuariosGrupo ($id, $usuarios){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_grupos_usuarios "
            . "SET usuarios = :usuarios , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":usuarios", $usuarios);


    $consulta->execute();
  
        
}


function getNombreGrupo ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT nombre FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["nombre"];
        
}

function getTipoGrupo ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT tipo FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["tipo"];
        
}

function getDescripcionGrupo ($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT descripcion FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    
    
    return $respuesta["descripcion"];
        
}

function getCampoUsuariosGrupo ($id){
    global $pdo;
    
    switch ($id) {
        case 1:
            
            $usu = getUsuariosGrupoEspecial1();
            return $usu;
            

            break;
        case 2:
            
            $usu = getUsuariosGrupoEspecial2();
            return $usu;
            

            break;
        case 3:
            
            $usu = getUsuariosGrupoEspecial3();
            return $usu;
            

            break;
        default:
            $consulta = $pdo->prepare("SELECT usuarios FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
            $consulta->bindParam(":id", $id);

            $consulta->execute();
            $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);


            return $respuesta["usuarios"];
            break;
    }
    
        
}

function getUsuariosGrupoConId($id){
    global $pdo;
       
        
    $consulta = $pdo->prepare("SELECT usuarios FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetch(PDO::FETCH_ASSOC);
    $usuarios = $respuesta["usuarios"];
    
    $vector = explode(" ", $usuarios);
    $salida = array();
    for($i=0; $i<count($vector); $i++){
        $nick = $vector[$i];
        if(substr($nick, 0,1)=="@"){
            //es un nick
            
            $nick = substr($nick, 1, strlen($nick)-1);
            if(comprobarSiUsuarioExiste($nick)){
                //$salida[] = getNickMencionado($nick);
            }            
        }else{
            //es un grupo
            
            
        }
    }
    
    return $salida;
        
}



function comprobarSiUsuarioPerteneceAGrupoConCampo($usuario, $campo){
    
    //echo $campo;
    if($campo=="1"){
        $salida = true;
    }else{
        
        $usuarios = getTodosUsuariosDeGrupoConCampo($campo);

        if(in_array('@' . $usuario, $usuarios)){
            $salida = true;
        }else{
            $salida = false;
        }
    }
    
    
    return $salida;
    
}

$usuariosArray = array();
$gruposArray = array();
$negativos;
function getTodosUsuariosDeGrupoConCampo($campo){
    global $usuariosArray;
    global $gruposArray;
    global $negativos;
    $usuariosArray = array();
    $gruposArray = array();
    $negativos = "";
    
    calcularTodosLosUsuariosDeGrupoConCampo($campo);
    $positivos = array_interseccion_grupos($usuariosArray, $usuariosArray);
    
    $usuariosArray = array();
    $gruposArray = array();
    calcularTodosLosUsuariosDeGrupoConCampo($negativos);
    $negativos = array_interseccion_grupos($usuariosArray, $usuariosArray);
    
    for($i=0; $i<count($negativos); $i++){
        $pos = array_search($negativos[$i], $positivos);
        
        if($pos!==false){
            
            unset($positivos[$pos]);
        }
    }
    return $positivos;
}

function getTodosUsuariosDeGrupoConId($id){
    
    $campo = getCampoUsuariosGrupo($id);
    $positivos = getTodosUsuariosDeGrupoConCampo($campo);
    
    
    return $positivos;
    
}

function calcularTodosLosUsuariosDeGrupoConCampo($campo){
    global $usuariosArray;
    global $gruposArray;
    global $negativos;
    
    $usuarios = explode(" ", $campo);
    
    for($i=0; $i<count($usuarios); $i++){
        $nick = $usuarios[$i];
        if(substr($nick, 0,1)=="-"){
            
            $nick = substr($nick, 1,  strlen($nick)-1);
            
            $negativos .= $nick . " ";
            
        }else{
            if(substr($nick, 0,1)=="@"){
                //es un nick

                $nick = substr($nick, 1, strlen($nick)-1);
                if(comprobarSiUsuarioExiste_grupo($nick)){
                    $usuariosArray[] = "@" . $nick;
                }else{
                    //$usuariosArray[] = "@" .$nick;
                }            
            }else{
                //es un grupo

                $grupo = $usuarios[$i];
                if( comprobarSiExisteGrupo($grupo)){
                    $esta = false;

                    if(in_array($grupo, $gruposArray)){
                        $esta=true;
                    }

                    if(!$esta){
                        $gruposArray[] = $grupo;
                        $campo2 = getCampoUsuariosGrupo($grupo);
                        //echo "<br><br><b>" . $campo2 . "</b><br><br>";
                        calcularTodosLosUsuariosDeGrupoConCampo($campo2);
                    }
                }else{
                    //$usuariosArray[] =  $grupo;
                }

            }
        }
    }
}




function array_interseccion_grupos($a1, $a2){
    $interseccion = array();
    
    for ($i=0; $i<count($a1); $i++){
        for ($j=0; $j<count($a2); $j++){
            if($a1[$i]==$a2[$j]){
                
                $encontrado = false;
                for ($k=0; $k<count($interseccion); $k++){
                    if($interseccion[$k]==$a1[$i]){$encontrado = true; }
                }
                if(!$encontrado){
                    $interseccion[] = $a1[$i];
                }
            }
            
        }
    }
    return $interseccion;
}

function comprobarSiUsuarioExiste_grupo($usuario){
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


function comprobarSiExisteGrupo ($id){
    global $pdo;
    global $arrayGruposEspeciales;
    
        
    $consulta = $pdo->prepare("SELECT nombre FROM web.db_grupos_usuarios "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    
    if(count($respuesta)>=1){
        return true;
    }else{
        for($i=0; $i<count($arrayGruposEspeciales); $i++){
            if($arrayGruposEspeciales[$i]==$id){
                return true;
            }
        }
        return false;
    }
    
    
        
}



function getUsuariosGrupoEspecial1(){
    //todos los usuarios
    
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
            . "");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    //var_dump($encontrados);
    $salida = "";
    for($i=0; $i<count($encontrados); $i++){
        $salida .= "@" . $encontrados[$i]["usuario"] . " ";
    }
    
    
    return $salida;
    
    
}

function getUsuariosGrupoEspecial2(){
    //todos los usuarios
    
    global $pdo;
    global $minutosParaConsiderarOnline;
    

    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
            . 'WHERE (YEAR(fecha_ultima_visita)= :ano '
            . 'AND MONTH(fecha_ultima_visita)= :mes '
            . 'AND DAY(fecha_ultima_visita)= :dia '
            . 'AND HOUR(fecha_ultima_visita) = :hora '
            . 'AND :minuto - MINUTE(fecha_ultima_visita) <= :minutosOnline) OR '
            . '(YEAR(fecha_ultima_visita)= :ano '
            . 'AND MONTH(fecha_ultima_visita)= :mes '
            . 'AND DAY(fecha_ultima_visita)= :dia '
            . 'AND HOUR(fecha_ultima_visita)+1 = :hora '
            . 'AND :minuto + 60 - MINUTE(fecha_ultima_visita) <= :minutosOnline)');
    $consulta->bindParam(":ano", date('Y'));
    $consulta->bindParam(":mes", date('m'));
    $consulta->bindParam(":dia", date('d'));
    $consulta->bindParam(":hora", date('H'));
    $consulta->bindParam(":minuto", date('i'));
    $consulta->bindParam(":minutosOnline", $minutosParaConsiderarOnline);
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    //var_dump($encontrados);
    $salida = "";
    for($i=0; $i<count($encontrados); $i++){
        $salida .= "@" . $encontrados[$i]["usuario"] . " ";
    }
    
    
    return $salida;
    
    
}

function getUsuariosGrupoEspecial3(){
    //todos los usuarios
    
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_usuarios "
            . "WHERE estado = 0");
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    //var_dump($encontrados);
    $salida = "";
    for($i=0; $i<count($encontrados); $i++){
        $salida .= "@" . $encontrados[$i]["usuario"] . " ";
    }
    
    
    return $salida;
    
    
}


function eliminarGrupo ($id){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_grupos_usuarios "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}
