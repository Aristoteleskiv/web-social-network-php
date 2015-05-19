<?php
function checkSiDirPublicacionExiste($dir, $nivel){
    
    $subidas = getCadenaSubirNivel($nivel);
    $nombre_fichero = $subidas . $dir;
    $salida = "NO";
    if (file_exists($nombre_fichero)) {
        $salida = "SI";
    } 
    return $salida;
}

function getCadenaSubirNivel($nivel){
    $subidas ="";
    for($i=0; $i<$nivel; $i++){
        $subidas .= "../";
    }
    return $subidas;
}


function quitarSimbolosString($string){
    
    $titulo = $string;
    
    if (substr($titulo, 0, 1)==" "){
        $titulo = substr($titulo, 1, strlen($titulo)-1);
    }
    $titulo = str_replace("[latex]", "", $titulo);
    $titulo = str_replace("[/latex]", "", $titulo);
    $titulo = str_replace("[latex]c", "", $titulo);
    $titulo = str_replace(".", "", $titulo);
    $titulo = str_replace(")", "", $titulo);
    $titulo = str_replace("(", "", $titulo);
    $titulo = str_replace(",", "", $titulo);
    $titulo = str_replace(":", "", $titulo);
    $titulo = str_replace("*", "", $titulo);
    $titulo = str_replace("?", "", $titulo);
    $titulo = str_replace("¿", "", $titulo);
    $titulo = str_replace("|", "", $titulo);
    $titulo = str_replace("\\", "", $titulo);
    $titulo = str_replace("/", "", $titulo);
    $titulo = str_replace("\"", "", $titulo);
    $titulo = str_replace(">", "", $titulo);
    $titulo = str_replace("<", "", $titulo);
    $titulo = str_replace("!", "", $titulo);
    $titulo = str_replace("¡", "", $titulo);
    $titulo = str_replace("'", "", $titulo);
    $titulo = str_replace("à", "a", $titulo);
    $titulo = str_replace("á", "a", $titulo);
    $titulo = str_replace("ä", "a", $titulo);
    $titulo = str_replace("â", "a", $titulo);
    $titulo = str_replace("è", "e", $titulo);
    $titulo = str_replace("é", "e", $titulo);
    $titulo = str_replace("ë", "e", $titulo);
    $titulo = str_replace("ê", "e", $titulo);
    $titulo = str_replace("ì", "i", $titulo);
    $titulo = str_replace("í", "i", $titulo);
    $titulo = str_replace("î", "i", $titulo);
    $titulo = str_replace("ï", "i", $titulo);
    $titulo = str_replace("ò", "o", $titulo);
    $titulo = str_replace("ó", "o", $titulo);
    $titulo = str_replace("ö", "o", $titulo);
    $titulo = str_replace("ô", "o", $titulo);
    $titulo = str_replace("ù", "u", $titulo);
    $titulo = str_replace("ú", "u", $titulo);
    $titulo = str_replace("û", "u", $titulo);
    $titulo = str_replace("ü", "u", $titulo);
    
    
    $titulo = str_replace(array("\r\n", "\r"), "\n", $titulo);
    $lines = explode("\n", $titulo);
    $new_lines = array();
    foreach ($lines as $i => $line) {
        if(!empty($line)){
        $new_lines[] = trim($line);}
    }
    $titulo= implode($new_lines);
    
    
    
    $titulo = str_replace(" ", "-", $titulo);
    $titulo = str_replace(" ", "-", $titulo);
    $titulo = str_replace("---", "-", $titulo);
    $titulo = str_replace("--", "-", $titulo);
    return $titulo;

}

function getDirSeccionado($id){
    $dimId =  strlen((string)$id);
    $primero = substr($id, $dimId-1, 1);
    $segundo = substr($id, $dimId-2, 1);
    
    return $primero . "/" . $segundo . "/";

}



function crearThumb($src, $dest, $desired_width) {

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
}
    
