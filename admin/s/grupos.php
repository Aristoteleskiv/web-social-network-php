<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/noticias.php';
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
                                <h1>Grupos de usuarios</h1>


                                <div id="div-contenido-no-titulo">
                                    <br>

                                    <script>
                                   function previsualizar(id){
                                               $("#divPrevisualizacion").html('<?php echo $imagenCargandoHtml; ?>');

                                               $.ajax({
                                                   type: "POST",
                                                   url: "../../datos/previsualizar_grupo.php",
                                                   data: "id="+id,
                                                   success: function(msg){
                                                     $("#divPrevisualizacion").html(msg);

                                                   }
                                               });
                                           }    

                                   </script>

                                                       <br>
                                   Grupos especiales: <br>
                                   <table border="1" width="100%">
                                   <tr>
                                           <td width="16"><b>ID</b></td>
                                           <td width="46"><b>Nombre</b></td>
                                           <td width="689"><b>Descripcion</b></td>
                                           <td><b>Usuarios</b></td>
                                           <td width="37"><b>Tipo</b></td>

                                           <td width="64"><b>Eliminar</b></td>
                                   </tr>

                                   <tr>
                                       <td>1</td>
                                       <td>Todos los usuarios</td>
                                       <td>Conjunto de todos los usuarios de la web</td>
                                       <td>Usuarios</td>
                                       <td>Invisible</td>
                                       <td>
                                           <form>
                                               <input type="button" value="Previsualizar" onclick="javascript:previsualizar(1)">
                                           </form>
                                       </td>
                                   </tr>
                                   <tr>
                                       <td>2</td>
                                       <td>Usuarios online</td>
                                       <td>Todos los usuarios que estan online en los ultimos 5 minutos</td>
                                       <td>Usuarios</td>
                                       <td>Invisible</td>
                                       <td><form>
                                               <input type="button" value="Previsualizar" onclick="javascript:previsualizar(2)">
                                           </form></td>
                                   </tr>
                                   <tr>
                                       <td>3</td>
                                       <td>Usuarios no confirmados</td>
                                       <td>Todos los usuarios que no han confirmado su email</td>
                                       <td>Usuarios</td>
                                       <td>Invisible</td>
                                       <td><form>
                                               <input type="button" value="Previsualizar" onclick="javascript:previsualizar(3)">
                                           </form></td>
                                   </tr>

                                   </table>
                                   <div id="divPrevisualizacion"></div>
                                   <br>
                                   <div onclick="window.location='form/grupo.php?p=1'" class="div-boton-estandar">Crear nuevo grupo</div>



                                   <br>
                                   Grupos<br>
                                   <table border="1" width="100%">
                                   <tr>
                                           <td width="16"><b>ID</b></td>
                                           <td width="46"><b>Nombre</b></td>
                                           <td width="689"><b>Descripcion</b></td>
                                           <td><b>Usuarios</b></td>
                                           <td width="37"><b>Tipo</b></td>

                                           <td width="64"><b>Eliminar</b></td>
                                   </tr>
                                   <?php 


                                   $grupos = getGrupos();




                                   $ic= '<img src="../../images/header/correcto.png" width="20" height="20">';
                                   $ii= '<img src="../../images/header/incorrecto.png" width="20" height="20">';

                                   echo '<script>

                                           function eliminar(id){
                                           if (confirm("Estas seguro de eliminar la publicacion?")) {
                                               $.ajax({
                                                       type: "POST",
                                                       url: "../../acc/enviar_grupo.php?id="+id+"&p=10",
                                                       data: "",
                                                       success: function(msg){
                                                           window.location=\'grupos.php\'

                                                       }
                                                   });
                                               return false;
                                               }
                                               }
                                           </script>
                                           ';

                                   for($i=0; $i<count($grupos); $i++){
                                       $id = $grupos[$i]["id"];



                                       $nombre = $grupos[$i]["nombre"];

                                       $iNombre = '<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=2&\'" id="iNombre'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';


                                       $descripcion = $grupos[$i]["descripcion"];
                                       if($descripcion==null){
                                           $iDescripcion = $ii .'<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=3&\'" id="iDescripcion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                       }else{
                                           $iDescripcion = $ic .'<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=3&\'" id="iDescripcion'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                       }

                                       $usuarios = 'Usuarios<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=4&\'" id="iUsuarios'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';

                                       $tipo = $grupos[$i]["tipo"];
                                       switch ($tipo) {
                                           case 1:
                                               $tipo1="Visible";

                                               break;
                                           case 2:
                                               $tipo1="Invisible";

                                               break;
                                           default:
                                               break;
                                       }

                                       if($tipo==null){
                                           $iTipo = $ii . '<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                       }else{
                                           $iTipo =  $tipo1 . '<img onclick="window.location=\'form/grupo.php?id='. $id . '&p=5&\'" id="iTipo'. $id . '" class="images-menus-admin" src="../../images/header/menu_editor.png">';
                                       }

                                       $formEliminar = '

                                               <form>
                                               <input onclick="javascript:eliminar('. $id . '); return false;" type="submit" value="eliminar">
                                               </form>

                                                   ';


                                       echo '<tr><td>'. $id.'</td>
                                           <td>'. $nombre . $iNombre . '</td>
                                           <td>'. $descripcion. $iDescripcion . '</td>
                                           <td>'. $usuarios . '</td>
                                           <td>'. $iTipo . '</td>


                                           <td>'. $formEliminar . '</td>
                                           </tr>
                                           ';
                                   }

                                   ?>

                                   </table>

                                   <?php
                                   echo $codigoPaginas;
                                   ?>

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

