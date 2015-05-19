<?php




function crearPublicacion ($autor, $cuerpo, $titulo, $tipoDocumento, 
                                    $tipoClasificacion, $ayudas, $referencias, $idMaterialComplementario){
    global $pdo;
       
        
    $consulta = $pdo->prepare("INSERT INTO web.db_publicaciones "
            . "( titulo,  autor, fecha, fecha_ultima_modificacion, "
            . "cuerpo, tipo_documento, ayuda_busqueda, id_material_complementario) VALUES "
            . "( :titulo, :autor,  now(), now(),"
            . " :cuerpo, :tipo, :ayuda, :idCom )");

    $consulta->bindParam(":autor", $autor);
    $consulta->bindParam(":titulo", $titulo);
    $consulta->bindParam(":cuerpo", $cuerpo);
    $consulta->bindParam(":tipo", $tipoDocumento);

    $consulta->bindParam(":ayuda", $ayudas);
    $consulta->bindParam(":idCom", $idMaterialComplementario);
    $consulta->execute();

    $id = $pdo->lastInsertId("id");
    

    return $id;
        
}
function editarPublicacion ($id, $autor, $cuerpo, $titulo, $tipoDocumento, 
                                    $tipoClasificacion, $ayudas, $referencias, $idMaterialComplementario){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET ayuda_busqueda = :ayuda_busqueda, "
            . "titulo = :titulo, "
            . "autor = :autor, cuerpo = :cuerpo , "
            . "tipo_documento = :tipo_documento, "
            . "tipo_clasificacion = :tipo_clasificacion, "
            . "referencias = :referencias , "
            . "id_material_complementario = :id_material_complementario , "
            . "fecha_ultima_modificacion = now()  "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":ayuda_busqueda", $ayudas);
    $consulta->bindParam(":autor", $autor);
    $consulta->bindParam(":cuerpo", $cuerpo);

    $consulta->bindParam(":titulo", $titulo);
    $consulta->bindParam(":tipo_documento", $tipoDocumento);
    $consulta->bindParam(":tipo_clasificacion", $tipoClasificacion);
    $consulta->bindParam(":tipo_clasificacion", $tipoClasificacion);
    $consulta->bindParam(":referencias", $referencias);
    $consulta->bindParam(":id_material_complementario", $idMaterialComplementario);
    $consulta->execute();
  
       
}


function editarPublicacionAyudasBusqueda ($id, $ayudas){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET ayuda_busqueda = :ayudas , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":ayudas", $ayudas);


    $consulta->execute();
  
        
}

function editarPublicacionDificultad ($id, $dif){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET dificultad = :dif , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":dif", $dif);


    $consulta->execute();
  
        
}

function editarPublicacionTipoDocumento ($id, $tipo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET tipo_documento = :tipo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":tipo", $tipo);


    $consulta->execute();

        
}
function editarPublicacionCuerpo ($id, $cuerpo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET cuerpo = :cuerpo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":cuerpo", $cuerpo);


    $consulta->execute();
  
        
}
function editarPublicacionTitulo ($id, $titulo){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET titulo = :titulo , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":titulo", $titulo);


    $consulta->execute();
  
        
}

function editarPublicacionDir ($id, $dir){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET dir = :dir , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":dir", $dir);


    $consulta->execute();
  
        
}

function editarPublicacionRespuesta ($id, $respuesta){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
            . "SET respuesta = :respuesta , fecha_ultima_modificacion = now() "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":respuesta", $respuesta);


    $consulta->execute();
  
        
}


