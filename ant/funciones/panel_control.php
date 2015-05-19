<?php

function getRegla($num){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT estado FROM web.db_panel_control "
            . "WHERE id = :num");
    $consulta->bindParam(":num", $num);
    $consulta->execute();
    $publicaciones = $consulta->fetch(PDO::FETCH_ASSOC);
    
    return $publicaciones["estado"];
}

function getReglas(){
    global $pdo;
        
    $consulta = $pdo->prepare("SELECT * FROM web.db_panel_control "
            . "");
    
    $consulta->execute();
    $publicaciones = $consulta->fetchAll();
    return $publicaciones;
}

function actualizarRegla ($id, $estado){
    global $pdo;
       
        
    $consulta = $pdo->prepare("UPDATE web.db_panel_control "
            . "SET estado = :estado "
            . "WHERE id = :id");
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":estado", $estado);


    $consulta->execute();

        
}