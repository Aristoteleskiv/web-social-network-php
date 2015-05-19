<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/login.php';
include_once '../../func/usuario.php';
include_once '../../func/publicaciones.php';


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
                            <h1>Gestion masiva de publicaciones</h1>
                            <div id="div-contenido-no-titulo">
                                <br>
                                <div class="div-contenedor-estandar">
                                    <h2>Creacion de archivos</h2>
                                    Numero total de publicaciones: <?php echo getNumeroDePublicaciones(); ?><br>
                                    Numero total de publicaciones Video: <?php echo getNumeroDePublicacionesVideo(); ?><br>
                                    Numero total de publicaciones PDF: <?php echo getNumeroDePublicacionesPDF(); ?><br>
                                    <br>
                                    <form id="formCreacionMasivaArchivos">
                                        Aplicar a: <select name="rango"> 
                                        <option value="1">Publicaciones PDF</option>
                                        <option value="2">Publicaciones Video</option>
                                        <option value="3">Todas</option>
                                        </select><br>
                                        Tipo de nomenclatura: <select name="nomenclatura"> 
                                        <option value="1">Seccion + cuerpo (recomendada)</option>
                                        <option value="2">Seccion + titulo</option>
                                        </select><br>
                                        <input type="button" value="Crear" onclick="javascript:crearArchivos();">
                                    </form>
                                    <div id="divRespuestaCreacionArchivos"></div>
                                    <script>

                                    function crearArchivos(){

                                        $.ajax({
                                            type: "POST",
                                            url: "form/acc/gm_crear_dir_publicacion.php",
                                            data: $("#formCreacionMasivaArchivos").serialize(),
                                            success: function(msg){
                                              $("#divRespuestaCreacionArchivos").html(msg);
                                            }
                                        });
                                      return false; 
                                      }
                                    </script>
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

