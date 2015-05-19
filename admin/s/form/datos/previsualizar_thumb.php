<?php


include_once '../../../../conf/conf.php';
include_once '../../../../conf/sesion.php';
include_once '../../../../func/publicaciones.php';
include_once '../../../../func/usuario.php';





//if(isset($_SESSION["usr"]) ){
    
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
        $nombre = $_POST["nombre"];
        $dir = '../images/pdf/img/thumb/';

        $empiezan = $nombre . '_';

        $salida = "";      
        $imagenes = getArchivosDirectorioEmpiezanPor($dir, "jpg", $empiezan);


        //ordenamos por nombre
        sort($imagenes, SORT_ASC);


    
        echo '<table>'; 


        for($i=0; $i<count($imagenes); $i++){
            $nombre = $imagenes[$i];
            $salida .= '

                <tr>
                    <td colspan="5"><img width="550" border="1" src="../../../images/pdf/img/'. $nombre . '"></td>
                </tr>';
        }
        echo $salida;
        echo '</table>';
    }
    
//}else{
//    echo '<script>document.location="index.php"</script>';
//}








//$imagen = '<img width="500" border="1" src="pdf/img/'. $nombre . '/'. $nombre . '.jpg">';



//echo $imagen . '<br>' . $descarga;