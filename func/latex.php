<?php



function previsualizarLatex($texto){
    
    global $pdo;
    $text = $texto;
    $sentencias = getTextoEntreTagsLatex($text);
    
    
    
    for($i=0; $i<count($sentencias[0]); $i++){
        
        
        $formula = $sentencias[1][$i];
        $centrado = substr($formula, 0,1);
        
        
        if($centrado == "c"){  //introducir OR para todas las opciones que queramos introducir
            $formula = substr($formula, 1, strlen($formula)-1);
            
        }
        
        $formula = str_replace(" ", "&space;", $formula);
          
    //$url = 'http://s.wordpress.com/latex.php?latex='. $formula . '&bg=ffffff&fg=000000&s=0';
        $url = 'http://latex.codecogs.com/gif.latex?'. $formula . '';
        
        if($centrado == "c"){
            $reemplazar = '<img style="vertical-align:middle;" src="'. $url . '">';
        }else{
            $reemplazar = '<img style="" src="'. $url . '">';
        }
        
        $formula = $sentencias[0][$i];
        $text = str_replace($formula, $reemplazar, $text);
        
    }
    
    
  
    return $text;
}
function sustituirImagenesPorLatex($texto){
    
    global $pdo;
   
    
    preg_match_all('/<img[^>]+>/i',$texto, $imagenes); 
    
   
    $text = $texto;
    
    
    for($i=0; $i<count($imagenes[0]); $i++){
        $imagen = $imagenes[0][$i];
        
        $doc = new DOMDocument();
        $doc->loadHTML($imagen);
        $xpath = new DOMXPath($doc);
        $src = $xpath->evaluate("string(//img/@src)"); 
        
        
        $file = basename($src, ".gif");
        
        $consulta = $pdo->prepare("SELECT formula FROM web.db_imagenes_latex "
                . "WHERE id = :id");
        $consulta->bindParam(":id", $file);
        $consulta->execute(); 
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
        $formula = $resultado["formula"];
       
        $formula = str_replace("&space;", " ", $formula);
        
        $formula = "[latex]" . $formula . "[/latex]";
        
        
        
        //$formula = $sentencias[0][$i];
        //$reemplazar = '<img style="vertical-align:middle;" src="images/latex/' . $id . '.gif">';
        $text = str_replace($imagen, $formula, $text);
        

    }
    
  
    return $text;
    
}
function sustituirLatexPorImagenes($texto){
    
    global $pdo;
   
    $text = $texto;
    $sentencias = getTextoEntreTagsLatex($text);

    
    for($i=0; $i<count($sentencias[0]); $i++){
        $formula1 = $sentencias[1][$i];
        
        $centrado = substr($formula1, 0,1);
        $formula = $formula1;
        if($centrado == "c"){  //introducir OR para todas las opciones que queramos introducir
            $formula = substr($formula1, 1, strlen($formula1)-1);
        }
        
        $formula = str_replace(" ", "&space;", $formula);
        $formula1 = str_replace(" ", "&space;", $formula1);
        $consulta = $pdo->prepare("SELECT * FROM web.db_imagenes_latex "
                . "WHERE BINARY formula = :formula");
        $consulta->bindParam(":formula", $formula1);
        $consulta->execute(); 
        $resultados = $consulta->fetchAll();
        
        //si ya existe tomamos la id existente
        if(count($resultados)>=1){
            $id = $resultados[0]["id"];
        }else{ //si no existe creamos una nueva entrada
            $consulta = $pdo->prepare("INSERT INTO web.db_imagenes_latex "
             . "(formula) VALUES "
             . "(:formula)");
            
            $consulta->bindParam(":formula", $formula1);
            $consulta->execute(); 
       
            $id = $pdo->lastInsertId("id");
            
            //guardamos la imagen en nuestroservidor
            
            //$url = 'http://s.wordpress.com/latex.php?latex='. $formula . '&bg=ffffff&fg=000000&s=0';
            $url = 'http://latex.codecogs.com/gif.latex?'. $formula . '';
            $img = '../images/latex/' . $id . ".gif";
            file_put_contents($img, file_get_contents($url));
            
        }
        $formula = $sentencias[0][$i];
        if($centrado == "c"){
            $reemplazar = '<img style="vertical-align:middle;" src="images/latex/' . $id . '.gif">';
            
        }else{
            $reemplazar = '<img style="" src="images/latex/' . $id . '.gif">';
        }
        
        $text = str_replace($formula, $reemplazar, $text);

    }
    
  
    return $text;
    
}
function getCodigoCompletoLatex($formula){
    $salida = '

        \documentclass{article}

        \pagestyle{empty}

        \begin{document}

         $ ' . $formula . ' $

        \end{document}


        ';
    return $salida;
}
function getTextoEntreTagsHtml($texto, $tag){
    $pattern = "/<$tag>(.*?)<\/$tag>/";
    preg_match($pattern, $texto, $encontrados);
    return $encontrados[1];
 }
function getTextoEntreTagsLatex($texto){
    $pattern = "/\[latex\](.*?)\[\/latex\]/";
    preg_match_all($pattern, $texto, $encontrados);
    return $encontrados;
 }
function getTextoEntreComas($texto){
    $encontrados = explode(',', $texto);
    return $encontrados;
 }
