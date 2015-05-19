<!DOCTYPE html>
<?php

include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';
$nivel = 1;
$usuario = $_SESSION["usr"];

include_once '../func/publicaciones.php';
include_once '../func/colecciones.php';
include_once '../func/clases/publicaciones.php';
include_once '../func/clases/colecciones.php';


include_once '../func/usuario.php';
include_once '../func/otras.php';
//include_once 'func/seguimiento.php';
//include_once 'func/usuarios_online.php';

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
                        <h1>
                            Colecciones
                        </h1>
                        <div id="div-contenido-no-titulo">
                            
                            <?php
            
                            
                            $colecciones = getColecciones($usuario,1);
                            //var_dump($colecciones);
                            for($i=0;$i<min(count($colecciones), $numeroResultadosPorPagina); $i++){

                                $linea = $colecciones[$i];
                                $id = $linea["id"];
                                $elemento = new ColeccionResumen2($linea, $usuario, $nivel);
                                echo $elemento->getHtml();
                            }
                            
                            if(count($colecciones)>$numeroResultadosPorPagina){
                                ?>
                                <div id="pag2">
                                    <div style="text-align: center;">
                                        <div onclick="cargarMas('2','5','<?php echo $nivel?>')" class="div-boton-estandar">Cargar más</div>
                                    </div>
                                    
                                </div>
                                
                                <?php
                            }

                            ?>
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

