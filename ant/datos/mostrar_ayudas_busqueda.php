<?php




include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
session_start();


if(isset($_SESSION["usr"]) ){

$id = $_POST["id"];

echo '
    <b>Ayudas a la busqueda</b><br>A continuacion te mostramos las palabras clave de este ejercicio que
    podras utilizar en el cuadro de busqueda superior para encontrarlo con el fin de que te pueda ser util 
    en proximas busquedas de diferentes ejercicios.<br>
    Ayudas a la busqueda: <b><span style="color: red">' . getAyudasALaBusquedaPublicacion($id) . '</span></b>
    <br><br>   ';
}else{
   echo '<script>document.location="index.php"</script>'; 
}

?>