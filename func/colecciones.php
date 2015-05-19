<?php




function getColeccionesDePublicacion($idPublicacion){
    
    
    global $pdo;
    $salida = array();
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE estado=1");
    
    $consulta->execute();
    $colecciones = $consulta->fetchAll();
    
    for($i=0; $i<count($colecciones); $i++){
        $idColeccion = $colecciones[$i]["id"];
        
        if($colecciones[$i]["coleccion"]==1){
            
            $ref = $colecciones[$i]["ref"];
            $publicaciones = explode(" ", $ref);
            for($j=0; $j<count($publicaciones);$j++){
                if((int)$publicaciones[$j]==$idPublicacion){
                    $salida[] = $idColeccion;
                    break 1;
                }
            }
        }
        
        if($colecciones[$i]["coleccion"]==2){
            
            
            $publicaciones = getIDsColeccionColeccion($idColeccion);
            for($j=0; $j<count($publicaciones);$j++){
                if((int)$publicaciones[$j]==$idPublicacion){
                    $salida[] = $idColeccion;
                    break 1;
                }
            }
        }
        
        
    }
    return $salida;
    
    
    
    
}





function sumarVisitaAColeccion($id){
     
    global $pdo;
    
    $consulta = $pdo->prepare("UPDATE web.db_colecciones SET "
                    . "visitas = visitas + 1 WHERE "
                    . "id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    
}


function getColecciones($usuario, $pagina){
    
    global $numeroResultadosPorPagina;
    global $pdo;
        
    $inicio = $numeroResultadosPorPagina*($pagina-1);
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE estado=1 ORDER BY fecha_ultima_modificacion DESC LIMIT :inicio, :numres");
    $consulta->bindValue(":numres", (int)($numeroResultadosPorPagina+1), PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    
    $salida = $publicaciones;
    
    
    
    return $salida;
    
    
   
}


function getColeccion($id){
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE id = :id AND estado=1");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones;
    
    
}

function getColeccionesPendientes($usuario){
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE autor = :autor AND estado=0 ORDER BY fecha_ultima_modificacion DESC");
    $consulta->bindParam(":autor", $usuario);
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
    
}

function eliminarColeccion ($id){
    global $pdo;

        
    $consulta = $pdo->prepare("DELETE FROM web.db_colecciones "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}

function getColeccionesAprobadas($usuario, $pagina){

     
    global $numeroResultadosPorPagina;
    global $pdo;
        
    $inicio = $numeroResultadosPorPagina*($pagina-1);
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE autor = :autor AND estado = 1 ORDER BY fecha_ultima_modificacion DESC LIMIT :inicio, :numres");
    $consulta->bindParam(":autor", $usuario);
    $consulta->bindValue(":numres", (int)($numeroResultadosPorPagina), PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    
    $salida = $publicaciones;
    
    
    
    return $salida;
    
    
    
}
function getColeccionAprobadasConIDDeAutor($autor, $id){
    
    global $pdo;
        
       
    $consulta = $pdo->prepare("SELECT * FROM web.db_colecciones "
            . "WHERE autor = :autor AND estado = 1 AND id = :id "
            . "ORDER BY fecha_ultima_modificacion DESC");
    $consulta->bindParam(":autor", $autor);
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
    

    
}

function crearColeccion ($nombre, $descripcion, $imagen, $autor){
    global $pdo;
       
        
    $consulta = $pdo->prepare("INSERT INTO web.db_colecciones "
            . "( nombre, descripcion, imagen, fecha_ultima_modificacion, fecha_creacion, autor )"
            . " VALUES "
            . "( :nombre, :descripcion, :imagen, now(), now(), :autor )");

    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":descripcion", $descripcion);
    $consulta->bindParam(":imagen", $imagen);
    $consulta->bindParam(":autor", $autor);
    $consulta->execute();

    $id = $pdo->lastInsertId("id");
    

    return $id;
        
}

function getNombreColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT nombre FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["nombre"];
    
}
function getDescripcionColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT descripcion FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["descripcion"];
    
}
function getImagenColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT imagen FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["imagen"];
    
}






function getTitulosColeccion($id){
    global $auxIDs;
    $col = getColeccionColeccion($id);
    $titulos = array();
    if($col==1){
        $ref = getReferenciasColeccion($id);
        $refs = explode(" ", $ref);
        for($i=0; $i<count($refs); $i++){
            
            $id = (int)$refs[$i];
            $titulos[] = getTituloPublicacion_colecciones($id);
            
        }
    }
    
    
    
    return $titulos;
    
}

