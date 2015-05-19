<!DOCTYPE html>

<?php 

include_once '../../func/secciones.php';
include_once '../../func/login.php';
include_once '../../func/usuario.php';
include_once '../../func/muro.php';
include_once '../../func/otras.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';
$nivel = 2;
$nivelEnviador = $_POST["n"];

$nombre = null;
if (isset($_POST["nombre"])){$nombre = $_POST["nombre"];}
$password = null;
if (isset($_POST["password"])){$password = $_POST["password"];}
$password2 = null;
if (isset($_POST["password2"])){$password2 = $_POST["password2"];}
$usuario = null;
if (isset($_POST["usuario"])){$usuario = $_POST["usuario"];}
$sexo = null;
if (isset($_POST["sexo"])){$sexo = $_POST["sexo"];}
$email = null;
if (isset($_POST["email"])){$email = $_POST["email"];}
$terminos = null;
if (isset($_POST["terminos"])){$terminos = $_POST["terminos"];}
$anoNacimiento = null;
if (isset($_POST["ano_nacimiento"])){$anoNacimiento = $_POST["ano_nacimiento"];}
$s = getNiveles($nivel);
//echo $nombre . "," . $password . ",".$usuario.",".$sexo.",".$email.",".$anoNacimiento.",";
$registroCorrecto = false;
$msgNombre = null;
$msgUsuario = null;
$msgEmail = null;
$msgPass = null;
$msgPass2 = null;
$msgTerminos = null;
$checkNombre = false;
$checkUsuario = false;
$checkEmail = false;
$checkPass = false;
$checkPassIgual = false;
$checkTerminos = false;
$anoActual = date("Y");
if($nombre == null AND $password == null AND $usuario == null 
        AND $sexo == null AND $email == null AND $anoNacimiento == null AND $password2==null){
    $checkNombre = false;
    $checkUsuario = false;
    $checkEmail = false;
    $checkPass = false;
    $checkPassIgual = false;
    $checkTerminos = false;
    
    
    
}else{
    
    if($anoNacimiento == null){
        $anoNacimiento = $anoActual-6;
    }
    if($sexo == null){
        $sexo = "h";
    }
    
    
    
    if($nombre!=null){
        $checkNombre = validarNombre($nombre);
    }
    
    if($usuario!=null){
        $checkUsuario = validarNick($usuario);
        
        if($checkUsuario){
            $existeUsuario = comprobarSiUsuarioExiste_Login($usuario);
            
        }
    }
    
    if($email!=null){
        $checkEmail = validarEmail($email);
        if($checkEmail){
            $existeEmail = comprobarSiMailExiste_Login($email);
        }
    }
    
    if($password!=null){
        $checkPass = validarPassword($password);
    }
    
    $checkPassIgual = false;
    if($password!=null){
        if($password == $password2){
            $checkPassIgual = true;
        }
    }
    
    if($terminos=="si"){
        $checkTerminos = true;
    }
    
    $registroCorrecto = false;
    if($checkNombre AND $checkUsuario AND !$existeUsuario 
            AND $checkEmail AND !$existeEmail AND $checkPass AND $checkPassIgual 
            AND $checkTerminos){
        $registroCorrecto = true;
        
    }else{
  
        
        if(!$checkNombre){
            $msgNombre = "Debe de incluir almenos un nombre y un apellido separados por un espacio";
        }
        $msgUsuario = null;
        if(!$checkUsuario){
            $msgUsuario = "El Usuario contiene caracteres no validos, no contiene entre 4 y 20 caracteres o no está permitido";
        }else{
            if($existeUsuario){
                $msgUsuario = "Este usuario ya está escogido";
            }
        }

        $msgEmail = null;
        if(!$checkEmail){
            $msgEmail = "Email no válido";
        }else{
            if($existeEmail){
                $msgEmail = "Esta cuenta de correo ya está escogido";
            }
        }

        $msgPass = null;
        if(!$checkPass){
            $msgPass = "La contraseña debe de contener entre 6 y 40 caracteres y no puede incluir símbolos";
            
        }
        $msgPass2 = null;
        if(!$checkPassIgual){
            $msgPass2 = "Las contraseñas no coinciden";
            
        }
        $msgTerminos = null;
        if(!$checkTerminos){
            $msgTerminos = "Para poder registrarse es necesario aceptar los términos y condiciones";
            
        }
    }
}