function getVotosNegativos($idPublicacion, $posicionComentario){
    global $pdo;
        
        //primero comprobamos que el usuario no ha votado ya a este comentario

    $consulta = $pdo->prepare("SELECT votos_negativos FROM web.db_comentarios "
            . "WHERE id_publicacion = :id_publicacion AND posicion = :posicion");

    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":posicion", $posicionComentario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    return $encontrados["votos_negativos"];

}
function getVotosPositivos($idPublicacion, $posicionComentario){
    global $pdo;
        
    //primero comprobamos que el usuario no ha votado ya a este comentario

     $consulta = $pdo->prepare("SELECT votos_positivos FROM web.db_comentarios "
            . "WHERE id_publicacion = :id_publicacion AND posicion = :posicion");

    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":posicion", $posicionComentario);
    $consulta->execute();
    $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
    return $encontrados["votos_positivos"];

}
function votar($usuario, $idPublicacion, $posicionComentario, $voto){
    global $pdo;
        
        //primero comprobamos que el usuario no ha votado ya a este comentario
    
    if($usuario!=null){
        $consulta = $pdo->prepare("SELECT * FROM web.db_votos "
               . "WHERE usuario = :usuario AND id_publicacion = :id_publicacion AND posicion_comentario = :posicion");
       $consulta->bindParam(":usuario", $usuario);
       $consulta->bindParam(":id_publicacion", $idPublicacion);
       $consulta->bindParam(":posicion", $posicionComentario);
       $consulta->execute();
       $encontrados = $consulta->fetchAll();
       if(count($encontrados)>=1){

           $salida = '<span class="voto-positivo">+' . 
                   getVotosPositivos($idPublicacion, $posicionComentario) . 
               '</span><span class="voto-negativo">-'
                   . getVotosNegativos($idPublicacion, $posicionComentario)  . 
                    '</span>';
           echo $salida;;

       }else{

           $consulta = $pdo->prepare("INSERT INTO web.db_votos "
                   . "(usuario,  id_publicacion, posicion_comentario, fecha, voto) VALUES "
                   . "(:usuario,  :id_publicacion, :posicion, now(), :voto)");
           $consulta->bindParam(":usuario", $usuario);
           $consulta->bindParam(":id_publicacion", $idPublicacion);
           $consulta->bindParam(":posicion", $posicionComentario);
           $consulta->bindParam(":voto", $voto);
           $consulta->execute();


           switch ($voto) {
               case 1:

                   $consulta = $pdo->prepare("UPDATE web.db_comentarios SET "
                   . "votos_positivos = votos_positivos + 1 WHERE "
                   . "id_publicacion = :id_publicacion AND posicion = :posicion");

                   break;
               case -1:

                   $consulta = $pdo->prepare("UPDATE web.db_comentarios SET "
                   . "votos_negativos = votos_negativos + 1 WHERE "
                   . "id_publicacion = :id_publicacion AND posicion = :posicion");
                   break;

               default:
                   break;
           }


           $consulta->bindParam(":id_publicacion", $idPublicacion);
           $consulta->bindParam(":posicion", $posicionComentario);
           $consulta->execute();

           $salida = '<span class="voto-positivo">+' . 
                   getVotosPositivos($idPublicacion, $posicionComentario) . 
               '</span> <span class="voto-negativo">-' . 
                   getVotosNegativos($idPublicacion, $posicionComentario) . '</span>';
           echo $salida;
       }
   }else{
      echo "<span style='font-size: 10px;'>Solo para registrados</span>";
   }

}

