<!DOCTYPE html>


<?php
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/otras.php';


session_start();
$_SESSION["esta"] = $_SESSION["est"];
$_SESSION["est"]= $formLoginRecuperarPassword;

if(!isset($_SESSION["usr"])){


?>


        <script>
        
        function checkDatosIntroducidos() {
                
                $.ajax({
                    type: "POST",
                    url: "formularios/login_recuperar_password.php",
                    data: $("#formRecuperarPassword").serialize(),
                    success: function(msg){
                      $("#divPrincipal").html(msg);
                    }
                });
            }
        
        </script>
        
        <h1>Formulario para recuperar password</h1><br>
        <div style="width: 50%;">Introduzca el usuario con el que realizó el registro, asi como su cuenta de correo y si concuerdan, se le enviará un correo electronico con un enlace donde podrá cambiar la contraseña.</div>
        <br>

            <?php
        if(!isset($_GET["h"])){
            
            if(!isset($_POST["usuario"])){

            ?>
                <form id="formRecuperarPassword">
                    Usuario: <input type="text" name="usuario" id="usuario"><br>
                    Email: <input type="text" name="email" id="email"><br>
                    <input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;">
                </form>
            
            <?php
            }else{
                
                
                $anterior = $_SESSION["esta"];
                if($anterior == $formLoginRecuperarPassword){  
                                        //solo se realiza el generarclave
                                        //si se viene desde este mismo formulario
                                        
                
                    $usuario = $_POST["usuario"];
                    $email = $_POST["email"];
                    

                    $comprobar = comprobarUsuarioMail($usuario, $email);

                    if($comprobar){
                        echo 'Usuario y email correctos. Le hemos enviado un email con las instrucciones a su correo';
                        generarClaveRecuperarPassword($usuario, $email);
                    }else{
                         ?>
                            <form id="formRecuperarPassword">
                                Usuario: <input type="text" name="usuario" id="usuario"><br>
                                Email: <input type="text" name="email" id="email"><br>
                                <input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;">
                            </form>
                            <font color="red">Nombre de usuario o email incorrectos</font>
                        <?php
                    }
                }else{  //si no
                     ?>
                            <form id="formRecuperarPassword">
                                Usuario: <input type="text" name="usuario" id="usuario"><br>
                                Email: <input type="text" name="email" id="email"><br>
                                <input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;">
                            </form>
                            <font color="red">Error. Los administradores lo investigaran.</font>
                        <?php
                }
                
                
            }
        }else{
            $hash = $_GET["h"];
            
            $datosHash = getDatosHashRecuperarPassword($hash);
            $usuario = $datosHash["usuario"];
            $fecha = $datosHash["fecha"];
            $id = $datosHash["id"];
            
            
            $phpdate = strtotime( $fecha );
            $fechaConsulta = date( 'Y-m-d H:i:s', $phpdate );
            
            
            $ahora = date("Y-m-d H:i:s");

            
            $minutos =  round(abs(strtotime($ahora) - strtotime($fechaConsulta))/60);
            
            if($usuario==null){
                echo "Codigo de recuperacion incorrecto.";
            }else{
            
            
                if($minutos < 60){




                ?>
                    <script>

                    function cambiarPassword() {

                        $.ajax({
                            type: "POST",
                            url: "acciones/cambiar_password.php",
                            data: $("#formCambiarPassword").serialize(),
                            success: function(msg){
                              $("#divPrincipal").html(msg);
                            }
                        });
                    }

                    </script>
                    Nueva contraseña del usuario <b><?php echo $usuario; ?></b><br>
                    <form id="formCambiarPassword">
                        Nueva contraseña: <input type="password" name="password" id="password"><br>
                        <input type="hidden" value="<?php echo $hash; ?>" name="hash" id="hash">
                        <input type="submit" value="enviar" onclick="cambiarPassword(); return false;">
                    </form>

                <?php

                }else{
                    echo "El codigo de cambio de contraseña ha caducado. Para cambiar la contraseña deberá volver a solicitar el cambio. Recuerde que dispone de 60 minutos para realizar el cambio hasta que caduque el codigo.";
                }
            }
        }
}
    ?>
