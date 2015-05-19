
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<?php
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/otras.php';
include_once '../funciones/usuario.php';



session_start();
if(true){
?>


    <html>
    <head  profile="http://www.w3.org/2005/10/profile">
        <title>6T - Confirmar correo</title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="icon" 
        type="image/png" 
        href="images/header/logo_icono.png"></link>
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
            <h1>Confirmacion de correo</h1><br>
        
        
        <?php
            if(!isset($_GET["h"])){
                echo '<script>document.location="../index.php"</script>';
            }else{
                
                $comprobarHas = getDatosHashConfirmacionCorreo($_GET["h"]);
                
                if(count($comprobarHas)>=1){
                    $usuario = $comprobarHas["usuario"];
                    editarEstado($usuario, 1);
                    eliminarSolicitudesConfirmacionCorreo($usuario);
                    echo "Su cuenta de correo se ha verificado. Redireccionando a la pagina de inicio...<br>";
                    echo '<script>window.setInterval(function(){
                                document.location= "../index.php";
                                }, 1500);</script>';
                }else{
                    echo "Error al intentar verificar el correo. El codigo introducido no corresponde con el enviado.";
                }
                
                
                
            }
        ?>
            
            
        </div>
        
        
    </body>
    
</html>    
<?php } ?>  