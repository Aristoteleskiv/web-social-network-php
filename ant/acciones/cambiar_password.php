<?php




include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/seguimiento.php';
session_start();


if((isset($_POST["hash"])) AND (isset($_POST["password"])) ){
    
    
    $_SESSION["acc"] = $accCambiarPassword;
    $hash = $_POST["hash"];    
    $usuario = getDatosHashRecuperarPassword($hash);
    $usuario = $usuario["usuario"];
    
    
    if(validarPassword($_POST["password"])){
    
        $password = md5( $_POST["password"] );
        
        echo $usuario . " - " . $password;
        cambiarPassword($usuario, $password);
        eliminarSolicitudesRecuperarPassword($usuario);

        
        
        echo "Contraseña cambiada con exito. Redireccionando...";
        echo '<script>setTimeout(function(){

                document.location="../index.php";
            }, 1500);</script>';
    }else{
        
        
        echo '
            <script>

            function cambiarPassword() {

                $.ajax({
                    type: "POST",
                    url: "../acciones/cambiar_password.php",
                    data: $("#formCambiarPassword").serialize(),
                    success: function(msg){
                      $("#divPrincipal").html(msg);
                    }
                });
            }

            </script>
            Nueva contraseña del usuario <b>'. $usuario . '</b><br>
            <form id="formCambiarPassword">
                Nueva contraseña: <input type="password" name="password" id="password"><br>
                <input type="hidden" value="<?php echo $hash; ?>" name="hash" id="hash">
                <input type="submit" value="enviar" onclick="cambiarPassword(); return false;">
            </form>
            <p style="color: red;">La contraseña debe contener entre 6 y 40 caracteres</p>
            '; 
        
        
    }
    
    if(isset($_SESSION["usr"])){
        registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
                $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    }else{
        registrarSeguimiento($_SERVER['REMOTE_ADDR'], $_SESSION["est"], 
                $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    }
}else{
    echo '<script>document.location="../index.php"</script>';
}
?>


