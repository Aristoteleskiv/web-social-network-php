<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/publicaciones.php';
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
                        <h1>Publicaciones pendientes</h1>

                        
                        <div id="div-contenido-no-titulo">
                            <br>
                            <div onclick="window.location='form/publicacion.php?p=1&a=p'" class="div-boton-estandar">Crear nueva publicacion</div>
                            <table width="100%">
                            <tr>
                                    <td width="16"><b>ID</b></td>
                                    <td width="689"><b>Titulo</b></td>
                                    <td width="46"><b>Cuerpo</b></td>
                                    <td><b>Ayudas</b></td>
                                    <td width="37"><b>Tipo</b></td>
                                    <td width="45"><b>Video</b></td>
                                    <td width="30"><b>PDF</b></td>
                                    <td width="30"><b>dir</b></td>
                                    <td width="30"><b>dif</b></td>
                                    <td width="30"><b>Enviar</b></td>
                                    <td width="30"><b>Eliminar</b></td>
                            </tr>
                            <?php 

                            $ant = "p";
                            $publicaciones = getPublicacionesPendientesDeAutor($usuario);

                            $ic= '<img src="../../images/header/correcto.png" width="20" height="20">';
                            $ii= '<img src="../../images/header/incorrecto.png" width="20" height="20">';

                            echo '<script>
                                    function aprobar(id){

                                        $.ajax({
                                                type: "POST",
                                                url: "form/acc/enviar_publicacion.php?id="+id+"&p=91&a='. $ant .'",
                                                data: "",
                                                success: function(msg){
                                                    window.location=\'publicaciones_pendientes.php\'

                                                }
                                            });
                                        return false;
                                        }
                                    function eliminar(id){
                                    if (confirm("Estas seguro de eliminar la publicacion?")) {
                                        $.ajax({
                                                type: "POST",
                                                url: "form/acc/enviar_publicacion.php?id="+id+"&p=99&a='. $ant .'",
                                                data: "",
                                                success: function(msg){
                                                    window.location=\'publicaciones_pendientes.php\'

                                                }
                                            });
                                        return false;
                                        }
                                        }
                                    </script>
                                    ';

                            for($i=0; $i<count($publicaciones); $i++){
                                $id = $publicaciones[$i]["id"];



                                $titulo = subirImagenesDeFoolder($publicaciones[$i]["titulo"], $nivel);

                                $iTitulo = '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=2&a='. $ant .'\'" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                $cuerpo = $publicaciones[$i]["cuerpo"];
                                if($cuerpo==null){
                                    $iCuerpo = $ii .'<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=3&a='. $ant .'\'" id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iCuerpo = $ic .'<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=3&a='. $ant .'\'"  id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }

                                $ayuda = $publicaciones[$i]["ayuda_busqueda"];
                                if($ayuda==null){
                                    $iAyuda = $ii .'<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=4&a='. $ant .'\'"  id="iAyuda'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iAyuda = $ic .'<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=4&a='. $ant .'\'"  id="iAyuda'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }

                                $tipo = $publicaciones[$i]["tipo_documento"];
                                switch ($tipo) {
                                    case 1:
                                        $tipo1="video";

                                        break;
                                    case 2:
                                        $tipo1="pdf";

                                        break;
                                    default:
                                        break;
                                }

                                if($tipo==null){
                                    $iTipo = $ii . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=5&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iTipo =  $tipo1 . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=5&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }



                                if($tipo==null){
                                        $iVideo = $ii . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=6&a='. $ant .'\'"  id="iVideo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        $iPdf =  $ii . '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=7&a='. $ant .'\'"  id="iPdf'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{

                                    if($tipo==1){
                                        $pdf = getIdMaterialComplementarioPublicacion($id);
                                        $video = getIDReferenciaVideoPublicacion($id);
                                        if($pdf==0){
                                            $iPdf =  '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=7&a='. $ant .'\'"  id="iPdf'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }else{
                                            $iPdf =  $ic . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=7&a='. $ant .'\'"  id="iPdf'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }

                                        if($video==null){
                                            $iVideo = $ii . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=6&a='. $ant .'\'"  id="iVideo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }else{
                                            $iVideo = $ic . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=6&a='. $ant .'\'"  id="iVideo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }


                                    }else{  //tipo = 2
                                        $pdf = getIDReferenciaPDFPublicacion($id);
                                        $video = getIdMaterialComplementarioPublicacion($id);
                                        if($pdf==null){
                                            $iPdf =  $ii . '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=7&a='. $ant .'\'" id="iPdf'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }else{
                                            $iPdf =  $ic . '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=7&a='. $ant .'\'" id="iPdf'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }
                                        if($video==0){
                                            $iVideo = '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=6&a='. $ant .'\'" id="iVideo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }else{
                                            $iVideo = $ic . '<img  onclick="window.location=\'form/publicacion.php?id='. $id . '&p=6&a='. $ant .'\'" id="iVideo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                        }
                                    }
                                }

                                $dir = $publicaciones[$i]["dir"];


                                if($dir==null){
                                    $iDir = $ii . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=8&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iDir =  $ic . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=8&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }

                                $dif = $publicaciones[$i]["dificultad"];


                                if($dif==null){
                                    $iDif = $ii . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=9&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iDif = $dif . $ic . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=9&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }
                                
                                $respuesta = getRespuestaPublicacion($id);
                                if($respuesta==null){
                                    $iRes =  '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=10&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }else{
                                    $iRes =  $ic . '<img onclick="window.location=\'form/publicacion.php?id='. $id . '&p=10&a='. $ant .'\'"  id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                }


                                $formEnviar = '

                                        <form>
                                        <input onclick="javascript:aprobar('. $id .'); return false;" type="submit" value="aprobar">
                                        </form>

                                            ';
                                $formEliminar = '

                                        <form>
                                        <input onclick="javascript:eliminar('. $id . '); return false;" type="submit" value="eliminar">
                                        </form>

                                            ';


//                                echo '<tr><td>'. $id.'</td>
//                                    <td>'. $titulo . $iTitulo . '</td>
//                                    <td>'. $iCuerpo . '</td>
//                                    <td>'. $iAyuda . '</td>
//                                    <td>'. $iTipo . '</td>
//                                    <td>'. $iVideo . '</td>
//                                    <td>'. $iPdf . '</td>
//                                    <td>'. $iDir . '</td>
//                                    <td>'. $iDif . '</td>    
//                                    <td>'. $formEnviar . '</td>
//                                    <td>'. $formEliminar . '</td>
//                                    </tr>
//                                    ';
                                
                                    echo '<div class="div-contenedor-estandar">
                                            <h2>'.$id.'</h2>
                                            <div style="border: 1px solid #808080">'. $titulo . $iTitulo .'</div>
                                            <div style="border: 1px solid #808080">'. $cuerpo . $iCuerpo .'</div>
                                            <div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">Ayudas:'. $iAyuda .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">'. $iTipo .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">VID:'. $iVideo .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">PDF:'. $iPdf .'</div>
                                            </div>
                                            <div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">Dir:'. $iDir .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">Dif:'. $iDif .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%">Respuesta:'. $iRes .'</div>
                                            <div style="border: 1px solid #808080; display: inline-block; width: 24%; text-align: center">' . $formEnviar . $formEliminar .'</div>
                                            </div>
                                          </div>
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