function getIDReferenciaVideoPublicacion_Editor($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_referencia_videos "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["id"];
        
}
function getIDReferenciaPDFPublicacion_Editor($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_referencia_pdf "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["id"];
        
}
function editarPublicacionVideo ($id, $servidor, $referencia){
    
    global $pdo;

    $idPublicacion = getIDReferenciaVideoPublicacion_Editor($id);
    if($idPublicacion==null){

        $consulta = $pdo->prepare("INSERT INTO web.db_referencia_videos "
            . "(id_referencia, servidor_video,  identificativo_video) VALUES "
            . "(:id_referencia, :servidor_video,  :identificativo_video)");
        $consulta->bindParam(":id_referencia", $id);
        $consulta->bindParam(":servidor_video", $servidor);
        $consulta->bindParam(":identificativo_video", $referencia);
        $consulta->execute();
    }else{
         $consulta = $pdo->prepare("UPDATE web.db_referencia_videos "
            . "SET servidor_video = :servidor_video , "
                 . "identificativo_video = :identificativo_video "
            . "WHERE id_referencia = :id");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":servidor_video", $servidor);
        $consulta->bindParam(":identificativo_video", $referencia);
        $consulta->execute();
    }
    
    
       
}
function editarPublicacionPdf ($id, $nombre){
    
    global $pdo;
        
    $idPublicacion = getIDReferenciaPDFPublicacion_Editor($id);
    if($idPublicacion==null){

        $consulta = $pdo->prepare("INSERT INTO web.db_referencia_pdf "
            . "(id_referencia, nombre) VALUES "
            . "(:id_referencia, :nombre)");
        $consulta->bindParam(":id_referencia", $id);
        $consulta->bindParam(":nombre", $nombre);

        $consulta->execute();
    }else{
         $consulta = $pdo->prepare("UPDATE web.db_referencia_pdf "
            . "SET nombre = :nombre "
            . "WHERE id_referencia = :id");
        $consulta->bindParam(":id", $id);
        $consulta->bindParam(":nombre", $nombre);

        $consulta->execute();
    }

    
       
}
function editarPublicacionMaterialComplementario ($id, $idComplementario){
    
    global $pdo; 
        
         
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
       . "SET id_material_complementario = :idComp "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":idComp", $idComplementario);

    $consulta->execute();

    
    
       
}
function editarPublicacionAprobar ($id){
    global $pdo;
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
       . "SET estado = 1 "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}
function editarPublicacionDesaprobar ($id){
    global $pdo;
         
        
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones "
       . "SET estado = 0 "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}
function eliminarPublicacion ($id){
    global $pdo;

    $consulta = $pdo->prepare("DELETE FROM web.db_publicaciones "
       . "WHERE id = :id");
    $consulta->bindParam(":id", $id);


    $consulta->execute();
}



function crearDocumento($dir, $id, $nivel){
    
    $cadenaNivel = getCadenaSubirNivel($nivel);
    $path = $cadenaNivel . "p/" . $dir;
    if (!file_exists($path)) {
        mkdir($path , 0775, true);
    }
    $fp = fopen($path . "/index.php", 'w');
    $contenido = getEstructuraHtmlArticulo($id);
    fwrite($fp, $contenido);
    
    fclose($fp);
    
}


function getEstructuraHtmlArticulo($id){
    $nivel = 5;
    $s = getCadenaSubirNivel($nivel);
    $salida = '<!DOCTYPE html>
    <?php
    include_once \''. $s .'func/secciones.php\';
    include_once \''. $s .'conf/conf.php\';
    include_once \''. $s .'conf/sesion.php\';
    include_once \''. $s .'func/publicaciones.php\';
    include_once \''. $s .'func/colecciones.php\';
    include_once \''. $s .'func/usuario.php\';
    include_once \''. $s .'func/otras.php\';
    include_once \''. $s .'func/clases/publicaciones.php\';
    $nivel = '. $nivel . ';
    $id = '. $id . ';
    
    sumarVisitaAPublicacion($id);
    $usuario = $_SESSION["usr"];
    $col = null;
    
    if(isset($_GET["c"])){
        $col = $_GET["c"];
        sumarVisitaAColeccion($col);
    }
    
    $posComentario = null;
    ?>
    <html lang="es">
        <head>
            <?php echo getHead($nivel); ?>
        </head>
        <body>
            <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
            <div id="vertical">
                <aside id="menu">
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>
                <section id="contenido">
                        <div class="div-contenido">
                            <h1>Publicación '. $id .'</h1>
                            <div class="div-contenido-no-titulo">
                            <?php 
                            $elemento = new Publicacion($id, $usuario, $col, $posComentario, $nivel);
                            echo $elemento->getHtml();
                            ?>
                            </div>
                        </div>
                    <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
            </div>
            <div>
                <?php echo getScrolls($nivel); ?>
            </div>
        </body> 
    </html>';
    return $salida;
}
