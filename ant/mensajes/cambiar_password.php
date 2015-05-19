<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<?php
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/otras.php';
include_once '../clases/publicaciones.php';




if(!isset($_SESSION["usr"])){
?>


    <html>
    <head  profile="http://www.w3.org/2005/10/profile">
        <title>6T - Cambiar password</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans">
   <link rel="icon" 
        type="image/png" 
        href="../images/header/logo_icono.png">
    </head>
    
    <body style="font-family: 'Open Sans' , sans-serif; font-size: 16px">
       
        <script src="../js/jquery-1.11.0.js"></script>
        
        <script src="../js/jquery.form.js"></script>
       
       
        
        <link rel="stylesheet" type="text/css" href="../css/estilos.css" media="screen" />


         <script>
             function pagInicio() {
                
                document.location= "../index.php";
            }
        </script> 
        <div align="center">
            <img src="../images/header/logo.png" onclick="javascript:pagInicio()" style="cursor: pointer;"><br>

      
        
        
        
        <h1>Formulario para recuperar password</h1><br>
        <br>
       <div id="divPrincipal">
            <?php
        if(!isset($_GET["h"])){
            echo '<script>document.location="../index.php"</script>';
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
                            url: "../acciones/cambiar_password.php",
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
                        <input type="submit" value="enviar" onclick="javascript:cambiarPassword(); return false;">
                    </form>

                <?php

                }else{


                    echo "El codigo de cambio de contraseña ha caducado. Para cambiar la contraseña deberá volver a solicitar el cambio. Recuerde que dispone de 60 minutos para realizar el cambio hasta que caduque el codigo.";


                }
            }
        }
        
        ?>
        </div>
    </body>
    
</html>    
        
<?php } ?>    
    
 