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
                                <h1>Enviar mensaje</h1>


                                <div id="div-contenido-no-titulo">
                                    <br>

                                    <?php



                            echo '<br>Enviar un mensaje: <form id="formEnviarMensaje">
                                Mandatario: <input type="text" id="mandatario" name="mandatario"><br>
                                Destinatario: <input type="text" id="destinatario" name="destinatario"><br>
                                Cuerpo:<br>
                                <textarea name="cuerpo" id="cuerpo" cols="70" rows="8"></textarea><br>
                                <input type="button" onclick="enviarMensajeAdmin();" value="Enviar">


                                  </form>
                                  <div id="divRespuestaMensaje"></div>
                                <script>

                                function enviarMensajeAdmin(){

                                    $.ajax({

                                        type: "POST",
                                        url: "form/acc/enviar_mensaje.php",
                                        data: $("#formEnviarMensaje").serialize(),
                                        success: function(msg){
                                          $("#divRespuestaMensaje").html(msg);
                                        }
                                    });
                                  return false; 
                                  }
                                </script>
                            ';
                                    ?>

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