function getNombrePublicacion($id){
    global $db_dominio;
    global $db_user;
    global $db_password;
   
    try {
            $pdo = new PDO("mysql:host=$db_dominio;dbname=mysql", $db_user, $db_password);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }  
        
        $consulta = $pdo->prepare("SELECT titulo FROM web.db_publicaciones "
                . "WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $encontrados = $consulta->fetch(PDO::FETCH_ASSOC);
        
        return $encontrados["titulo"];
}


$textoPagAnt;
$arrayPagAnt;


function busquedaPublicacionPorTexto($text, $pagina){
    global $pdo;
    global $textoPagAnt;
    global $arrayPagAnt;

        
        $publicaciones = array();
        $palabras = explode(" ", $text); 
        for($i=0; $i<count($palabras); $i++){
            $palabra = $palabras[$i];

            $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones WHERE "
                   . "((titulo LIKE :palabra) OR "
                   . "(cuerpo LIKE :palabra) OR "
                   . "(ayuda_busqueda LIKE :palabra) OR"
                   . "(id LIKE :palabra) OR"
                   . "(autor LIKE :palabra)) AND (estado=1)"
                   . " ORDER BY fecha_ultima_modificacion DESC ");
            
            $consulta->bindValue(":palabra","%$palabra%", PDO::PARAM_STR);
            $consulta->execute();
            $publicaciones[] = $consulta->fetchAll();

        }



        //if(count($publicaciones)>1){
           $ids = array();
           $linea = array();   

           for ($i=0; $i<count($publicaciones); $i++){
               $linea = array();
               for ($j=0; $j<count($publicaciones[$i]); $j++){

                   $linea[] = $publicaciones[$i][$j]["id"];
                   //echo $publicaciones[$i][$j]["id"] . ', ';
              }
              //echo "<br><br>";
              $ids[] = $linea;
           }
           $result = $ids[0];
           for ($i = 1; $i < count($ids); $i++) {
               $result = array_interseccion($result, $ids[$i]);
           }
    global $numeroResultadosPorPagina;
    $salida = array();
    $pag = $numeroResultadosPorPagina;
    //var_dump($result);
    for($i=$pag*($pagina-1); $i<$pag*($pagina)+1; $i++){
        if($result[$i]!=null){
            $salida[] = $result[$i];
        }
    }
     
     
    return $salida;
      
}


function busquedaColeccionPorTexto($text, $pagina){
    global $pdo;
        
     $publicaciones = array();
     $palabras = explode(" ", $text); 
     for($i=0; $i<count($palabras); $i++){
         $palabra = $palabras[$i];
         
         $consulta = $pdo->prepare("SELECT id FROM web.db_colecciones WHERE "
                . "((nombre LIKE :palabra) OR "
                . "(descripcion LIKE :palabra)) AND (estado=1)"
                . " ORDER BY fecha_ultima_modificacion ASC");
        $consulta->bindValue(":palabra","%$palabra%", PDO::PARAM_STR);
        $consulta->execute();
        $publicaciones[] = $consulta->fetchAll();
         
     }
     
     
     
     //if(count($publicaciones)>1){
        $ids = array();
        $linea = array();   

        for ($i=0; $i<count($publicaciones); $i++){
            $linea = array();
            for ($j=0; $j<count($publicaciones[$i]); $j++){

                $linea[] = $publicaciones[$i][$j]["id"];
                //echo $publicaciones[$i][$j]["id"] . ', ';
           }
           //echo "<br><br>";
           $ids[] = $linea;
        }
        
        
        $result = $ids[0];
        for ($i = 1; $i < count($ids); $i++) {
            $result = array_interseccion($result, $ids[$i]);
        }
        
        
        
    global $numeroResultadosPorPagina;
    $salida = array();
    $pag = $numeroResultadosPorPagina;
    //var_dump($result);
    for($i=$pag*($pagina-1); $i<min($pag*($pagina)+1, count($result)); $i++){
        if($result[$i]!=null){
            $salida[] = $result[$i];
        }
    }
     
     
    return $salida;
     
    
      
}


