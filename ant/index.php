
<?php 

include_once 'config/configuracion.php';
include_once 'funciones/cookies.php';
include_once 'funciones/seguimiento.php';
session_start();


//sistema de redireccion para servicios

$_SESSION["est"]=$estIndex;
if(isset($_GET["r"])){
            
    
    if($_GET["r"]==null){echo '<script>document.location="index.php"</script>';}else{
        switch ($_GET["r"]) {
            case $redirectorConfirmarEmail:

                echo '<script>document.location="mensajes/mensaje_confirmacion_correo.php?h='. $_GET["h"] . '"</script>';
                break;
            case $redirectorRecuperarPassword:
                echo '<script>document.location="mensajes/cambiar_password.php?h='. $_GET["h"] . '"</script>';
                break;
            case $redirectorRecuperarPassword:
                echo '<script>document.location="mensajes/cambiar_password.php?h='. $_GET["h"] . '"</script>';
                break;
            case $redirectorPublicacionAnonimo:
                if(isset($_SESSION["usr"])){
                    echo '<script>document.location="home.php?p='. $_GET["p"] . '"</script>';

                }else{
                    echo '<script>document.location="mensajes/publicacion.php?p='. $_GET["p"] . '"</script>';
                }
                break;

            default:
                break;
        }
    }
    
    
    if($datosHash!=null){
        editarEstado($datosHash["usuario"], 1);
        echo '$("#divPrincipal").load("h.php?n='. $_GET["h"] .'");';
    }

    echo '$("#divPrincipal").load("h.php?n='. $_GET["h"] .'");';
                    
}elseif(isset($_GET["p"])){
    
    
    if($_GET["p"]==null){echo '<script>document.location="index.php"</script>';}else{
        if(isset($_SESSION["usr"])){
            echo '<script>document.location="home.php?p='. $_GET["p"] . '"</script>';

        }else{
            echo '<script>document.location="mensajes/publicacion.php?p='. $_GET["p"] . '"</script>';
        }
    }
            

    
    
}else{

    
    //cargamos la cookie de mantener conectado
    if(isset($_COOKIE[$nomCookieMantenerConectado])){
        $hash = $_COOKIE[$nomCookieMantenerConectado];
        $usuario = comprobarCookieMantenerConectado($hash);
        $_SESSION["acc"] = $accLoginConMantenerConectado;
        if($usuario==null){
            $_SESSION["exi"] = -1;
            
            //activar alarma para administradores de que algo malo puede estar pasando
        }else{
            $_SESSION["exi"] = 1;
            $_SESSION["usr"] = $usuario;
        }
        registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
                    $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
    }
        
    if(isset($_SESSION["usr"]) ){



        echo '<script>document.location="home.php"</script>';


    }else{

        
        
    ?>

    <html>
        <head profile="http://www.w3.org/2005/10/profile">
            <title>6T - Login</title>
            <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans">
        
        <link rel="icon" 
        type="image/png" 
        href="images/header/logo_icono.png">
        
        
        </head>

        <body style="font-family: 'Open Sans' , sans-serif; font-size: 16px">

            <script src="js/jquery-1.11.0.js"></script>






            <script>
                $(window).load(function() {
                    <?php
                        echo '$("#divPrincipal").load("formularios/login_inicio.php");';
                    ?>

                });
            </script>



            <script>
                 function pagInicio() {$("#divPrincipal").load("formularios/login_inicio.php");}
            </script>    
            <div align="center">
                <img src="images/header/logo.png" onclick="javascript:pagInicio()" style="cursor: pointer;">
                <div id="divPrincipal"></div>
                <!--[if IE]>
                <p>Usted esta usando Internet Explorer. Le informamos de que la pagina web no funcionara correctamente debido a que no disponemos de recursos para implementar este navegador. Para garantizarle un correcto funcionamiento de todas las funciones de la pagina web le recomendamos que descargue otro navegador. Le proponemos uno de los siguientes: <br>
                <a href="http://www.google.es/intl/es/chrome/browser/">Google Chrome</a> || <a href="http://www.mozilla.org/es-ES/firefox/new/">Mozilla Firefox</a> || <a href="http://www.opera.com/es-ES">Opera</a></p>
            <![endif]-->
            </div>



        </body>

    </html>

<?php

    }


} ?>