<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
//include_once '../func/seguimiento.php';
include_once '../func/cookies.php';



$usuario = $_SESSION["usr"];
if(isset($_COOKIE[$nomCookieMantenerConectado])){
    
    $hash = $_COOKIE[$nomCookieMantenerConectado];
    eliminarCookieMantenerConectado($usuario,$hash);
}

unset($_SESSION["usr"]);


//eliminarCookieMantenerConectado($usuario);