function array_interseccion($a1, $a2){
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

function array_no_interseccion($a1, $a2){
    $interseccion = array();
    
    for ($i=0; $i<count($a1); $i++){
        for ($j=0; $j<count($a2); $j++){
            if($a1[$i]==$a2[$j]){

            }else{
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

function busquedaPublicacionPorID($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones WHERE "
            . "(id LIKE :id) ORDER BY fecha_ultima_modificacion ASC");
    $consulta->bindValue(":id","%$id%", PDO::PARAM_STR);
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
}




function getPublicacionesVistas($usuario, $pagina){
     
    global $pdo;
    global $numeroResultadosPorPagina;
    
    $inicio = $numeroResultadosPorPagina*($pagina-1);
    $numres = 1E10; //
    //metemos ese num porque si pedimos 10, es posible que luego no esten activos (estado=1).
    // asique pedimos todos y solo nos quedamos con lso 10 primeros activos
    $consulta = $pdo->prepare("SELECT id_publicacion FROM web.db_visto "
            . "WHERE usuario = :usuario ORDER BY "
            . "fecha DESC LIMIT :inicio, :numres");
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->bindValue(":numres", (int)$numres, PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    
    
    $activos = array();
    
    $contador = 0;
    for($i=0; $i<count($encontrados); $i++){
        
        $id = $encontrados[$i]["id_publicacion"];
        
        $consulta = $pdo->prepare("SELECT estado FROM web.db_publicaciones "
            . "WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $estado = $consulta->fetch(PDO::FETCH_ASSOC);
        $estado = $estado["estado"];
        if($estado==1){
            
            $activos[]= $encontrados[$i];
            $contador++;
            if($contador==$numeroResultadosPorPagina+1){
                break;
            }
        }
        
    }
    
    return $activos;
    
}
function marcarPublicacionVista($usuario, $idPublicacion){
    
     
    global $pdo;
    
    //borramos si hay otra anterior
    $consulta = $pdo->prepare("DELETE FROM web.db_visto WHERE "
                . "id_publicacion = :id AND usuario = :usuario");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    //marcamos la nueva con la nueva fecha
    
    $consulta = $pdo->prepare("INSERT INTO web.db_visto "
            . "(id_publicacion, usuario, fecha) VALUES "
            . "(:id_publicacion, :usuario, now())");
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->bindParam(":usuario", $usuario);

    $consulta->execute();
    
}
function getPublicacionesGuardasParaMasTarde($usuario, $pagina, $desfase = null){
    
    //El desfase nos indica si se han desmarcado publicaciones y luego le damos
    // a cargar más, ajusta el resultado con lo que hay por pantalla.
    
    global $pdo;
    global $numeroResultadosPorPagina;
    
    if($desfase == null){
        $desfase = 0;
    }
    
    $inicio = $numeroResultadosPorPagina*($pagina-1)-$desfase;
    $numres = 1E10; //
    //metemos ese num porque si pedimos 10, es posible que luego no esten activos (estado=1).
    // asique pedimos todos y solo nos quedamos con lso 10 primeros activos
    $consulta = $pdo->prepare("SELECT id_publicacion FROM web.db_guardar_para_mas_tarde "
            . "WHERE usuario = :usuario ORDER BY "
            . "fecha DESC LIMIT :inicio, :numres");
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->bindValue(":numres", (int)$numres, PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    
    
    $activos = array();
    
    
    $contador = 0;
    for($i=0; $i<count($encontrados); $i++){
        
        $id = $encontrados[$i]["id_publicacion"];
        
        $consulta = $pdo->prepare("SELECT estado FROM web.db_publicaciones "
            . "WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $estado = $consulta->fetch(PDO::FETCH_ASSOC);
        $estado = $estado["estado"];
        if($estado==1){
            
            $activos[]= $encontrados[$i];
            $contador++;
            if($contador==$numeroResultadosPorPagina+1){
                break;
            }
        }
        
    }
    
    return $activos;
        

    
}
function getPublicacionesRealizadas($usuario, $pagina, $desfase = null){
    
    
    
    global $pdo;
    global $numeroResultadosPorPagina;
    
     if($desfase == null){
        $desfase = 0;
    }
    
    $inicio = $numeroResultadosPorPagina*($pagina-1)-$desfase;
    $numres = 1E10; //
    //metemos ese num porque si pedimos 10, es posible que luego no esten activos (estado=1).
    // asique pedimos todos y solo nos quedamos con lso 10 primeros activos
    $consulta = $pdo->prepare("SELECT id_publicacion FROM web.db_publicaciones_realizadas "
            . "WHERE usuario = :usuario ORDER BY "
            . "fecha DESC LIMIT :inicio, :numres");
    $consulta->bindParam(":usuario", $usuario);
    
    $consulta->bindValue(":numres", (int)$numres, PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    $consulta->execute();
    $encontrados = $consulta->fetchAll();
    
    
    $activos = array();
    
    
    $contador = 0;
    for($i=0; $i<count($encontrados); $i++){
        
        $id = $encontrados[$i]["id_publicacion"];
        
        $consulta = $pdo->prepare("SELECT estado FROM web.db_publicaciones "
            . "WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $estado = $consulta->fetch(PDO::FETCH_ASSOC);
        $estado = $estado["estado"];
        if($estado==1){
            
            $activos[]= $encontrados[$i];
            $contador++;
            if($contador==$numeroResultadosPorPagina+1){
                break;
            }
        }
        
    }
    
    return $activos;
    
    
}
function getIDReferenciaPDFPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_referencia_pdf "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["id"];
        
}

function getNombrePDFPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT nombre FROM web.db_referencia_pdf "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["nombre"];

}

function getArchivosDirectorio($dir, $extension){
    $dh  = opendir($dir);
    $contador = 0;
    while (false !== ($filename = readdir($dh))) {
        $contador++;
        if($contador>10000){break;}
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if($ext == $extension){
        $files[] = $filename;
        
        }
    }
    closedir($dh);
    return $files;
}
function getArchivosDirectorioEmpiezanPor($dir, $extension, $empiezanPor){
    $dh  = opendir($dir);
    $contador = 0;
    $files= array();
    while (false !== ($filename = readdir($dh))) {
        $contador++;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if($ext == $extension){
        if(substr($filename, 0, strlen($empiezanPor))==$empiezanPor){
            $files[] = $filename;
        }
        
        }
        
        if($contador > 10000){break;}
    }
    closedir($dh);
    if (count($files)== 0 ){
        $files[0] = "";
    }
    
    
    return $files;
}



function getIDReferenciaVideoPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT id FROM web.db_referencia_videos "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["id"];
        
}
function getHtmlVideoEmbebidoPublicacion($id){
    
    $url = getURLVideoEmbebidoPublicacion($id);
    $salida = '<iframe style="margin-top: 10px;" width="620" height="465" src="' . $url . '" '
            . 'frameborder="0" allowfullscreen></iframe>';
    return $salida;

}
function getURLVideoEmbebidoPublicacion($id){
    global $pdo;
        
        
        $idReferencia = getIDReferenciaVideoPublicacion($id);

        $consulta = $pdo->prepare("SELECT servidor_video, identificativo_video FROM web.db_referencia_videos "
                . "WHERE id = :id");
        $consulta->bindParam(":id", $idReferencia);
        $consulta->execute();
        $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
        
        
        
        $refVideo = $publicaciones["identificativo_video"];
        $servidor = $publicaciones["servidor_video"];
        $salida = "";
        switch ($servidor) {
            case "youtube":
                    $salida = "//www.youtube.com/embed/" . $refVideo;

                break;

            default:
                break;
        }
        
        
        
        
        
        
        return $salida;
        
}
function getIdentificativoReferenciaVideoPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT identificativo_video FROM web.db_referencia_videos "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["identificativo_video"];
        
}
function getServidorReferenciaVideoPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT servidor FROM web.db_referencia_videos "
            . "WHERE id_referencia = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["servidor"];
        
}

function sumarVisitaAPublicacion($idPublicacion){
     
    global $pdo;
    
    $consulta = $pdo->prepare("UPDATE web.db_publicaciones SET "
                    . "visitas = visitas + 1 WHERE "
                    . "id = :id_publicacion");
    $consulta->bindParam(":id_publicacion", $idPublicacion);
    $consulta->execute();
    
}
function getNumeroDeVisitas($idPublicacion){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT visitas FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);

    $salida =  $publicaciones["visitas"];  
    return $salida;
}

function getPublicacion($idPublicacion){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);

   
    return $publicaciones;
}

function getNumeroDePublicaciones(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = count($publicaciones);  
    return $salida;
}

function getNumeroDePublicacionesVideo(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "WHERE tipo_documento = 1");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = count($publicaciones);  
    return $salida;
}
function getIDsTodasPublicacionesVideo(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "WHERE tipo_documento = 1");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = $publicaciones;  
    return $salida;
}
function getIDsTodasPublicacionesPDF(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "WHERE tipo_documento = 2");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = $publicaciones;  
    return $salida;
}
function getIDsTodasPublicaciones(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = $publicaciones;  
    return $salida;
}

