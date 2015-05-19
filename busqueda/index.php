<!DOCTYPE html>
<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';

$nivel = 1;
$usuario = $_SESSION["usr"];
include_once '../func/publicaciones.php';
include_once '../func/notificaciones.php';
include_once '../func/colecciones.php';

include_once '../func/clases/amigo.php';
include_once '../func/clases/publicaciones.php';
include_once '../func/clases/colecciones.php';
include_once '../func/muro.php';
include_once '../func/usuario.php';
include_once '../func/otras.php';
include_once '../func/menciones_comentarios.php';

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
                       <h1>Resultados de búsqueda</h1>
                        <div id="div-contenido-no-titulo">
                            
                            
                                <?php
                                $b = $_GET["b"];
                                if(substr($b, 0,1)=="@"){

                                    $nombre = substr($b, 1, strlen($b)-1);
                                    $amigos = busquedaPersonas($usuario, $nombre,1);
                                    $maxResultados = 6;
                                    
                                    for($i=0; $i<min($numeroResultadosPorPagina, count($amigos)); $i++){
                                        $amigo = $amigos[$i]["amigo"];
                                        
                                        $elemento = new PersonaAmigoNoAmigoResumen($usuario, $amigo, $nivel);
                                        echo $elemento->getHtml();
                                        
                                    }
                                    if(count($amigos)>$numeroResultadosPorPagina){
                                        ?>
                                        <div id="pag2">
                                            <div style="text-align: center;">
                                                <div onclick="cargarMas('2','6','<?php echo $nivel?>', '&b=<?php echo $b?>')" class="div-boton-estandar">Cargar más</div>
                                            </div>

                                        </div>

                                        <?php
                                    }
                                }else{
                                    $ext = "&b=" . $b;
                                    $f = null;
                                    if(isset($_GET["f"])){
                                        $f = $_GET["f"];
                                        $ext .= "&f=" . $f;
                                    }
                                    
                                    if($f == null){
                                        $colecciones = busquedaColeccionPorTexto($b,1);
                                        for($i=0;$i<min(count($colecciones), $numeroResultadosColeccionesBusqueda); $i++){
                                            $id = $colecciones[$i];
                                            $elemento = new ColeccionResumen2SoloConID($id, $usuario,
                                                    $nivel);
                                            echo $elemento->getHtml();
                                        }

                                        
                                        if(count($colecciones)>$numeroResultadosColeccionesBusqueda){
                                            ?>
                                            <div class="div-contenedor-estandar">
                                                Hemos encontrado más colecciones. Si quiere ver unicamente los resultados de colecciones pulse aqui
                                                <div style="margin-top: 10px; width: 100%; text-align: center"><a href="index.php?b=<?php echo $b; ?>&n=<?php echo $nivel; ?>&f=c"><div class="div-boton-estandar">Sólo colecciones</div></a></div>
                                            </div>
                                            <?php
                                        }
                                        $publicaciones = busquedaPublicacionPorTexto($b, 1);
                                        for($i=0;$i<min(count($publicaciones), $numeroResultadosPorPagina); $i++){

                                            $id = $publicaciones[$i];
                                            $elemento = new PublicacionResumen2SoloConID($id, 
                                                    $usuario, $nivel, 1);
                                            echo $elemento->getHtml();
                                        }
                                        if(count($publicaciones)>$numeroResultadosPorPagina){
                                            ?>
                                            <div id="pag2">
                                                <div style="text-align: center;">
                                                    <div onclick="cargarMas('2','7','<?php echo $nivel?>', '<?php echo $ext?>')" class="div-boton-estandar">Cargar más</div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }elseif($f=="c"){
                                        $colecciones = busquedaColeccionPorTexto($b,1);
                                        for($i=0;$i<min(count($colecciones), $numeroResultadosPorPagina); $i++){
                                            $id = $colecciones[$i];
                                            $elemento = new ColeccionResumen2SoloConID($id, $usuario,
                                                    $nivel);
                                            echo $elemento->getHtml();
                                        }
                                        if(count($colecciones)>$numeroResultadosPorPagina){
                                            ?>
                                            <div id="pag2">
                                                <div style="text-align: center;">
                                                    <div onclick="cargarMas('2','7','<?php echo $nivel?>', '<?php echo $ext?>')" class="div-boton-estandar">Cargar más</div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    
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



