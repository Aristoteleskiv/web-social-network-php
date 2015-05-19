
<?php

include_once 'config/configuracion.php';
include_once 'funciones/notificaciones.php';
include_once 'clases/notificaciones.php';
include_once 'funciones/usuario.php';
include_once 'funciones/login.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estPreferencias;
    
    
    
    ?>
    
    <script>
        $(document).ready(function() {
                document.title = '6T - Preferencias';
            });
    </script>
    
    
        <br><h1>Preferencias de usuario</h1>
    <br>
    <br>
    
                    <script>
                $(document).ready(function(){
                    var options = {beforeSend: function(){},
                    uploadProgress: function(event, position, total, percentComplete) {
                       $("#divImagenEnPreferencias").html('<?php echo $imagenCargandoHtml; ?><br>' + percentComplete + '%');},
                    success: function(){},
                    complete: function(response) 
                    {
                         $("#divImagenEnPreferencias").html('<img src="images/imagenes_usuarios/' + response.responseText + '">');

                            $.ajax({
                                    type: "POST",
                                    url: "home_izquierda.php",
                                    data: "",
                                    success: function(msg){
                                        $("#divMenu").html(msg);

                                    }
                                });
                    },
                    error: function(){}
                }; 

                $("#formSubir").ajaxForm(options);

                });

                    </script>
                    
                    
                    

        <div  class="div-ajuste-preferencias">

    <div style="text-align: center"><b>Cambiar imagen de usuario</b><br>

        Seleccione una imagen de su ordenador/tablet/smartphone entre los formatos típicos de imagen ('.jpg', '.jpeg', '.gif', '.png').
    </div><br>
        
        
        <div id="divImagenEnPreferencias" style="text-align: center" >
                          <?php
                            $imagen = getImagenDeUsuario($usuario);
                            $path = "images/imagenes_usuarios/"  . $imagen;
                            echo "<img src=\"" . $path . "\">";
                          ?>
        </div>
        <div  style="text-align: center" >
            <form id="formSubir" action="acciones/upload.php" method="post" enctype="multipart/form-data">
                   <input type="file" name="myfile" value="Selecciona..." >

                   <input type="hidden" name="MAX_FILE_SIZE" value="100000" /><br>
                    <input type="submit" id="btnPreferenciasCambiarFoto" value="Cambiar foto">
                </form>
            <script type="text/javascript">
            document.getElementById("btnPreferenciasCambiarFoto").disabled = true; 
            $(function() {
               $("input:file").change(function (){
                   document.getElementById("btnPreferenciasCambiarFoto").disabled = false; 
               });
            });
            </script>
            
        </div>

               
    </div>
                                  
    <div  class="div-ajuste-preferencias">
        <div class="div-descripcion-ajuste" ><b>Estado de la cuenta</b>: </div>
        <div id="divEstadoDeCuentaDeCorreo" style="text-align: right; ">
            <?php
            $confirmado = comprobarSiUsuarioConfirmado_usuario($usuario);
            if($confirmado){
                echo "Confirmado";
            }else{
                echo "No confirmado";
            }
            ?>

        </div>
        
    </div>
                    
    <div  class="div-ajuste-preferencias">
        <div class="div-descripcion-ajuste" ><b>Cuenta de correo</b>: si decide cambiar la cuenta de correo deberá de volver a confirmarla para poder comentar en las publicaciones.</div>
        <div id="divPreferenciasUsuarioFormularioCambiarCorreo" style="text-align: right; ">
            
             <?php
            $correo = getEmailUsuario($usuario);
            echo "<b>" . $correo . '</b><form style="display: inline;">
                <input type="button" value="Cambiar" onclick="javascript:cambiarEmail(); return false;">
                </form>';
            $scriptBtnCambiarEmail = '
                <script>
                function cambiarEmail(){
                    
                    $.ajax({
                        type: "POST",
                        url: "formularios/formulario_cambiar_email.php",
                        data: "",
                        success: function(msg){
                            $("#divPreferenciasUsuarioFormularioCambiarCorreo").html(msg);
                        }   
                    });
                    return false; 
                }
                </script>

                

                        ';
            echo $scriptBtnCambiarEmail;
            ?>

        </div>
        
    </div>
         
                    
    <?php
    $confirmado = comprobarSiUsuarioConfirmado_usuario($usuario);
    if(!$confirmado){
        
        ?>
        <div class="div-ajuste-preferencias">
           <div class="div-descripcion-ajuste" ><b>Confirmación de cuenta de correo</b>: es necesario confirmar el correo electronico para poder disfrutar de todos los servicios de 6T, como poder comentar u otros. Para confirmar, se le enviará un correo electronico a su direccion de email con un enlace para confirmar. Asegurese primero de que su correo es el que se indica en la linea superior.</div>
           <div id="divPreferenciasUsuarioFormularioConfirmacionCorreo" style="text-align: right;">
              
               <?php
                $correo = getEmailUsuario($usuario);
                echo '</b><form style="display: inline;">
                    <input type="button" value="Confirmar" onclick="javascript:confirmacionCorreo(); return false;">
                    </form>';
                    $scriptBtnCambiarEmail = '
                    <script>
                    function confirmacionCorreo(){
                        $.ajax({
                            type: "POST",
                            url: "acciones/enviar_correo_confirmacion.php",
                            data: "",
                            success: function(msg){
                                $("#divPreferenciasUsuarioFormularioConfirmacionCorreo").html("Correo enviado. Revise su bandeja de entrada.");
                            }   
                        });
                        return false; 
                    }
                </script>


                        ';
            echo $scriptBtnCambiarEmail;
            ?>

           </div>

        </div>               
        <?php            
    } 
    
    ?>
                    
                    
    <div  class="div-ajuste-preferencias">
        <div class="div-descripcion-ajuste" ><b>Eliminar cuenta</b>: Si decide eliminar la cuenta toda la informacion de su cuenta se perderá de forma definitiva.</div>
        <div id="divPreferenciasUsuarioEliminarCuenta" style="text-align: right; ">
            
             <?php
            $correo = getEmailUsuario($usuario);
            echo "<b>" . $usuario . " | " . $correo . '</b><form style="display: inline;">
                <input type="button" value="Eliminar" onclick="javascript:eliminarCuenta(); return false;">
                </form>';
            $scriptBtnCambiarEmail = '
                <script>
                function eliminarCuenta(){
                    if (confirm("Estas seguro de eliminar el mensaje?")) {
                    $.ajax({
                        type: "POST",
                        url: "acciones/eliminar_cuenta.php",
                        data: "",
                        success: function(msg){
                            $("#divPreferenciasUsuarioEliminarCuenta").html(msg);
                        }   
                    });
                    return false; 
                    }
                }
                </script>

                        ';
            echo $scriptBtnCambiarEmail;
            ?>

        </div>
        
    </div>           
    
                    
                    
                    
    <?php
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
   echo '<script>document.location="index.php"</script>'; 
}