function getNumeroDePublicacionesPDF(){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT id FROM web.db_publicaciones "
            . "WHERE tipo_documento = 2");
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();

    $salida = count($publicaciones);  
    return $salida;
}


function getDirPublicacion($idPublicacion){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT dir FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);

    $salida =  $publicaciones["dir"];  
    return $salida;
}
function getRespuestaPublicacion($idPublicacion){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT respuesta FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);

    $salida =  $publicaciones["respuesta"];  
    return $salida;
}

function getDificultadPublicacion($idPublicacion){
    global $pdo;
        


    $consulta = $pdo->prepare("SELECT dificultad FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);

    $salida =  $publicaciones["dificultad"];  
    return $salida;
}
function asignarVideoAPublicacion($idPublicacion, $servidor, $identificativo){
    global $pdo;
        
    
        $consulta = $pdo->prepare("INSERT INTO web.db_referencia_videos "
                . "(id_referencia, servidor_video,  identificativo_video) VALUES "
                . "(:id_referencia, :servidor_video,  :identificativo_video)");
        $consulta->bindParam(":id_referencia", $idPublicacion);
        $consulta->bindParam(":servidor_video", $servidor);
        $consulta->bindParam(":identificativo_video", $identificativo);
        $consulta->execute();
        
}
function getNumeroDeComentarios_Publicaciones($id_publicacion){
    global $pdo;

    $consulta = $pdo->prepare("SELECT id FROM web.db_comentarios WHERE "
            . " id_publicacion = :id_publicacion ORDER BY fecha ASC");
    $consulta->bindParam(":id_publicacion", $id_publicacion);
    $consulta->execute();
    $comentarios = $consulta->fetchAll();
    return count($comentarios);
}



function getPublicacionesPendientesDeAutor($autor){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE autor = :autor AND estado = '0' "
            . "ORDER BY fecha_ultima_modificacion DESC");
    $consulta->bindParam(":autor", $autor);
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
}
function getPublicacionesAprobadasDeAutor($autor, $pagina){
    /* 
    global $pdo;
        
       
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE autor = :autor AND estado = '1' "
            . "ORDER BY fecha_ultima_modificacion DESC");
    $consulta->bindParam(":autor", $autor);

    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
    */
    
    
    
    
    
    global $numeroResultadosPorPagina;
    global $pdo;
        
    $inicio = $numeroResultadosPorPagina*($pagina-1);
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE autor = :autor AND estado = 1 ORDER BY fecha_ultima_modificacion DESC LIMIT :inicio, :numres");
    $consulta->bindParam(":autor", $autor);
    $consulta->bindValue(":numres", (int)($numeroResultadosPorPagina), PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    
    $salida = $publicaciones;
    
    
    
    return $salida;
    
    
    
    
}
function getPublicacionAprobadasConIDDeAutor($autor, $id){
    
    global $pdo;
        
       
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE autor = :autor AND estado = 1 AND id = :id "
            . "ORDER BY fecha_ultima_modificacion DESC");
    $consulta->bindParam(":autor", $autor);
    $consulta->bindParam(":id", $id);

    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
    

    
}
function getFechaPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT fecha FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["fecha"];
        
}
function getFechaUltimaModificacionPublicacion($id){
    global $pdo;
    
    $consulta = $pdo->prepare("SELECT fecha_ultima_modificacion FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["fecha_ultima_modificacion"];
        
}


function getTagsPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT tags FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["tags"];
}
function getAutorPublicacion($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT autor FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["autor"];
}
function getCuerpoPublicacion($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT cuerpo FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["cuerpo"];
}
function getTipoDocumentoPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT tipo_documento FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["tipo_documento"];
    
}
function getTipoClasificacionPublicacion($id){
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT tipo_clasificacion FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["tipo_clasificacion"];
}
function getIdMaterialComplementarioPublicacion($id){
    global $pdo;
        

    $consulta = $pdo->prepare("SELECT id_material_complementario FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["id_material_complementario"];
}
function getAyudasALaBusquedaPublicacion($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT ayuda_busqueda FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["ayuda_busqueda"];
}
function convertirHTMLenTextoPlano($html){
    $salida = htmlspecialchars( nl2br($html));
    $salida = str_replace("&lt;br /&gt;", " <br> ", $salida);
    return $salida;
}
function getReferenciasPublicacion($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT referencias FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["referencias"];
}


function subirImagenesDeFoolder($texto, $nivel){
    //metes un html con etiquetas <img src="dir1/dir2/img.jpg">
    // y te devuelve las etiquetas como <img src="../dir1/dir2/img.jpg">
    
    $imagenes = array();
    preg_match_all('/<img[^>]+>/i',$texto, $imagenes);
    $salida = $texto;
    
    $subidas ="";
    for($i=0; $i<$nivel; $i++){
        $subidas .= "../";
    }
    
    
    for($i=0; $i<count($imagenes[0]); $i++){
        
        $img_tag = $imagenes[0][$i];
        
        $doc = new DOMDocument();
        $doc->loadHTML($img_tag);
        
        $xpath = new DOMXPath($doc);
        
        
        $src = $xpath->evaluate("string(//img/@src)");
        
        $salida = str_replace($src, "$subidas$src", $salida);
        
        
    }
    
    return $salida;
    
}


function getTituloPublicacion($id){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT titulo FROM web.db_publicaciones "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    return $publicaciones["titulo"];
}

function getPublicaciones($usuario, $pagina){
    global $numeroResultadosPorPagina;
    global $pdo;
        
    $inicio = $numeroResultadosPorPagina*($pagina-1);
    
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones "
            . "WHERE estado=1 ORDER BY fecha DESC LIMIT :inicio, :numres");
    $consulta->bindValue(":numres", (int)($numeroResultadosPorPagina+1), PDO::PARAM_INT);
    $consulta->bindValue(":inicio", (int)$inicio, PDO::PARAM_INT);
    
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    
    $salida = $publicaciones;
    
    
    
    return $salida;
    
}

