<?php

function getScriptOverText($pagina){
    $salida = '$(document).ready(function() {
        
        $(\'.masterTooltip'. $pagina .'\').hover(function(){
                var title = $(this).attr(\'title\');
                
                $(this).data(\'tipText\', title).removeAttr(\'title\');
                $(\'<p class="tooltip"></p>\')
                .text(title)
                .appendTo(\'body\')
                .fadeIn(\'slow\');
        }, function() {
                $(this).attr(\'title\', $(this).data(\'tipText\'));
                $(\'.tooltip\').remove();
        }).mousemove(function(e) {
               
                var x = $(this).offset().left - ($(\'.tooltip\').width() - $(this).width())/2;
                var y = $(this).offset().top - $(\'.tooltip\').height() -8 ; 
                
                $(\'.tooltip\')
                .css({ top: y, left: x});
        });
    });';
    
    return $salida;
}


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


function getFechaFormatoClaro($fecha){
    $dias = array("", "Lunes","Martes","Miércoles","Jueves","Viernes","Sábado", "Domingo");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
    $date = date_create($fecha);
    
    $dia = $date->format("d");
    $ano = $date->format("Y");
    $diaSemana = $date->format("N");
    $mes = $date->format("m");
    $salida = $dias[$diaSemana]." ". $dia ." de ".$meses[$mes-1]. " del ".$ano ;
    //return $date->format('Y-m-d');
    return $salida;
    
}
function getFechaYHoraFormatoClaro($fecha){
    $dias = array("", "Lunes","Martes","Miércoles","Jueves","Viernes","Sábado", "Domingo");
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $date = date_create($fecha);
    
    $min = $date->format("i");
    $hora = $date->format("H");
    $dia = $date->format("d");
    $ano = $date->format("Y");
    $diaSemana = $date->format("N");
    $mes = $date->format("m");
    $salida = $hora . ":" . $min . " " . $dias[$diaSemana]." ". $dia ." de ".$meses[$mes-1]. " del ".$ano;
    //return $date->format('Y-m-d');
    return $salida;
    
}