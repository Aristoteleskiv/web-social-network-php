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
                            <h1>Confirmar email</h1>


                            <div id="div-contenido-no-titulo">
                                <br>
                                <script>

                                function confirmarUsuario(){
                                       $.ajax({

                                              type: "POST",
                                              url: "form/acc/confirmar_email.php",
                                              data: $("#formConfirmarUsuario").serialize(),
                                              success: function(msg){
                                                $("#divRespuestaConfirmacionUsuario").html(msg);
                                              }
                                          });
                                  return false; 
                                  }
                                </script>
                                <div class="div-contenedor-estandar">
                                    <h2></h2>
                                    Introducir el nombre de usuario correspondiente al email a confirmar.
                                    <form id="formConfirmarUsuario">
                                        Usuario sin @: <input type="text" id="nick" name="nick">
                                        <input type="submit" value="Confirmar" onclick="javascript:confirmarUsuario(); return false;">
                                    </form>
                                    <div id="divRespuestaConfirmacionUsuario">

                                    </div>
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
