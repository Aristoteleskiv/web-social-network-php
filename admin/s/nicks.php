<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/login.php';
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
                                <h1>Nicks prohibidos</h1>


                                <div id="div-contenido-no-titulo">

                                    <div class="div-contenedor-estandar">

                                    <?php
                            $nicks = getNicksProhibidos();
                            for($i=0; $i<count($nicks); $i++){


                            echo   '<form id="formNick'. $nicks[$i]["id"] . '">
                                      ID: '. $nicks[$i]["id"] . ' - ' .  $nicks[$i]["nick"] . '<input type="hidden" name="id" id="id" value="'. $nicks[$i]["id"] . '">
                                      <input type="submit" value="eliminar" onclick="javascript:eliminar'.  $nicks[$i]["id"]  . '();return false;">
                                   </form>
                                   <script>

                                   function eliminar'.  $nicks[$i]["id"]  . '(){

                                          $.ajax({
                                                 type: "POST",
                                                 url: "form/acc/eliminar_nick_prohibido.php",
                                                 data: $("#formNick'.  $nicks[$i]["id"]  . '").serialize(),
                                                 success: function(msg){
                                                    window.location=\'nicks.php\'
                                                 }
                                             });


                                     return false; 
                                     }
                                     </script>


                                        ';
                            }


                            echo '<br>Añadir nick a la lista: <form id="formAddNick">
                                Nick: <input type="text" id="nick" name="nick">
                                <input type="submit" value="Añadir" onclick="javascript:addNick(); return false;">


                            </form>
                            <script>

                                function addNick(){

                                       $.ajax({

                                              type: "POST",
                                              url: "form/acc/add_nick_prohibido.php",
                                              data: $("#formAddNick").serialize(),
                                              success: function(msg){
                                                window.location=\'nicks.php\'
                                              }
                                          });


                                  return false; 
                                  }
                                </script>
                            ';


                                    ?>

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
