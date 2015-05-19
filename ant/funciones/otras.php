<?php

function numeroAleatorio($longitud = 32) {
    
    $salida = '';

    for($i = 0; $i < $longitud; $i++) {
        $salida .= mt_rand(0, 9);
    }

    return $salida;
}

function cadenaAleatoria($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}