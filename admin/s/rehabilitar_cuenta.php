<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/login.php';
include_once '../../func/usuario.php';


if($usuario==null){
    echo codigoRedireccionHome($nivel);
}

?>


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>

    </head>
    <body>
        <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
        
            
            <div id="vertical">
                <aside id="menu">
                
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>

                <section id="contenido">
                    <?php
                    if(getNivelUsuario($usuario)<3){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                            
                        <div class="div-contenido">
                            <h1>Restaurar cuenta eliminada</h1>


                            <div id="div-contenido-no-titulo">
                                <br>
                                <script>

                                function rehabilitarUsuario(){
                                       $.ajax({

                                              type: "POST",
                                              url: "form/acc/rehabilitar_cuenta.php",
                                              data: $("#formRestaurarUsuario").serialize(),
                                              success: function(msg){

                                                $("#divRespuestaRestaurarUsuario").html(msg);
                                              }
                                          });
                                  return false; 
                                  }
                                </script>
                                <div class="div-contenedor-estandar">
                                    <h2></h2>
                                    Introducir el nombre de usuario al que desea rehabilitar la cuenta y su nueva contraseña.
                                    <form id="formRestaurarUsuario">
                                        Usuario sin @: <input type="text" id="nick" name="nick"><br>
                                        Contraseña: <input type="text" id="pass" name="pass"><br>
                                        <input type="submit" value="Confirmar" onclick="javascript:rehabilitarUsuario(); return false;">
                                    </form>
                                    <div id="divRespuestaRestaurarUsuario">

                                    </div>
                                </div>

                            </div>

                        </div>
                    
                        <?php
                    }
                    ?>
                    
                <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
                
            </div>
        
        
        <div>
            <?php echo getScrolls($nivel); ?>
        </div>
        
        
    </body>
