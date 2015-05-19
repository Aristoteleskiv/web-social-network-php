<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function actualizarFechaUltimaVisita($usuario){
    global $pdo;
        
    $consulta = $pdo->prepare("UPDATE web.db_usuarios "
            . "SET fecha_ultima_visita = now() "
            . "WHERE usuario = :usuario");
    $consulta->bindParam(":usuario", $usuario);
    $consulta->execute();
    
    
}