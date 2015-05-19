<!DOCTYPE html>
<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';
include_once '../conf/sesion.php';
$nivel = 1;

include_once '../func/usuario.php';
include_once '../func/login.php';
$usuario = $_SESSION["usr"];


if($usuario==null){
    echo codigoRedireccionHome($nivel);
}
?>


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>
        <script src="../conf/js/jquery.form.js"></script>

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
                
                <script>
                $(document).ready(function(){
                    var options = {beforeSend: function(){},
                    uploadProgress: function(event, position, total, percentComplete) {
                       $("#divImagenEnPreferencias").html('<?php echo $imagenCargandoHtml; ?><br>' + percentComplete + '%');},
                    success: function(){},
                    complete: function(response) 
                    {
                        location.reload();
                    },
                    error: function(){}
                }; 
                $("#formSubir").ajaxForm(options);

                });
                
                
           
                </script>
                <section id="contenido">
                    
                    <?php
                    if($usuario==null){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                        <div class="div-contenido">
                        <h1>
                            Preferencias
                        </h1>
                        <div class="div-contenido-no-titulo">
                        <div class="div-contenedor-estandar">
                            <div style="text-align: center;">
                            <h2 style="text-align: left;">Cambiar imagen</h2>
                            <div style="text-align: left;">Seleccione una imagen de su ordenador/tablet/smartphone entre los formatos típicos de imagen ('.jpg', '.jpeg', '.gif', '.png').</div>
                            <div id="divImagenEnPreferencias"><img src="../images/imagenes_usuarios/<?php echo getImagenDeUsuario($usuario); ?>"></div>
                            <form id="formSubir" action="../acc/upload.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="myfile" value="Selecciona..." >
                                <input type="hidden" name="MAX_FILE_SIZE" value="100000" /><br>
                                <input type="submit" id="btnPreferenciasCambiarFoto" value="Cambiar foto">
                             </form>
                            <script>
                            document.getElementById("btnPreferenciasCambiarFoto").disabled = true; 
                            $(function() {
                               $("input:file").change(function (){
                                   document.getElementById("btnPreferenciasCambiarFoto").disabled = false; 
                               });
                            });
                            </script>
                            </div>
                        </div>
                        <div class="div-contenedor-estandar">
                            <h2>Cuenta de correo</h2>
                            Si decide cambiar la cuenta de correo deberá de volver a confirmarla para poder comentar en las publicaciones.
                            <div id="divPreferenciasUsuarioFormularioCambiarCorreo" style="text-align: right; margin-right: 20px;">
            
                            <?php
                            $correo = getEmailUsuario($usuario);
                                ?>
                                   <b><?php echo $correo; ?></b>
                                   <form style="display: inline;">
                                   <input type="button" value="Cambiar" onclick="javascript:cambiarEmail(); return false;">
                                   </form>
                                   <script>
                                   function cambiarEmail(){
                                       $.ajax({
                                           type: "POST",
                                           url: "../datos/form/formulario_cambiar_email.php",
                                           data: "",
                                           success: function(msg){
                                               $("#divPreferenciasUsuarioFormularioCambiarCorreo").html(msg);
                                           }   
                                       });
                                       return false; 
                                   }
                                   </script>
                               
                               <?php
                               ?>
                               
                           </div>
                        </div>
                        <div class="div-contenedor-estandar">
                            <h2>Estado de cuenta</h2>
                            <?php $confirmado = comprobarSiUsuarioConfirmado_usuario($usuario);
                            if($confirmado){
                                echo "Cuenta de correo confirmada.";
                            }else{
                                ?>
                                Es necesario confirmar el correo electronico para poder disfrutar de todos los servicios de la web, como poder comentar u otros. Para confirmar, se le enviará un correo electronico a su direccion de email con un enlace que deberá pinchar. Asegurese primero de que su correo es el que se indica en la linea superior.
                                <div id="divPreferenciasUsuarioFormularioConfirmacionCorreo" style="text-align: right;">
                                    <form style="margin-right: 20px;">
                                <input type="button" value="Confirmar" onclick="javascript:confirmacionCorreo(); return false;">
                                </form>
                                
                                <script>
                                function confirmacionCorreo(){
                                    $.ajax({
                                        type: "POST",
                                        url: "../acc/enviar_correo_confirmacion.php",
                                        data: "",
                                        success: function(msg){
                                            $("#divPreferenciasUsuarioFormularioConfirmacionCorreo").html("Correo enviado. Revise su bandeja de entrada.");
                                        }   
                                    });
                                    return false; 
                                }
                                </script>
                                </div>
                                <?php
                            }        
                                    
                            ?>
                            
                            
                        </div>
                        
                        <div class="div-contenedor-estandar">
                            <h2>Cambiar contraseña</h2>
                            Para cambiar la contraseña es necesario validar primero la anterior.
                            <div id="divPreferenciasUsuarioFormCambiarPassword" style="text-align: right; margin-right: 20px;">
           
                                   <form>
                                   <input type="button" value="Cambiar" onclick="javascript:cambiarPassword(); return false;">
                                   </form>
                                   <script>
                                   function cambiarPassword(){
                                       $.ajax({
                                           type: "POST",
                                           url: "../datos/form/formulario_cambiar_password.php",
                                           data: "",
                                           success: function(msg){
                                               $("#divPreferenciasUsuarioFormCambiarPassword").html(msg);
                                           }   
                                       });
                                       return false; 
                                   }
                                   </script>
                               
                               <?php
                               ?>
                               
                           </div>
                        </div>
                        <div class="div-contenedor-estandar">
                            <h2>Eliminar cuenta</h2>
                            Si decide eliminar la cuenta toda la informacion de su cuenta se perderá de forma definitiva.
                            <div id="divPreferenciasUsuarioFormEliminarCuenta" style="text-align: right; margin-right: 20px;">
                            <form>
                            <input type="button" value="Eliminar" onclick="javascript:eliminarCuenta(); return false;">
                            </form>
                            <script>
                            function eliminarCuenta(){
                                $.ajax({
                                    type: "POST",
                                    url: "../datos/form/formulario_eliminar_cuenta.php",
                                    data: "",
                                    success: function(msg){
                                        $("#divPreferenciasUsuarioFormEliminarCuenta").html(msg);
                                    }   
                                });
                                return false; 
                            }
                            </script>
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

    
</html>




