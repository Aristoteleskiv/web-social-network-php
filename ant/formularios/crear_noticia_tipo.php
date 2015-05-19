<!DOCTYPE html>

<?php


include_once '../config/configuracion.php';
include_once '../funciones/noticias.php';
include_once '../funciones/usuario.php';




session_start();


if(isset($_SESSION["usr"]) AND getNivelUsuario($_SESSION["usr"]) == 3  ){
    
    $usuario = $_SESSION["usr"];
    $tipo = $_POST["tipo"];
    $id = $_POST["id"];
    
    
    
    
    
        
    $ano1 = getAnoFecha1Noticia($id);
    
    if($ano1 != null){
        $ano2 = getAnoFecha2Noticia($id);

        $mes1 = getMesFecha1Noticia($id);
        $mes2 = getMesFecha2Noticia($id);

        $dia1= getDiaFecha1Noticia($id);
        $dia2 = getDiaFecha2Noticia($id);

    }else{
        
        $ano1 = date("Y");
        $ano2 = date("Y");

        $mes1 = date("n");
        $mes2 = date("n");

        $dia1= date("j");
        $dia2 = date("j");
        
    }
        
    
    $dias1 = "";
    for($i=1; $i<32; $i++){
        $sel = "";
        if($i==$dia1){$sel = "selected";}
        $dias1 .= '<option '. $sel . ' value="'. $i . '" >'. $i .'</option>';
    }
    $arMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses1 = "";
    for($i=1; $i<13; $i++){
        $sel = "";
        if($i==$mes1){$sel = "selected";}
        $meses1 .= '<option '. $sel . ' value="'. $i . '" >'. $arMeses[$i-1] .'</option>';
    }
    $anos1 = "";
    for($i=2014; $i<2017; $i++){
        $sel = "";
        if($i==$ano1){$sel = "selected";}
        $anos1 .= '<option '. $sel . ' value="'. $i . '" >'. $i .'</option>';
    }  
    
    
    $dias2 = "";
    for($i=1; $i<32; $i++){
        $sel = "";
        if($i==$dia2){$sel = "selected";}
        $dias2 .= '<option '. $sel . ' value="'. $i . '" >'. $i .'</option>';
    }
    
    $meses2 = "";
    for($i=1; $i<13; $i++){
        $sel = "";
        if($i==$mes2){$sel = "selected";}
        $meses2 .= '<option '. $sel . ' value="'. $i . '" >'. $arMeses[$i-1] .'</option>';
    }
    $anos2 = "";
    for($i=2014; $i<2017; $i++){
        $sel = "";
        if($i==$ano2){$sel = "selected";}
        $anos2 .= '<option '. $sel . ' value="'. $i . '" >'. $i .'</option>';
    }  
    
    
    switch ($tipo) {
        case 2:
            $salida = '
                <br>
                Fecha inicio: <br>
                Dia: <select name="dia1" id="dia1">'. $dias1 . '</select>
                Mes: <select name="mes1" id="mes1">'. $meses1 . '</select>
                Año: <select name="ano1" id="ano1">'. $anos1 . '</select>
                <br><br>
                Fecha final: <br>
                Dia: <select name="dia2" id="dia2">'. $dias2 . '</select>
                Mes: <select name="mes2" id="mes2">'. $meses2 . '</select>
                Año: <select name="ano2" id="ano2">'. $anos2 . '</select>
                <br>
                <br>

                ';

            break;

        default:
            break;
    }
    
    echo $salida;

    
}else{
    
    echo '<script>document.location="index.php"</script>';
}

    
 ?>

