<?php




include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

include_once '../../func/login.php';


$nivel = 2; 



$usuario = $_SESSION["usr"];
$correo = getEmailUsuario($usuario);


echo '
    
    <script>
        function guardarCambioDeCorreo(){
                $.ajax({
                    type: "POST",
                    url: "../../acc/cambiar_mail.php",
                    data: $("#formPreferenciasCambiarEmail").serialize(),
                    success: function(msg){
                        $("#divPreferenciasUsuarioFormularioCambiarCorreo").html(msg);
                    }   
                });
            return false; 
        }
    </script>
    <form id="formPreferenciasCambiarEmail">
        <input type="text" value="'. $correo . '" name="email" id="email">
        <input type="submit" value="Guardar" onclick="javascript:guardarCambioDeCorreo();return false;"><br>
    </form>
        ';


?>