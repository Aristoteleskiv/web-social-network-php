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
                                Menciones
                            </h1>
                            <div id="div-contenido-no-titulo">
                                <script>numMencionesEliminadas=0;</script>
                                <script>            
                                    $(document).ready(function() {
                                            $('.masterTooltipComentarios').hover(function(){
                                                    var title = $(this).attr('title');

                                                    $(this).data('tipText', title).removeAttr('title');
                                                    $('<p class=\"tooltip\"></p>')
                                                    .text(title)
                                                    .appendTo('body')
                                                    .fadeIn('slow');
                                            }, function() {
                                                    $(this).attr('title', $(this).data('tipText'));
                                                    $('.tooltip').remove();
                                            }).mousemove(function(e) {

                                                    var x = $(this).offset().left - ($('.tooltip').width() - $(this).width())/2;
                                                    var y = $(this).offset().top - $('.tooltip').height() -8 ; 

                                                    $('.tooltip')
                                                    .css({ top: y, left: x});
                                            });
                                    });
                                    </script>
                                    <?php
                                    
                                    $menciones = getMenciones($usuario);
                                    for($i=0; $i<count($menciones); $i++){

                                        $elemento = new Mencion2($menciones[$i], $nivel);
                                        echo $elemento->getHTML();
                                    }
                                    setTodasMencionesVistas($usuario);
                                    echo '<script>numMenciones = '.count($menciones).';</script>';
                                    if(count($menciones)==0){
                                        echo '<div class="div-contenedor-estandar">No tiene ninguna mención.</div>';
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