function comprobarSiPublicacionGuardadaParaMasTarde($usuario, $idPublicacion){
    global $pdo;
    
    if($usuario==null){
        return false;
    }else{
        $consulta = $pdo->prepare("SELECT * FROM web.db_guardar_para_mas_tarde "
                . "WHERE usuario = :usuario AND id_publicacion = :id_publicacion");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id_publicacion", $idPublicacion);
        
        $consulta->execute();
        $encontrados = $consulta->fetchAll();
        if(count($encontrados)==1){
            return true;
        }else{
            return false;
        }
    }
}
function guardarParaMasTarde($usuario, $idPublicacion){
    
    global $pdo;
    $consulta = $pdo->prepare("SELECT * FROM web.db_guardar_para_mas_tarde "
            . "WHERE usuario = :usuario AND id_publicacion = :id_publicacion");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id_publicacion", $idPublicacion);

    $consulta->execute();
    $encontrados = $consulta->fetchAll();

    if(count($encontrados)==1){
        //existe

        $id = $encontrados[0]["id"];

        $consulta = $pdo->prepare("DELETE FROM web.db_guardar_para_mas_tarde WHERE "
                . "id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        return false;


    }else{
        //no existe

        $consulta = $pdo->prepare("INSERT INTO web.db_guardar_para_mas_tarde "
                . "(usuario,  id_publicacion,  fecha) VALUES "
                . "(:usuario,  :id_publicacion,  now())");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id_publicacion", $idPublicacion);
        $consulta->execute();
        return true;

    }


}


function comprobarSiUsuarioHaRealizadoPublicacion($usuario, $idPublicacion){
    
    
    global $pdo;
        
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones_realizadas WHERE "
            . "( usuario = :usuario AND id_publicacion = :id )");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();
    $salida = false;


    if(count($respuesta)==0){
        $salida = false;

    }else{
         $salida = true;

    }

    return $salida;
}

