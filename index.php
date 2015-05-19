<!DOCTYPE html>
<?php

include_once 'func/secciones.php';
include_once 'conf/conf.php';
include_once 'conf/sesion.php';
$nivel = 0;

$usuario = null;
if(isset($_SESSION["usr"])){$usuario = $_SESSION["usr"];}


include_once 'func/publicaciones.php';
include_once 'func/clases/publicaciones.php';

include_once 'func/clases/noticias.php';
include_once 'func/clases/encuestas.php';
include_once 'func/noticias.php';
include_once 'func/grupos.php';
include_once 'func/encuestas.php';
include_once 'func/usuario.php';
include_once 'func/otras.php';


if(isset($_GET["u"])){
    $_SESSION["usr"] = $_GET["u"];
}

if(isset($_GET["p"])){
    $publi = $_GET["p"];
    $dir = getDirPublicacion($publi);
    echo '<script>document.location="p/'. $dir .'";</script>';
    
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
                    <div class="div-contenido">
                        <h1>
                            Home
                        </h1>
                        <div id="div-contenido-no-titulo">
                            
                            <?php

                            echo "<script>" . getScriptOverText(1) . "</script>";
            
                            
                            
                            $noticias = getNoticias($usuario);
                            for($i=0;$i<count($noticias); $i++){

                                $linea = $noticias[$i];
                                $id = $linea["id"];
                                marcarVistaNoticia($id, $usuario);
                                $elemento = new Noticia($id, $usuario, $nivel);
                                echo $elemento->getHtml();
                            }


                            $encuesta = getEncuesta($usuario);

                            if($encuesta!=null){    
                                $linea = $encuesta;
                                $id = $linea["id"];
                                marcarVistaEncuesta($id, $usuario);
                                $elemento = new Encuesta($id, $usuario, $nivel);
                                echo $elemento->getHtml();
                            }

                            $publicaciones = getPublicaciones($usuario,1);
                            for($i=0;$i<min(count($publicaciones), $numeroResultadosPorPagina); $i++){

                                $linea = $publicaciones[$i];
                                $id = $linea["id"];
                                $elemento = new PublicacionResumen2($linea, $usuario, $nivel, 1);
                                echo $elemento->getHtml();
                            }
                            
                            if(count($publicaciones)>$numeroResultadosPorPagina){
                                ?>
                                <div id="pag2">
                                    <div style="text-align: center;">
                                        <div onclick="cargarMas('2','1','<?php echo $nivel?>')" class="div-boton-estandar">Cargar más</div>
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


