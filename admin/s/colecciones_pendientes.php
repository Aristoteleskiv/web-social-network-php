<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/colecciones.php';
include_once '../../func/usuario.php';


if($usuario==null){
    echo codigoRedireccionHome($nivel);
}
?>


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>

    </head>
    <body>
        <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
        
            
            <div id="vertical">
                <aside id="menu">
                
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>

                <section id="contenido">
                    <?php
                    if(getNivelUsuario($usuario)<3){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                            
                        <div class="div-contenido">
                            <h1>Colecciones pendientes</h1>


                            <div id="div-contenido-no-titulo">
                                <br>
                                <div onclick="window.location='form/coleccion.php?p=1&a=p'" class="div-boton-estandar">Crear nueva coleccion</div>
                                <table width="100%">
                            <tr>
                                    <td width="16"><b>ID</b></td>
                                    <td><b>Nombre</b></td>
                                    <td><b>Descripcion</b></td>
                                    <td><b>Coleccion de</b></td>
                                    <td><b>Referencias</b></td>

                                    <td width="20"><b>Imagen</b></td>
                                    <td width="20"><b>Aprobar</b></td>
                                    <td width="20"><b>Eliminar</b></td>
                            </tr>
                            <?php 



                            $ant = "p";

                            $colecciones = getColeccionesPendientes($usuario);




                            $ic= '<img src="../../images/header/correcto.png" width="20" height="20">';
                            $ii= '<img src="../../images/header/incorrecto.png" width="20" height="20">';

                            echo '<script>
                                    function aprobar(id){

                                        $.ajax({
                                                type: "POST",
                                                url: "../../acc/enviar_coleccion.php?id="+id+"&p=8&a='. $ant .'",
                                                data: "",
                                                success: function(msg){
                                                    window.location=\'colecciones_pendientes.php\'

                                                }
                                            });
                                        return false;
                                        }
                                    function eliminar(id){
                                    if (confirm("Estas seguro de eliminar la publicacion?")) {
                                        $.ajax({
                                                type: "POST",
                                                url: "../../acc/enviar_coleccion.php?id="+id+"&p=10&a='. $ant .'",
                                                data: "",
                                                success: function(msg){
                                                    window.location=\'colecciones_pendientes.php\'
                                                }
                                            });
                                        return false;
                                        }
                                        }
                                    </script>
                                    ';

                            for($i=0; $i<count($colecciones); $i++){
                                $id = $colecciones[$i]["id"];



                                $nombre = $colecciones[$i]["nombre"];

                                $iNombre = '<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=2&a='. $ant .'\'"  id="iNombre'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                $descripcion = $colecciones[$i]["descripcion"];
                                if($descripcion==null){
                                    $iDescripcion = $ii .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=3&a='. $ant .'\'" id="iDescripcion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iDescripcion = $ic .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=3&a='. $ant .'\'" id="iDescripcion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }

                                $imagen = $colecciones[$i]["imagen"];
                                if($imagen==null){
                                    $iImagen = $ii .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=4&a='. $ant .'\'" id="iImagen'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iImagen = $ic .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=4&a='. $ant .'\'" id="iImagen'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }




                                $formEnviar = '

                                        <form>
                                        <input onclick="javascript:aprobar('. $id .'); return false;" type="submit" value="aprobar">                    </form>

                                            ';
                                $formEliminar = '

                                        <form>
                                        <input onclick="javascript:eliminar('. $id . '); return false;" type="submit" value="eliminar">
                                        </form>

                                            ';
                                $referencias = $colecciones[$i]["ref"];

                                if($referencias==null){
                                    $iRef = $ii .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=6&a='. $ant .'\'" id="iRef'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iRef = $ic .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=6&a='. $ant .'\'" id="iRef'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }

                                $coleccion = $colecciones[$i]["coleccion"];

                                if($coleccion==null){
                                    $iCol = $ii .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=5&a='. $ant .'\'" id="iCol'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iCol = $ic .'<img onclick="window.location=\'form/coleccion.php?id='. $id . '&p=5&a='. $ant .'\'" id="iCol'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }
                                if($coleccion==1){
                                    $coleccion = "Publicaciones";
                                }
                                if($coleccion==2){
                                    $coleccion = "Colecciones";
                                }


                                echo '<tr><td>'. $id.'</td>
                                    <td>'. $nombre . $iNombre . '</td>
                                    <td>'. $descripcion . $iDescripcion . '</td>

                                    <td>'. $coleccion . $iCol . '</td>
                                    <td>'. $referencias . $iRef . '</td>

                                    <td>'. $iImagen . '</td>
                                    <td>'. $formEnviar . '</td>
                                    <td>'. $formEliminar . '</td>
                                    </tr>
                                    ';
                            }

                            ?>

                            </table>



                            <br>
                            <br>

                            </div>
                        </div>
                    
                        <?php
                    }
                    ?>
                    
                <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
                
            </div>
        
        
        <div>
            <?php echo getScrolls($nivel); ?>
        </div>
        
        
    </body>

