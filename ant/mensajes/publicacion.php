<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<?php
include_once '../config/configuracion.php';
include_once '../clases/publicaciones.php';
include_once '../funciones/publicaciones.php';
include_once '../funciones/otras.php';
include_once '../funciones/usuario.php';



$p = $_GET["p"];
session_start();


if(isset($_SESSION["usr"])){
     echo '<script>document.location="../home.php?p='. $_GET["p"] .'"</script>';
}

if(true){
?>


    <html>
    <head  profile="http://www.w3.org/2005/10/profile">
        <title>6T - Publicacion <?php echo $p ?></title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans"></link>
    <link rel="icon" 
        type="image/png" 
        href="../images/header/logo_icono.png"></link>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css" media="screen" />
    </head>
    
    <body style="font-family: 'Open Sans' , sans-serif; color: #000" >
       
        <script src="../js/jquery-1.11.0.js"></script>
        
        <script src="../js/jquery.form.js"></script>
        <script src="../js/jquery.bpopup.min.js"></script>
       
        
        

         <script>
             function pagInicio() {
                
                document.location= "../index.php";
            }
        </script> 
        <div align="center">
            <img src="../images/header/logo.png" onclick="javascript:pagInicio()" style="cursor: pointer;"><br>
            <br><h1>Publicacion <?php echo $p ?></h1>
            <div stlye="display: inline">Si eres usuario registrado o quieres registrarte <div onclick="javascript:pagInicio()" style="color: #0078e7; cursor: pointer;display: inline;">pulsa aqui</div></div>
            <div stlye="text-align: left;">
        <?php
            
            $elemento = new PublicacionAnonimo($p);
            echo $elemento->getHtml();
            
        ?>
            
            </div>
        </div>
        
        
    </body>
    
</html>    
<?php } ?>  