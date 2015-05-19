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
                        <h1>
                            Formulario para recuperar contraseña
                        </h1>
                        <div id="div-contenido-no-titulo">
                            <div class="div-contenedor-estandar">
                                
                                <?php 
                                $msg = "";
                                if(isset($_GET["h"])){
                                    $hash = $_GET["h"];
                                    $validar = false;
                                    if(isset($_POST["p"])&&isset($_POST["p2"])){
                                        if($_POST["p"]!=$_POST["p2"]){
                                            echo '<div style="text-align: center;"><img src="'.$s.'images/header/incorrecto.png"></div>';
                                            $msg = "Las contraseñas no coinciden";
                                            $validar = false;
                                        }else{
                                            if(!validarPassword($_POST["p"])){
                                                echo '<div style="text-align: center;"><img src="'.$s.'images/header/incorrecto.png"></div>';
                                                $msg = "La contraseña debe de tener entre 6 y 40 caracteres";
                                                $validar = false;
                                            }else{
                                                $validar = true;
                                            }
                                        }
                                    }
                                    
                                    $datosHash = getDatosHashRecuperarPassword($hash);
                                    $usuario = $datosHash["usuario"];
                                    $fecha = $datosHash["fecha"];
                                    $id = $datosHash["id"];
                                    $phpdate = strtotime( $fecha );
                                    $fechaConsulta = date( 'Y-m-d H:i:s', $phpdate );
                                    $ahora = date("Y-m-d H:i:s");
                                    $minutos =  round(abs(strtotime($ahora) - strtotime($fechaConsulta))/60);
                                    
                                    if(!$validar){
                                        if($usuario==null){
                                            echo '<div style="text-align: center;"><img src="'.$s.'images/header/incorrecto.png"></div>';
                                            echo "El código del enlace es incorrecto.";
                                        }else{
                                            if($minutos > 60){
                                                echo '<div style="text-align: center;"><img src="'.$s.'images/header/incorrecto.png"></div>';
                                                echo "El código del enlace ha caducado. Deberá de repetir el proceso. Recuerde que los enlaces para recuperar la contraseña caducan en 60 minutos.";
                                            }else{
                                               
                                               echo "El código del enlace es correcto. Rellene los campos para reestablecer la contraseña del usuario @" . $usuario . "."; 
                                               ?>
                                               
                                                <form action="" method="POST">
                                                <br><div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Contraseña:</div>
                                                <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltip" title="Nueva contraseña para su cuenta" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
                                                <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="password" name="p" id="nombre" value=""></div>
                                                <input type="hidden" name="h" value="<?php echo $_GET["h"]; ?>">
                                                <br>
                                                <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Confirmación:</div>
                                                <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltip" title="Repita la contraseña nueva" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
                                                <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px" type="password" name="p2" id="usuario"  value=""></div>

                                                <div style="text-align: right; display: inline-block; width: 300px; margin-top: 10px;"><input class="boton-formulario" type="submit" value="Enviar" ></div>   
                                                </form>
                                                <div style="text-align: center; color: red;"><?php echo $msg; ?></div>
                                               <?php
                                            }
                                        }
                                    }else{
                                        $password = md5( $_POST["p"] );
                                        cambiarPassword($usuario, $password);
                                        eliminarSolicitudesRecuperarPassword($usuario);
                                        echo '<div style="text-align: center;"><img src="'.$s.'images/header/correcto.png"></div>';
                                        echo 'Su contraseña ha sido restaurada. En  unos instantes se le redirigirá automaticamente a la página de inicio...';
                                        echo '<script>setTimeout(function(){
                                                document.location="'. $s .'";
                                            }, 3000);</script>';
                                    }
                                    
                                
                                    
                                }else{
                                    $ac = false;
                                    if(isset($_POST["u"]) && isset($_POST["e"])){
                                        $usr = $_POST["u"];
                                        $em = $_POST["e"];
                                        $comprobar = comprobarUsuarioMail($usr, $em);
                                        $ac = true;
                                    }

                                    ?>
                                    <h2>Instrucciones</h2>
                                    Si no recuerdas tu contraseña deberás de seguir las siguientes instrucciones.<br>
                                    En primer lugar deberás introducir el usuario con el que realziaste el registro así como el correo electronico. A continuación se le enviará un correo a su cuenta de email con un enlace  que deberá pulsar. Este enlace caduca en una hora y de ocurrir esto deberá de volver a realizar el proceso. Una vez pulsado en el enlace podrá reestablecer su contraseña.
                                    <form action="" method="POST">
                                    <br><div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Usuario:</div>
                                    <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltip" title="Usuaro con el que realizó el registro" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
                                    <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="text" name="u" id="nombre" value=""></div>

                                    <br>
                                    <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Email:</div>
                                    <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltip" title="Cuenta de correo con la que realizó el registro" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
                                    <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px" type="text" name="e" id="usuario"  value=""></div>

                                    <div style="text-align: right; display: inline-block; width: 300px; margin-top: 10px;"><input class="boton-formulario" type="submit" value="Enviar" ></div>   
                                    </form>
                                    <?php
                                    if($ac){
                                        echo '<div style="text-align: center; color: blue;">Petición procesada. Gracias</div>';
                                        if($comprobar){
                                            generarClaveRecuperarPassword($usr, $em);
                                        } 
                                    }
                                }                                
                                ?>
   
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


