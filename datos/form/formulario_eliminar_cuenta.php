<?php




include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

include_once '../../func/login.php';


$nivel = 2; 
$usuario = $_SESSION["usr"];


echo '
    
    <script>
        function confirmarEliminarCuenta(){
                $.ajax({
                    type: "POST",
                    url: "../../acc/eliminar_cuenta.php",
                    data: $("#formPreferenciasEliminarCuenta").serialize(),
                    success: function(msg){
                        $("#divPreferenciasUsuarioFormEliminarCuenta").html(msg);
                    }   
                });
            return false; 
        }
    </script>
    <form id="formPreferenciasEliminarCuenta">
        <b>Atención</b>: Si realiza esta operación toda su información se perderá de modo definitivo.<br>
        Introduzca la contraseña de su cuenta: <input type="password" value="" name="pass" id="pass">
        <input type="submit" value="Eliminar" onclick="javascript:confirmarEliminarCuenta();return false;"><br>
    </form>
        ';


?>