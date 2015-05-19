<?php




include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';
include_once '../../func/secciones.php';
include_once '../../func/login.php';
include_once '../../func/otras.php';

$nivel = 2; 
$s = getNiveles($nivel);


$usuario = $_SESSION["usr"];
$correo = getEmailUsuario($usuario);

$codOverText = getScriptOverText(1);
echo  '<script>
        '. $codOverText  . '
        function guardarCambioDePassword(){
                $.ajax({
                    type: "POST",
                    url: "../../acc/cambiar_password_pref.php",
                    data: $("#formPreferenciasCambiarPassword").serialize(),
                    success: function(msg){
                        $("#divPreferenciasUsuarioFormCambiarPassword").html(msg);
                        
                    }   
                });
            return false; 
        }
    </script>
    <form id="formPreferenciasCambiarPassword">
        Antigua: <img class="masterTooltip1" title="Contraseña antigua que ha utilizado hasta ahora" style="width: 16px" src="'. $s .'images/header/info.png"> <input type="password" value="" name="ant" id="ant"><br>
        Nueva: <img class="masterTooltip1" title="Nueva contraseña que quiere utilizar" style="width: 16px" src="'. $s .'images/header/info.png"> <input type="password" value="" name="nue1" id="nue1"><br>
        Confirmar nueva: <img class="masterTooltip1" title="Confirmación de nueva contraseña" style="width: 16px" src="'. $s .'images/header/info.png"> <input type="password" value="" name="nue2" id="nue2"><br>
        <input type="submit" value="Guardar" onclick="javascript:guardarCambioDePassword();return false;"><br>
    </form>
        ';


?>