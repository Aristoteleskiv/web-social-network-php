<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';
$nivel = 2;

$usuario = $_SESSION["usr"];

include_once '../../func/menciones_comentarios.php';
include_once '../../func/clases/amigo.php';
include_once '../../func/usuario.php';
include_once '../../func/publicaciones.php';
include_once '../../func/login.php';
include_once '../../func/clases/muro.php';

//include_once 'funciones/seguimiento.php';
include_once '../../func/notificaciones.php';
include_once '../../func/muro.php';
include_once '../../func/otras.php';
//include_once 'funciones/usuarios_online.php';

if(isset($_GET["u"])){
    $id = $_GET["u"];
    $user = getNombreUsuario($id);
}else{
    $user = $usuario;
    if ($user == null){
        echo codigoRedireccionHome($nivel);
    }
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
                                Muro
                            </h1>
                            <div id="div-contenido-no-titulo">
                                <div class="div-contenedor-estandar">
                               <?php 

                                    $elemento = new AmigoMuro2($usuario, $user, $nivel, 1);
                                    echo $elemento->getHTML();
                                ?>
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