function array_interseccion_colecciones($a1, $a2){
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

function getTitulosColeccionColeccion($id){
    $ids = getIDsColeccionColeccion($id);
    $ids = array_interseccion_colecciones($ids, $ids);
    
    $titulos = array();
    
    for($i=0; $i<count($ids); $i++){
        $titulos[] = getTituloPublicacion_colecciones($ids[$i]);
    }
    
    
    return $titulos;
    
}


$arbol = array();



function calcularIDsPublicacionesYColeccionesEnColeccion($id){
    global $auxIDs;
    
    $col = getColeccionColeccion($id);
    $ref = getReferenciasColeccion($id);
    $refs = explode(" ", $ref);
    
    if($col == 1){
        for($i=0; $i<count($refs); $i++){
            
            $auxIDs[] = $refs[$i] . " 1";
        }
    }
    
    if($col == 2){
        
        for($i=0; $i<count($refs); $i++){
            $auxIDs[] = $refs[$i] . " 2";
            calcularIDsPublicacionesYColeccionesEnColeccion($refs[$i]);
        }
    }
      
    
}

function getIDsPublicacionesYColeccionesColeccion($id){
    global $auxIDs;
    
    $auxIDs = array();
    
    calcularIDsPublicacionesYColeccionesEnColeccion($id);
   
    return $auxIDs;
}



function getHijosColeccion($id){
    
    //esto solo devuelve colecciones
    $col = getColeccionColeccion($id);
    $ref = getReferenciasColeccion($id);
    $refs = explode(" ", $ref);
    
    $salida = array();
    if($col == 2){
       $salida = $refs;
    }
    return $salida;
}



$profundidad;
$auxIDs = array();

function calcularIDsPublicacionesEnColeccion($id){
    global $auxIDs;
    global $profundidad;
    $col = getColeccionColeccion($id);
    $ref = getReferenciasColeccion($id);
    $refs = explode(" ", $ref);
    
    if($col == 1){
        for($i=0; $i<count($refs); $i++){
            
            $auxIDs[] = $refs[$i];
        }
    }
    
    if($col == 2){
        $profundidad++;
        for($i=0; $i<count($refs); $i++){
            
            calcularIDsPublicacionesEnColeccion($refs[$i]);
        }
    }
      
    
}

function getIDsColeccionColeccion($id){
    global $auxIDs;
    global $profundidad;   
    $auxIDs = array();
    $profundidad = 1;
    calcularIDsPublicacionesEnColeccion($id);
   
    return $auxIDs;
}


function getProfundidadColeccion($id){
    
    //OJOOOO. SOLO llamar despues de ejecutar getNumeroDePublicaciones o getIDsColeccionColeccion
    //sino devolvera null
    global $profundidad;
    return $profundidad;
}

function getNumeroDePublicacionesEnColeccion($id){
    $ids = getIDsColeccionColeccion($id);
    return count($ids);
}



function getIPublicacion_colecciones($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["titulo"];
}


function getTituloPublicacion_colecciones($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["titulo"];
}


function getFechaCreacionColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT fecha_creacion FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["fecha_creacion"];
    
}
function getFormatoColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT formato FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["formato"];
    
}
function getColeccionColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT coleccion FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["coleccion"];
    
}
function getFechaUltimaModificacionColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT fecha_ultima_modificacion FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["fecha_ultima_modificacion"];
    
}
function getNumeroVisitasColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT visitas FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["visitas"];
    
}
function getEstadoColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT estado FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["estado"];
    
}
function getReferenciasColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT ref FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["ref"];
    
}
function getAutorColeccion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT autor FROM web.db_colecciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["autor"];
    
}


function editarColeccionNombre ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET nombre = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}
function editarColeccionColeccion ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET coleccion = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}
function editarFormatoColeccion ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET formato = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}
function editarColeccionRef ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET ref = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}
function editarColeccionDescripcion ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET descripcion = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}


function editarColeccionImagen ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET imagen = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}

function editarColeccionEstado ($id, $texto){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_colecciones "
            . "SET estado = :texto , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":texto", $texto);


    $consulta->execute();
  
        
}

function editarColeccionAprobar ($id){
    
    editarColeccionEstado($id, 1);
        
}
function editarColeccionDesaprobar ($id){
    
    editarColeccionEstado($id, 0);
        
}