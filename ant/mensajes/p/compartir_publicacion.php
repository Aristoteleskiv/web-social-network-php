<?php



$publicacion = $_POST["p"];
$salida = 'Copia donde quieras esta URL para acceder directamente a esta publicación<input type="text" style="text-align: center; font-family: \'Open Sans\' , sans-serif; color: #000; width: 400px; height: 20px;" value = "http://seistemas.com/?r=3&p='. $publicacion  . '">';
echo $salida;
    
    