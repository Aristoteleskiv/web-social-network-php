<?php


include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/usuario.php';




session_start();


if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        $nombre = $_POST["nombre"];
        $dir = '../images/pdf/img';

        $empiezan = $nombre . '_';

        $salida = "";      
        $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);


        //ordenamos por nombre
        sort($imagenes, SORT_ASC);



        $descarga = '<a  class="descarga" href="pdf/'. $nombre . '.pdf" TARGET="_blank">Descargar PDF</a>';
        echo $descarga;
    
        echo '<table>'; 


        for($i=0; $i<count($imagenes); $i++){
            $nombre = $imagenes[$i];
            $salida .= '

                <tr>
                    <td colspan="5"><img width="550" border="1" src="images/pdf/img/'. $nombre . '"></td>
                </tr>';
        }
        echo $salida;
        echo '</table>';
    }
    
}else{
    echo '<script>document.location="index.php"</script>';
}








//$imagen = '<img width="500" border="1" src="pdf/img/'. $nombre . '/'. $nombre . '.jpg">';



//echo $imagen . '<br>' . $descarga;