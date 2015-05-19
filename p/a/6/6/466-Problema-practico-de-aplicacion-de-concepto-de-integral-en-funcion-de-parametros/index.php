<!DOCTYPE html>
    <?php
    include_once '../../../../../func/secciones.php';
    include_once '../../../../../conf/conf.php';
    include_once '../../../../../conf/sesion.php';
    include_once '../../../../../func/publicaciones.php';
    include_once '../../../../../func/colecciones.php';
    include_once '../../../../../func/usuario.php';
    include_once '../../../../../func/otras.php';
    include_once '../../../../../func/clases/publicaciones.php';
    $nivel = 5;
    $id = 466;
    
    sumarVisitaAPublicacion($id);
    $usuario = $_SESSION["usr"];
    $col = null;
    
    if(isset($_GET["c"])){
        $col = $_GET["c"];
        sumarVisitaAColeccion($col);
    }
    
    $posComentario = null;
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
                            <h1>Publicación 466</h1>
                            <div class="div-contenido-no-titulo">
                            <?php 
                            $elemento = new Publicacion($id, $usuario, $col, $posComentario, $nivel);
                            echo $elemento->getHtml();
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