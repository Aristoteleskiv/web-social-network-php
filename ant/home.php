
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php



include_once 'config/configuracion.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/cookies.php';
include_once 'funciones/otras.php';
session_start();



if(isset($_SESSION["usr"])  ){
    
    
    $usuario = $_SESSION["usr"];
    
    ?>


        <html>
    <head  profile="http://www.w3.org/2005/10/profile">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans"></link>
        <title>6T - Home</title>
        
        <link rel="icon" 
        type="image/png" 
        href="images/header/logo_icono.png"></link>
    </head>
    <body style="font-family: 'Open Sans' , sans-serif; color: #000" >
        <div id="divPopUp">
           
        </div>
        <div id="divPopUpUsuario">
           
        </div>
        
        
            
        
        
        <script src="js/jquery-1.11.0.js"></script>
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.bpopup.min.js"></script>
       
        
        <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
        
        <script>
            <?php 
            //AÑADIR QUE SE HAGA ESTE SCRIPT CUANDO ESTE WINDOWS.READY
            if(isset($_GET["p"])){
                echo '
                     
                    setTimeout(function(){
                        $("#divPopUp").bPopup({
                            follow: [false, false],
                            loadUrl: "publicacion.php?id='. $_GET["p"] .'" 
                        });
                    }, 1000);


                        ';
            }
            
            
            ?>
             
            window.setInterval(function(){
                
                
                $.ajax({
                    type: "POST",
                    url: "datos/datos_home_izquierda.php",
                    data: "t=1",
                    success: function(msg){
                        $("#divNumeroNotificacionesUsuario").html(msg);

                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: "datos/datos_home_izquierda.php",
                    data: "t=2",
                    success: function(msg){
                        $("#divNumeroMensajesUsuario").html(msg);

                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: "datos/datos_home_izquierda.php",
                    data: "t=3",
                    success: function(msg){
                        $("#divNumeroMencionesUsuario").html(msg);

                    }
                });
 
            }, 5000);
           
            
            
            
            
                
            
            
            $(window).load(function() {
                $.ajax({
                    type: "POST",
                    url: "home_izquierda.php",
                    data: "",
                    success: function(msg){
                        $("#divMenu").html(msg);

                    }
                });
                $.ajax({
                    type: "POST",
                    url: "home_arriba.php",
                    data: "",
                    success: function(msg){
                        $("#divArriba").html(msg);

                    }
                });
                $.ajax({
                    type: "POST",
                    url: "contenido.php",
                    data: "",
                    success: function(msg){
                        $("#divCentro").html(msg);

                    }
                });
                
                
                
            });
            
            $(function(){
                
               //reajustamos el ancho de los divs
                var $window = $(window).on('resize', function(){
                   
                    var windowWidth = ((parseInt($(window).width())) ) - 260;
                    
                    $('#divCentro').css({'width':windowWidth  });
                    $('#divArriba').css({'width':windowWidth  });
                    
                    
                    
                }).trigger('resize'); //on page load

            });
            
           
        </script>
        
       
       <?php
        
        if(comprobarCookieAceptarCookies($_COOKIE[$nomCookieAceptarCookies])!=$usuario){
            ?>
            <div id="divMensajeAceptarCookies" class="div-aviso-cookies"><b>Aviso de cookies.</b> En 6T utilizamos cookies para mejorar la experiencia de la pagina. Si utilizas el servicio entonces aceptas el uso que damos de ellas.
            <div id="divBtnAceptarCookies" class="div-boton-aceptar-cookies">Aceptar</div>
            </div>    
            <script>

            $("#divBtnAceptarCookies").click(function (){
                $.ajax({
                        type: "POST",
                        url: "acciones/aceptar_uso_cookies.php",
                        data: "",
                        success: function(msg){
                            $("#divMensajeAceptarCookies").html(msg);
                        }
                    });
            });
            </script>
            <?php
        }
        
        ?>
        
            
        
        <div style="padding-top: 10px;" id="contenedor">
            
            <div id="divMenu" style="float: left; width: 200px;">

            </div>
            <div id="divArriba" style="float: left; margin-left: 20px;">
            
       
            </div>
            <div id="divCentro" style="float: left; margin-left: 20px;">
            
            </div>
        </div>    
            
        
        
        <!--
        
        
        /-->
    </body>
</html>



     <?php
    
    
}else{
    //echo '<script>document.location="index.php"</script>';
    echo '<script>document.location="index.php"</script>';
}



?>





