<?php


include_once '../config/configuracion.php';
include_once '../funciones/encuestas.php';
include_once '../funciones/grupos.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        $id = $_POST["id"];
        $votosTotales = getNumeroDeVotosEncuesta($id);
        $titulo = getTituloEncuesta($id);
        $usuarios = getCampoUsuariosEncuesta($id);
        $usuariosArray = getTodosUsuariosDeGrupoConCampo($usuarios);
        $vectorResultados = getResultadosVotacionEncuesta($id);
        $vistas = getVistasEncuesta($id);

        $opciones = getOpcionesEncuesta($id);
        $vectorOpciones = explode("\n", $opciones);
        $vectorPorcentaje = array();

        for($i=0; $i<count($vectorResultados); $i++){
            $vectorPorcentaje[$i] =  (int)($vectorResultados[$i]*100/$votosTotales);

        }

        echo "<br>Estadisticas de encuesta '$titulo'<br><br>";
        echo "Usuarios en rango: ". count($usuariosArray) .  "<br>";
        echo 'Usuarios que han visto la encuesta: ' . $vistas . ' ('. (int)($vistas*100/count($usuariosArray)) . '%)<br>';
        echo 'Usuarios que han votado: ' . $votosTotales . ' ('. (int)($votosTotales*100/count($usuariosArray)) . '%)<br>';



        echo "<table><tr><td><b>Opcion</b></td><td><b>Votos</b></td><td><b>%</b></td></tr>";

        for($i=0; $i<count($vectorResultados); $i++){
            echo '<tr><td>'  . $vectorOpciones[$i] .  '</td><td align="center">'. $vectorResultados[$i] . "</td><td>$vectorPorcentaje[$i]</td></tr>";
        }


        echo "</table>";
    }


            
    
}else{
    echo '<script>document.location="index.php"</script>';
}
