<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/encuestas.php';
include_once '../../func/usuario.php';
include_once '../../func/grupos.php';

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
                            <h1>Encuestas pendientes</h1>


                            <div id="div-contenido-no-titulo">
                                <br>
                                <div onclick="window.location='form/encuesta.php?p=1'" class="div-boton-estandar">Crear nueva encuesta</div>
                                <table width="100%">
                                <tr>
                                        <td width="16"><b>ID</b></td>
                                        <td width="46"><b>Titulo</b></td>
                                        <td width="689"><b>Cuerpo</b></td>
                                        <td  width="20"><b>Usuarios</b></td>
                                        <td width="37"><b>Tipo</b></td>
                                        <td><b>Opciones</b></td>
                                        <td width="64"><b>Aprobar</b></td>
                                        <td width="64"><b>Eliminar</b></td>
                                </tr>
                                <?php 


                                $encuestas = getEncuestasPendientes();




                                $ic= '<img src="../../images/header/correcto.png" width="20" height="20">';
                                $ii= '<img src="../../images/header/incorrecto.png" width="20" height="20">';

                                echo '<script>
                                        function desaprobar(id){

                                            $.ajax({
                                                    type: "POST",
                                                    url: "../../acc/enviar_encuesta.php?id="+id+"&p=11",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'encuestas.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                        function aprobar(id){

                                            $.ajax({
                                                    type: "POST",
                                                    url: "../../acc/enviar_encuesta.php?id="+id+"&p=10",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'encuestas.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                        function eliminar(id){
                                        if (confirm("Estas seguro de eliminar la publicacion?")) {
                                            $.ajax({
                                                    type: "POST",
                                                    url: "../../acc/enviar_encuesta.php?id="+id+"&p=12",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'encuestas.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                            }
                                        function previsualizar(id){
                                                $.ajax({
                                                        type: "POST",
                                                        url: "../../datos/previsualizar_encuesta.php?id="+id,
                                                        data: "",
                                                        success: function(msg){
                                                             $("#divPrevisualizarEncuesta").html(msg);
                                                        }
                                                    });
                                            return false;

                                            }
                                        </script>
                                        ';

                                for($i=0; $i<count($encuestas); $i++){
                                    $id = $encuestas[$i]["id"];



                                    $titulo = $encuestas[$i]["titulo"];

                                    $iTitulo = '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=2&\'" id="iTitulo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                    $cuerpo = nl2br($encuestas[$i]["cuerpo"]);
                                    if($cuerpo==null){
                                        $iCuerpo = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=3&\'" id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iCuerpo = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=3&\'" id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $usuarios = $encuestas[$i]["usuarios"];
                                    if($usuarios==null){
                                        $iUsuarios = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=4&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iUsuarios = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=4&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }


                                    $tipo = $encuestas[$i]["tipo"];
                                    switch ($tipo) {
                                        case 1:
                                            $tipo1="Si/No";

                                            break;
                                        case 2:
                                            $tipo1="Varias respuestas";

                                            break;
                                        case 3:
                                            $tipo1="0/10";

                                            break;

                                        default:
                                            break;
                                    }

                                    if($tipo==null){
                                        $iTipo = $ii . '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iTipo =  $tipo1 . '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $opciones = nl2br($encuestas[$i]["opciones"]);
                                    if($opciones==null){
                                        $iOpciones = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=6&\'" id="iOpciones'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iOpciones = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=6&\'" id="iOpciones'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
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


                                    echo '<tr><td>'. $id.'</td>
                                        <td>'. $titulo . $iTitulo . '</td>
                                        <td>'. $cuerpo. $iCuerpo . '</td>
                                        <td>'. $iUsuarios . '</td>
                                        <td>'. $iTipo . '</td>
                                        <td>'. $iOpciones . '</td>
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


                                 <h1>Encuestas aprobadas</h1>


                                    <div id="div-contenido-no-titulo">
                                        <br>

                                        <table width="100%">
                                <tr>
                                        <td width="16"><b>ID</b></td>
                                        <td width="46"><b>Titulo</b></td>
                                        <td width="689"><b>Cuerpo</b></td>
                                        <td  width="20"><b>Usuarios</b></td>
                                        <td width="37"><b>Tipo</b></td>
                                        <td><b>Opciones</b></td>
                                        <td><b>%</b></td>
                                        <td width="64"><b>Aprobar</b></td>
                                        <td width="64"><b>Eliminar</b></td>
                                </tr>
                                <?php 


                                $encuestas = getEncuestasAprobadas();


                                for($i=0; $i<count($encuestas); $i++){
                                    $id = $encuestas[$i]["id"];



                                    $titulo = $encuestas[$i]["titulo"];

                                    $iTitulo = '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=2&\'" id="iTitulo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                    $cuerpo = nl2br($encuestas[$i]["cuerpo"]);
                                    if($cuerpo==null){
                                        $iCuerpo = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=3&\'" id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iCuerpo = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=3&\'" id="iCuerpo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $usuarios = $encuestas[$i]["usuarios"];
                                    if($usuarios==null){
                                        $iUsuarios = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=4&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iUsuarios = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=4&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }


                                    $tipo = $encuestas[$i]["tipo"];
                                    switch ($tipo) {
                                        case 1:
                                            $tipo1="Si/No";

                                            break;
                                        case 2:
                                            $tipo1="Varias respuestas";

                                            break;
                                        case 3:
                                            $tipo1="0/10";

                                            break;

                                        default:
                                            break;
                                    }

                                    if($tipo==null){
                                        $iTipo = $ii . '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iTipo =  $tipo1 . '<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $opciones = nl2br($encuestas[$i]["opciones"]);
                                    if($opciones==null){
                                        $iOpciones = $ii .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=6&\'" id="iOpciones'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iOpciones = $ic .'<img onclick="window.location=\'form/encuesta.php?id='. $id . '&p=6&\'" id="iOpciones'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }



                                    $formEnviar = '

                                            <form>
                                            <input onclick="javascript:desaprobar('. $id .'); return false;" type="submit" value="desaprobar">
                                            </form>

                                                ';
                                    $formEliminar = '

                                            <form>
                                            <input onclick="javascript:eliminar('. $id . '); return false;" type="submit" value="eliminar">
                                            </form>

                                                ';
                                     $porcentaje ='

                                            <form>
                                            <input onclick="javascript:previsualizar('. $id . '); return false;" type="submit" value="ver">
                                            </form>


                                            ';

                                    echo '<tr><td>'. $id.'</td>
                                        <td>'. $titulo . $iTitulo . '</td>
                                        <td>'. $cuerpo. $iCuerpo . '</td>
                                        <td>'. $iUsuarios . '</td>
                                        <td>'. $iTipo . '</td>
                                        <td>'. $iOpciones . '</td>
                                        <td> '. $porcentaje . '</td>
                                        <td>'. $formEnviar . '</td>
                                        <td>'. $formEliminar . '</td>
                                        </tr>
                                        ';
                                }

                                ?>

                                </table>



                                <br>
                                <br>
                                <div id="divPrevisualizarEncuesta">

                                </div>
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
