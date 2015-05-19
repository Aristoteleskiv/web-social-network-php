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

