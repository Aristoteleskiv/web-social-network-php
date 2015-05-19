<?php



session_start();
include_once '../config/configuracion.php';
include_once '../funciones/login.php';

if(isset($_SESSION["usr"]) ){
    

$id = $_POST["id"];

$usuario = $_SESSION["usr"];
$correo = getEmailUsuario($usuario);

echo '
    
    <script>
        function guardarCambioDeCorreo(){

                $.ajax({
                    type: "POST",
                    url: "acciones/cambiar_mail.php",
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

}else{
    echo '<script>document.location="index.php"</script>';
}

?>