<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

include_once '../../func/mensajes.php';
include_once '../../func/clases/mensajes.php';
include_once '../../func/usuario.php';
include_once '../../func/otras.php';
//include_once 'func/seguimiento.php';
//include_once 'func/usuarios_online.php';
//include_once 'func/login.php';
$nivel = 2;
$usuario = $_SESSION["usr"];


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
                    if($usuario==null){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                            <div class="div-contenido">
                                <?php if(!isset($_GET["u"])){ ?>
                                    <h1>
                                        Mensajes
                                    </h1>
                                    <div id="div-contenido-no-titulo">

                                        <script>numMensajesEliminados=0;</script>
                                        <?php

                                            $mensajes = getMensajes($usuario);

                                            for($i=0; $i<count($mensajes); $i++){


                                            $elemento = new Mensaje2($mensajes[$i], $nivel);
                                            echo $elemento->getHTML();
                                        }
                                        setTodosMensajesVistos($usuario);
                                        echo '<script>numMensajes = '.count($mensajes).';</script>';
                                        if(count($mensajes)==0){
                                            echo '<div class="div-contenedor-estandar">No tiene ningún mensaje.</div>';
                                        }
                                        ?>

                                    </div>
                                <?php }else{ 
                                    $destinatario = getNombreUsuario($_GET["u"]);   

                                    if (sonAmigos($usuario, $destinatario) == 1){
                                        ?>

                                        <h1>
                                        Enviar mensaje
                                        </h1>
                                        <div id="div-contenido-no-titulo">
                                            <div class="div-contenedor-estandar">


                                                <h2>Mensaje a @<?php echo $destinatario ?></h2>
                                                <div id="divEnviarMensaje">
                                                    <form id="formEnviarMensaje" >
                                                    Cuerpo:<br>
                                                    <textarea name="cuerpo" id="cuerpo" cols="70" rows="8"></textarea><br>
                                                    <input type="button" onclick="enviarMensaje('<?php echo $_GET["u"] ?>','<?php echo $nivel ?>');" value="Enviar">
                                                    </form>
                                                <div>

                                            </div>
                                        </div>

                                        <?php
                                    }else{
                                        ?>

                                        <h1>
                                        Enviar mensaje
                                        </h1>
                                        <div id="div-contenido-no-titulo">
                                            Usuario incorrecto.
                                        </div>

                                        <?php
                                    }
                                    ?>

                                <?php
                                } ?>
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

    
</html>
