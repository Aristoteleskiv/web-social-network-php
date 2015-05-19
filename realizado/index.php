<!DOCTYPE html>
<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';

$nivel = 1;
$usuario = $_SESSION["usr"];
include_once '../func/publicaciones.php';
include_once '../func/clases/publicaciones.php';

include_once '../func/clases/noticias.php';
include_once '../func/clases/encuestas.php';
include_once '../func/noticias.php';
include_once '../func/grupos.php';
include_once '../func/encuestas.php';
include_once '../func/usuario.php';
include_once '../func/otras.php';


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
                            <h1>
                                 Realizado
                             </h1>
                             <div id="div-contenido-no-titulo">
                                 <script>desfaseRealizados = 0;</script>
                                 <?php
                                 echo "<script>" . getScriptOverText(1) . "</script>";


                                 $s = getNiveles($nivel);
                                 $publicaciones = getPublicacionesRealizadas($usuario,1);

                                 for($i=0;$i<min(count($publicaciones), $numeroResultadosPorPagina); $i++){

                                     $linea = $publicaciones[$i];
                                     $id = $linea["id_publicacion"];
                                     $linea2 = getPublicacion($id);
                                     $elemento = new PublicacionResumen2($linea2, $usuario, $nivel, 1,  4);
                                     echo $elemento->getHtml();
                                 }
                                 echo '<script>numPublicaciones = '. min(count($publicaciones), $numeroResultadosPorPagina) .';</script>';
                                 if(count($publicaciones)==0){
                                     echo '<div class="div-contenedor-estandar">Todavia no ha marcado ninguna publicación como realizada. '
                                     . 'Para marcarlas como realizadas hay que pulsar sobre el icono <img class="imagen-menus-publicacion-no-opaco" style="float: none" src="'.$s.'images/header/marcado_realizado.png"> que encontrará en las publicaciones.</div>';
                                 }
                                 if(count($publicaciones)>$numeroResultadosPorPagina){
                                     ?>
                                     <div id="pag2">
                                         <div style="text-align: center;">
                                             <div onclick="cargarMas('2','4','<?php echo $nivel?>')" class="div-boton-estandar">Cargar más</div>
                                         </div>

                                     </div>

                                     <?php
                                 }

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

    
</html>