if(!$registroCorrecto){

    echo "
        <script>
        $(document).ready(function() {
            $('.masterTooltipRegistroUsuario').hover(function(){
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
    </script>";
    ?>

    </scritp>
    <div><h2>Formulario de registro</h2></div>
    <form id="formNuevoUsuario" style="width: 600px; text-align: center">
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Nombre y apellido:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Debe de incluir almenos un nombre y un apellido" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>"></div>
        <?php if($msgNombre!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgNombre ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
        <br>
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Usuario:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Elige un nombre de usuario que no este ya cogido. Debe tener entre 4 y 20 caracteres y unicamente puede incluir letras [Aa/Zz] y numeros [0/9]" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px" type="text" name="usuario" id="usuario"  value="<?php echo $usuario; ?>"></div>
        <?php if($msgUsuario!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgUsuario ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
         <br>
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Email:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Escoge una dirección de correo válida" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="text" name="email" id="email" value="<?php echo $email; ?>"></div>
        <?php if($msgEmail!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgEmail ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
         <br>
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Contraseña:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="La contraseña debe tener entre 6 y 40 caracteres y unicamente puede incluir letras [Aa/Zz] y numeros [0/9]" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="password" name="password" id="password"></div>
        <?php if($msgPass!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgPass ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
        <br>
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Confirmar contraseña:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Introduzca la misma contraseña para confirmarla" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;"><input class="texto-formulario" style="width: 200px"  type="password" name="password2" id="password2"></div>
        <?php if($msgPass2!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgPass2 ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
        <br> 
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Sexo:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Escoge tu sexo" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;">
            <select name="sexo" id="sexo" class="texto-formulario" >
                <option value="h" <?php if($sexo=="h"){echo "selected";} ?>>Hombre</option>
                <option value="m" <?php if($sexo=="m"){echo "selected";} ?>>Mujer</option>
            </select>
        </div>
        <br>
        <div style="text-align: right; display: inline-block; width: 200px; margin-top: 10px;">Año de nacimiento:</div>
        <div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="Escoge tu año de nacimiento" style="width: 16px" src="<?php echo $s; ?>images/header/info.png"></div>
        <div style="text-align: left; display: inline-block; width: 200px; margin-top: 10px;">
            <select  name="ano_nacimiento" id="ano_nacimiento" class="texto-formulario" >
                <?php
                
                for($i=$anoActual-6; $i>=1920; $i--){
                    if($i!=$anoNacimiento){
                    echo "<option value=\"$i\">$i</option>";
                    }else{
                        echo "<option selected value=\"$i\">$i</option>";
                    }
                }
                ?>
            </select>
        </div>
        <br><br><div style=" margin-left: 40px; text-align: left;">Términos y condiciones:</div>
        <textarea cols="60" rows="10">BNLA BLA BLA</textarea>
        <br>
        <input type="checkbox" name="terminos" value="si"> He leido y acepto los términos expuestos
        <?php if($msgTerminos!=null){?><div style="text-align: right; display: inline-block; width: 20px; margin-top: 10px;"><img class="masterTooltipRegistroUsuario" title="<?php echo $msgTerminos ?>" style="width: 20px" src="<?php echo $s; ?>images/header/incorrecto.png"></div><?php }?>
        <div style="text-align: center; display: inline-block; width: 300px; margin-top: 10px;"><input class="boton-formulario" type="button" value="enviar" onclick="cargarFormularioRegistro('<?php echo $nivelEnviador; ?>'); return false;"></div>   
    </form>

<?php }else{
    
    $passwordMD5 = md5($password);
    //echo $nombre . "," . $password . ",".$usuario.",".$sexo.",".$email.",".$anoNacimiento.",";
    registrarNuevoUsuario($nombre, $usuario, $email, $passwordMD5, $anoNacimiento, $sexo);
    actualizarAceptacionTerminosYCondiciones($usuario);
    addEventoMuro($usuario, "inicio");
    
    
    ?>
    <div><h2>Formulario de registro</h2></div>
    <div style="width: 100%;">Registro completado. Procederemos a conectarle de manera automatica. No olvide que para poder utilizar todos los servicios es necesario confirmar la cuenta de correo en el apartado Preferencias. Gracias y esperamos que disfrute.</div>
    
    <?php
    $redireccion = '<script>
        window.setTimeout(function(){
            document.location = "'.  getNiveles($nivelEnviador).'";
        }, 8000);
      </script>';
    $redireccionAdmin = '<script>
        window.setTimeout(function(){
            location.reload();
        }, 1500);
      </script>';
            
    if(isset($_SESSION["usr"])){
        $niveluser = getNivelUsuario($_SESSION["usr"]);
        if($niveluser==3){
            echo $redireccionAdmin;
        }else{
            unset($_SESSION["usr"]);
            $_SESSION["usr"]=$usuario;
            echo $redireccion;
            
        }
    }else{
        $_SESSION["usr"]=$usuario;
        echo $redireccion;
    }
}

              
        
        
        
    
        
  