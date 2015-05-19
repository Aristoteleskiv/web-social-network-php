<?php


function comprobarCookieMantenerConectado($hash){
    global $pdo;
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_cookies_mantener_conectado "
                . "WHERE hash=:hash");
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["usuario"];
    
}


function eliminarCookieMantenerConectado($usuario){
    global $pdo;
    global $nomCookieMantenerConectado;
    $consulta = $pdo->prepare("DELETE FROM web.db_cookies_mantener_conectado "
       . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    setcookie($nomCookieMantenerConectado, " ", time() -1, '/');
    
}


function crearCookieMantenerConectado($usuario){
    
    $salida = array("1");
    $ip = $_SERVER['REMOTE_ADDR'];
    global $pdo;
    global $nomCookieMantenerConectado;
    
    
    
    $consulta = $pdo->prepare("DELETE FROM web.db_cookies_mantener_conectado "
       . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
    $contador = 0;
    a: while (count($salida)!=0){ 
        $hash = cadenaAleatoria();

        $consulta = $pdo->prepare("SELECT id FROM web.db_cookies_mantener_conectado "
                . "WHERE hash=:hash");
        $consulta->bindParam(":hash", $hash);
        $consulta->execute();
        $salida = $consulta->fetchAll();
        $contador++;
        if($contador>1000){
            break a;
        }
    }
    
    $consulta = $pdo->prepare("INSERT INTO web.db_cookies_mantener_conectado "
    . "(ip, fecha, usuario, hash) VALUES "
    . "(:ip, now(), :usuario, :hash)");
    
        $consulta->bindParam(":hash", $hash);
        $consulta->bindParam(":ip", $ip);
        $consulta->bindParam(":usuario", $usuario);
        $consulta->execute();
    
    setcookie($nomCookieMantenerConectado, $hash, time() + (20*365*24*3600), '/');
    
  
    
    
}





function comprobarCookieAceptarCookies($hash){
    global $pdo;
    $consulta = $pdo->prepare("SELECT usuario FROM web.db_cookies_aceptar_cookies "
                . "WHERE hash=:hash");
    $consulta->bindParam(":hash", $hash);
    $consulta->execute();
    $salida = $consulta->fetch(PDO::FETCH_ASSOC);
    return $salida["usuario"];
    
}
function crearCookieAceptarCookies($usuario){
    
    $salida = array("1");
    $ip = $_SERVER['REMOTE_ADDR'];
    global $pdo;
    global $nomCookieAceptarCookies;
    
    
    
    $consulta = $pdo->prepare("DELETE FROM web.db_cookies_aceptar_cookies "
       . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
    $contador = 0;
    a: while (count($salida)!=0){ 
        $hash = cadenaAleatoria();
        
        $consulta = $pdo->prepare("SELECT id FROM web.db_cookies_aceptar_cookies "
                . "WHERE hash=:hash");
        $consulta->bindParam(":hash", $hash);
        $consulta->execute();
        $salida = $consulta->fetchAll();
        $contador++;
        if($contador>1000){
            break a;
        }
    }
    
    $consulta = $pdo->prepare("INSERT INTO web.db_cookies_aceptar_cookies "
    . "(ip, fecha, usuario, hash) VALUES "
    . "(:ip, now(), :usuario, :hash)");
    
    $consulta->bindParam(":hash", $hash);
    $consulta->bindParam(":ip", $ip);
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    setcookie($nomCookieAceptarCookies, $hash, time() + (15*24*3600), '/');
    
    
}