<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/publicidad.php';
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
                            <h1>Publicidad</h1>


                            <div id="div-contenido-no-titulo">
                                <br>
                                <div onclick="window.location='form/publicidad.php?p=1'" class="div-boton-estandar">Crear nuevo plan</div>
                                <h1>Planes pendientes</h1>
                                                    <table width="100%">
                                <tr>
                                        <td width="16"><b>ID</b></td>
                                        <td width="46"><b>Titulo</b></td>
                                        <td width="689"><b>Usuarios</b></td>
                                        <td  width="20"><b>Accion</b></td>
                                        <td width="37"><b>Publi</b></td>

                                        <td width="64"><b>Aprobar</b></td>
                                        <td width="64"><b>Eliminar</b></td>
                                </tr>
                                <?php 


                                $planes = getPlanesPublicidadPendientes($usuario);




                                $ic= '<img src="../../images/header/correcto.png" width="20" height="20">';
                                $ii= '<img src="../../images/header/incorrecto.png" width="20" height="20">';

                                echo '<script>
                                        function desaprobar(id){

                                            $.ajax({
                                                    type: "POST",
                                                    url: "form/acc/enviar_plan_publicidad.php?id="+id+"&p=11",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'publicidad.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                        function aprobar(id){

                                            $.ajax({
                                                    type: "POST",
                                                    url: "form/acc/enviar_plan_publicidad.php?id="+id+"&p=10",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'publicidad.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                        function eliminar(id){
                                        if (confirm("Estas seguro de eliminar la publicacion?")) {
                                            $.ajax({
                                                    type: "POST",
                                                    url: "form/acc/enviar_plan_publicidad.php?id="+id+"&p=12",
                                                    data: "",
                                                    success: function(msg){
                                                        window.location=\'publicidad.php\'

                                                    }
                                                });
                                            return false;
                                            }
                                            }
                                        </script>
                                        ';

                                for($i=0; $i<count($planes); $i++){
                                    $id = $planes[$i]["id"];

                                    $titulo = $planes[$i]["titulo"];

                                    $iTitulo = '<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=2&\'" id="iTitulo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                    $accion =$planes[$i]["accion"];

                                    $txtAccion = "";
                                    if($accion==1){
                                        $txtAccion = "Incluir";
                                    }elseif ($accion==2){
                                        $txtAccion = "Excluir";
                                    }

                                    if($accion==null){
                                        $iAccion = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=4&\'" id="iAccion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iAccion = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=4&\'" id="iAccion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $usuarios = $planes[$i]["usuarios"];
                                    if($usuarios==null){
                                        $iUsuarios = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=3&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iUsuarios = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=3&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $publicidad = $planes[$i]["publicidad"];
                                    if($publicidad==null){
                                        $iPublicidad = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=5&\'" id="iPublicidad'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iPublicidad = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=5&\'" id="iPublicidad'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
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
                                        <td>'.  $iUsuarios . '</td>
                                        <td>'. $txtAccion . $iAccion . '</td>
                                        <td>'. $iPublicidad . '</td>

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






                                <h1>Planes aprobados</h1>


                                                <div id="div-contenido-no-titulo">
                                                    <br>
                                                    <table width="100%">
                                <tr>
                                        <td width="16"><b>ID</b></td>
                                        <td width="46"><b>Titulo</b></td>
                                        <td width="689"><b>Usuarios</b></td>
                                        <td  width="20"><b>Accion</b></td>
                                        <td width="37"><b>Publi</b></td>

                                        <td width="64"><b>Aprobar</b></td>
                                        <td width="64"><b>Eliminar</b></td>
                                </tr>
                                <?php 


                                $planes = getPlanesPublicidadAprobados($usuario);




                                for($i=0; $i<count($planes); $i++){
                                    $id = $planes[$i]["id"];

                                    $titulo = $planes[$i]["titulo"];

                                    $iTitulo = '<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=2&\'" id="iTitulo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                    $accion =$planes[$i]["accion"];

                                    $txtAccion = "";
                                    if($accion==1){
                                        $txtAccion = "Incluir";
                                    }elseif ($accion==2){
                                        $txtAccion = "Excluir";
                                    }

                                    if($accion==null){
                                        $iAccion = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=4&\'" id="iAccion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iAccion = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=4&\'" id="iAccion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $usuarios = $planes[$i]["usuarios"];
                                    if($usuarios==null){
                                        $iUsuarios = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=3&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iUsuarios = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=3&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }

                                    $publicidad = $planes[$i]["publicidad"];
                                    if($publicidad==null){
                                        $iPublicidad = $ii .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=5&\'" id="iPublicidad'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                    }else{
                                        $iPublicidad = $ic .'<img onclick="window.location=\'form/publicidad.php?id='. $id . '&p=5&\'" id="iPublicidad'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
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


                                    echo '<tr><td>'. $id.'</td>
                                        <td>'. $titulo . $iTitulo . '</td>
                                        <td>'.  $iUsuarios . '</td>
                                        <td>'. $txtAccion . $iAccion . '</td>
                                        <td>'. $iPublicidad . '</td>

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
