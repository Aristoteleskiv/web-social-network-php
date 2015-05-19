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
include_once '../../func/login.php';
include_once '../../func/otras.php';
include_once '../../func/cookies.php';
//include_once 'funciones/usuarios_online.php';

$n = getNiveles($nivel);
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
                            Login
                        </h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
                                <?php
                                
                                
                                if(isset($_POST["u"]) && isset($_POST["p"])){
                                    
                                    $user = $_POST["u"];
                                    $pass = md5($_POST["p"]);
                                    $comprobacion = comprobarUsuarioPassword($user, $pass);
                                    if($comprobacion){
                                        if(isset($_POST["r"])){
                                            if($_POST["r"]=="si"){
                                                echo "Creada cookie";
                                                crearCookieMantenerConectado($user);
                                            }
                                        }
                                        echo '<div style="text-align: center;"><img src="'.$n.'images/header/correcto.png"></div>Usuario y contraseña correcta. Conectando...';
                                        echo '<script>
                                                window.setTimeout(function(){
                                                    document.location = "'.$n.'";
                                                }, 1500);
                                              </script>
                                            ';
                                        iniciarVaraibleSessionUser($user);
                                    }else{
                                        echo '<div style="text-align: center;"><img src="'.$n.'images/header/incorrecto.png">'
                                                . '</div>Usuario o contraseña incorrecta.<br>Si no recuerda su contraseña puede realizar el procedimiento para restaurar la contraseña en el siguiente enlace.<div style="width: 100%; text-align: center;"> <a href="'.$n.'user/recuperar" style="color: blue;">Restaurar contraseña</a></div>';
                                    }
                                }else{
                                    echo "Redirigiendo...";
                                    echo '<script>
                                                window.setTimeout(function(){
                                                    document.location = "'.$n.'";
                                                }, 1500);
                                              </script>
                                            ';
                                }
                                ?>
                                <div id="divFormularioLogin">
                                
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


