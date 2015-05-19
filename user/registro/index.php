<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';
$nivel = 2;

$usuario = $_SESSION["usr"];

include_once '../../func/menciones_comentarios.php';
include_once '../../func/clases/menciones.php';
include_once '../../func/usuario.php';
include_once '../../func/publicaciones.php';
//include_once 'funciones/seguimiento.php';
include_once '../../func/muro.php';
include_once '../../func/otras.php';
//include_once 'funciones/usuarios_online.php';
$s = getNiveles($nivel);

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
                    <div class="div-contenido">
                        <h1>Registro</h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
                                <script>cargarFormularioRegistro('<?php echo $nivel; ?>')</script>
                                <div id="divFormularioNuevoRegistro">

                                </div>
  
                            </div>
                        </div>
                    </div>
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