function marcarRealizadaPublicacion($usuario, $idPublicacion){
    
    
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_publicaciones_realizadas WHERE "
            . "( usuario = :usuario AND id_publicacion = :id )");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
    $respuesta = $consulta->fetchAll();



    if(count($respuesta)==0){
        //creamos la entrada

        $consulta = $pdo->prepare("INSERT INTO web.db_publicaciones_realizadas "
            . "(usuario, id_publicacion, fecha) VALUES "
            . "(:usuario, :id,  now())");
        $consulta->bindParam(":usuario", $usuario);
        $consulta->bindParam(":id", $idPublicacion);
        $consulta->execute();
        
        addPublicacionRealizadaMuro($usuario, $idPublicacion);
        
        return true;

    }else{
        
        
        //actualizamos la entrada
        $id = $respuesta[0]["id"];

        $consulta = $pdo->prepare("DELETE FROM web.db_publicaciones_realizadas WHERE "
                . "id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        
        deletePublicacionRealizadaMuro($usuario, $idPublicacion);
        
        return false;

    }

        
}
function desmarcarRealizadaPublicacion($usuario, $idPublicacion){
    
    global $pdo;

    $consulta = $pdo->prepare("UPDATE web.db_publicaciones_realizadas "
            . "SET estado = 0 WHERE "
            . "usuario = :usuario AND id_publicacion = :id");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":id", $idPublicacion);
    $consulta->execute();
   
}

