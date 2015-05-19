<?php




function registrarSeguimientoIp($usuario, $ip){
    
    global $pdo;
    global $ApiKeySeguimiento;
    $key = $ApiKeySeguimiento;
    if($ip=="127.0.0.1"){$ip="83.58.158.139";}
    //$details = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=$key&ip=$ip&format=json"));
    
    //$countryName = $details->countryName; 
    //$countryCode = $details->countryCode;
    //$regionName = $details->regionName; 
    //$cityName = $details->cityName; 
    //$zipCode = $details->zipCode; 
    //$latitude = $details->latitude; 
    //$longitude = $details->longitude; 
    //$timeZone = $details->timeZone; 
    
    
    
    //$consulta = $pdo->prepare("INSERT INTO web.db_seguimiento "
    //. "(usuario, ip, fecha, country_code, country_name, region_name, city_name, zip_code, latitude, longitude, timezone) VALUES "
    //. "(:usuario, :ip, now(), :country_code, :country_name, :region_name, :city_name, :zip_code, :latitude, :longitude, :timezone)");
    
    //$consulta->bindParam(":usuario", $usuario);
    //$consulta->bindParam(":ip", $ip);
    //$consulta->bindParam(":country_code", $countryCode);
    //$consulta->bindParam(":country_name", $countryName);
    //$consulta->bindParam(":region_name", $regionName);
    //$consulta->bindParam(":city_name", $cityName);
    //$consulta->bindParam(":zip_code", $zipCode);
    //$consulta->bindParam(":latitude", $latitude);
    //$consulta->bindParam(":longitude", $longitude);
    //$consulta->bindParam(":timezone", $timeZone);
    $consulta = $pdo->prepare("INSERT INTO web.db_seguimiento_ip "
    . "(usuario, ip, fecha) VALUES "
    . "(:usuario, :ip, now())");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":ip", $ip);
    $consulta->execute();

    
    
    
}



function registrarSeguimiento($usuario, $estancia, $anterior, $accion, $exito=null){
    
    global $pdo;
    $consulta = $pdo->prepare("INSERT INTO web.db_seguimiento_usuario "
    . "(usuario, estancia, anterior, accion, exito, fecha) VALUES "
    . "(:usuario, :estancia, :anterior, :accion, :exito, now())");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->bindParam(":anterior", $anterior);
    $consulta->bindParam(":estancia", $estancia);
    $consulta->bindParam(":accion", $accion);
    $consulta->bindParam(":exito", $exito);
    $consulta->execute();
    
    session_start();
    $_SESSION["acc"]=null;
    $_SESSION["exi"]=null;
}