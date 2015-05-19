<!DOCTYPE html>

<?php
include_once 'config/configuracion.php';
include_once 'funciones/mensajes.php';
include_once 'clases/mensajes.php';
include_once 'funciones/usuario.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
include_once 'funciones/login.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estMensajes;
   
?>

        <br>
        <h1>Mensajes</h1>
        <br>
        <script>
        $(document).ready(function() {
                document.title = '6T - Mensajes';
            });
        </script>
        
        
        
        <?php 
        
        if(isset($_GET["i"])){
            
            
            $id = $_GET["i"];
            $destinatario = getNombreUsuario( $id);
            $imagen = getImagenDeUsuario($destinatario);
            $estadoCuenta = getEstadoCuentaUsuario($destinatario);
            
            
            $_SESSION["est"] .= $destinatario;
            
            if($estadoCuenta==1){
                echo '<script>
                       function verAmigos(str){
                            $("#divCentro").load("amigos.php?pp=" + str);
                            return false; 
                        }
                        function enviar() {
                            $.ajax({
                                type: "GET",
                                url: "acciones/enviar_mensaje.php",
                                data: $("#formEnviarMensaje").serialize(),
                                success: function(msg){
                                  $("#divEnviarMensaje").html(msg);
                                }
                            });

                        }
                    </script>';
            ?>

            <div style="min-height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario">
                <div onclick="javascript:verAmigo('<?php echo $id ?>');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                    <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/<?php echo $imagen ?>">
                    <div class="div-nombre-usuario"><span class="nombre-usuario">@<?php echo $destinatario ?></span></div>
                </div>
                <div style=" width : 100%;margin-top: 10px; margin-left: 20px;"  id="divEnviarMensaje">
                    <div id="divEnviarMensaje">
                        Mensaje: 
                        <form id="formEnviarMensaje">
                            <input type="hidden" name="i" value="<?php echo $id; ?>">
                            <textarea style="width: 60%;" name="c" id="cuerpo" cols="70" rows="8"></textarea><br>
                            <input type="submit" value="Enviar" onclick="javascrip:enviar(); return false;">        
                        </form>
                    </div>

                </div>

            </div>


               <?php
            }else{
                ?>
        
                <div style="overflow: hidden; height: 190px; margin-bottom: 5px;" class="div-contenedor-muro-usuario">
                    <div onclick="javascript:verAmigo('<?php echo $id ?>');" style="cursor: pointer;margin-top: 10px; padding-right: 10px;float: left">
                        <img  style="height: 180px; width: 180px;" src="images/imagenes_usuarios/<?php echo $imagen ?>">
                        <div class="div-nombre-usuario"><span class="nombre-usuario">@<?php echo $destinatario ?></span></div>
                    </div>
                    <div style="margin-top: 10px; margin-left: 20px;"  id="divEnviarMensaje">
                        La cuenta de este usuario ha sido deshabilitada.

                    </div>

                </div>
        
        
                <?php
            }
       }else{
           echo '
               <script>
               function verAmigos(str){
                    $("#divCentro").load("amigos.php?pp=" + str);
                    return false; 
                }
                function enviarMensaje(str){
                    $("#divCentro").load("mensajes.php?i=" + str);
                    return false;
                }
                function eliminarMensaje(str) {
                    if (confirm("¿Estas seguro de eliminar el mensaje?")) {
                        $.ajax({
                            type: "GET",
                            url: "acciones/eliminar_mensaje.php?i=" + str,
                            data: "",
                            success: function(msg){
                                
                                $("#divCentro").load("mensajes.php");
                                
                                
                            }
                        });

                    }
                 }
                </script>
                    ';
           
           
            $mensajes = getMensajes($usuario);
            if(count($mensajes)==0){echo "No tiene ningun mensaje.";}
            for($i=0; $i<count($mensajes); $i++){
                
                $id = $mensajes[$i]["id"];
                $usuario = $mensajes[$i]["usuario"];
                $mandatario = $mensajes[$i]["mandatario"];
                $fecha = $mensajes[$i]["fecha"];
                $estado = $mensajes[$i]["estado"];
                $cuerpo = $mensajes[$i]["cuerpo"];
                $elemento = new Mensaje($id, $usuario, 
                        $mandatario, $fecha, $cuerpo);
                echo $elemento->getHTML();
            }
           

            setTodosMensajesVistos($usuario);
            
       }
        
       
       ?>
        <script>
        $.ajax({
                type: "POST",
                url: "datos/datos_home_izquierda.php",
                data: "t=2",
                success: function(msg){
                    $("#divNumeroMensajesUsuario").html(msg);

                }
            });
        </script>

<?php  
registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
    echo '<script>document.location="index.php"</script>';
}
 ?>