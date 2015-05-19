<?php
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/panel_control.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/cookies.php';
include_once '../funciones/otras.php';

$registroAbierto = getRegla(1);


session_start();

$_SESSION["esta"] = $_SESSION["est"];
$_SESSION["est"]= $formLoginInicio;

if(!isset($_SESSION["usr"])){

?>

    <script>
    
        
        function checkUserPass() {

            $.ajax({
                type: "POST",
                url: "formularios/login_inicio.php",
                data: $("#formCampos").serialize(),
                success: function(msg){
                  $("#divPrincipal").html(msg);
                }
            });
        }
        
        
        //funcion link nuevo usuario
        <?php 
        if($registroAbierto==1){echo '
            $("#linkNuevoUsuario").click(function(){
                $("#divPrincipal").load("formularios/nuevo_usuario.php");
                return false; 
            });';}
        ?>
        
        $('#linkPasswordOlvidad').click(function(){
            $("#divPrincipal").load("formularios/login_recuperar_password.php");
        return false; 
        });
    </script>

    <h1>Login</h1> 
        
    <?php
    
    if(!isset($_POST["usuario"])){
        
        ?>
        
        <form id='formCampos'>
        Usuario: <input type="text" name="usuario"  id="usuario"><br>
        Password: <input type="password" name="password" id="password"><br>
        Recordarme en este ordenador<input type="checkbox" name="mantener" value="si"><br>
        <input type="submit" value="Entrar" onclick="javascript:checkUserPass(); return false;">
        
    </form>
    
    <?php 
        if($registroAbierto==1){
            echo '<a href="#" id="linkNuevoUsuario">Nuevo usuario</a><br>';
            
        }else{
            echo 'El registro de nuevos usuarios esta cerrado temporalmente. Disculpen las molestias.<br>';
        }
    ?>
    <a href="#" id="linkPasswordOlvidad">Password olvidado</a>
        
        <?php
        

        
    }else{
        
        $usuario = $_POST["usuario"];
        if(!isset($_POST["passwordMD5"]) AND !isset($_POST["password"])){
            
            //alguien puede estar intentando logearse con otro usuario!!
            //corregir
            
            
        }else{
            if(isset($_POST["passwordMD5"])){
                $password = $_POST["passwordMD5"];
            }else{
                $password = md5($_POST["password"]);
            }
        }

        $comprobar = comprobarUsuarioPassword($usuario, $password);
        
        if($comprobar){
        

                echo "Usuario y contraseña correctos. Redireccionando...";
                
                
                session_start();
                
                $_SESSION["usr"] = $usuario;
                $_SESSION["acc"] = null;
                $ip = $_SERVER['REMOTE_ADDR'];
                registrarSeguimientoIp($usuario, $ip);
                
                if($_POST["mantener"]=="si"){
                    $_SESSION["acc"] = $accActivarMantenerConectado;
                    
                    crearCookieMantenerConectado($usuario);
                    $_SESSION["exi"] = 1;
                    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
                    $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
                    
                    
                }
                //echo $ip;
                
                ?>
                <script>
                    setTimeout(function(){
                         document.location.href = "home.php";
                    }, 1000);

                    </script>    
                             
                 <?php
                
            }else{
                ?>
                    <form id='formCampos'>
                    Usuario: <input type="text" name="usuario"  id="usuario"><br>
                    Password: <input type="password" name="password" id="password"><br>
                    Recordarme en este ordenador<input type="checkbox" name="mantener" value="si"><br>
                    <input type="submit" onclick="javascript:checkUserPass(); return false;">

                    </form>
                    <p style="color: red;">Usuario o contraseña incorrectos</p><br>

                    <?php 
                        if($registroAbierto==1){
                            echo '<a href="#" id="linkNuevoUsuario">Nuevo usuario</a><br>';

                        }else{
                            echo 'El registro de nuevos usuarios esta cerrado temporalmente. Disculpen las molestias.<br>';
                        }
                    ?>
                    <a href="#" id="linkPasswordOlvidad">Password olvidado</a>

               <?php
            }
        
    }
} 
    ?>

