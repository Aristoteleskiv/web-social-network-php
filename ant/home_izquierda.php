

<?php

include_once 'config/configuracion.php';
include_once 'funciones/usuario.php';
include_once 'funciones/mensajes.php';
include_once 'funciones/notificaciones.php';
include_once 'funciones/menciones_comentarios.php';
include_once 'funciones/usuarios_online.php';

session_start();

if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    
    actualizarFechaUltimaVisita($usuario);

?>

        
        
        
        <script>
            
            
        $('#linkHome').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            
            $("#divCentro").load("contenido.php");
        return false; 
        });
        $('#linkNotificaciones').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            
            $("#divCentro").load("notificaciones.php");
            
        return false; 
        });
        
        
        $('#linkMenciones').click(function(){
            
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("menciones.php");
           
            
        return false; 
        });
        
        $('#linkPreferencias').click(function(){
             $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $("#divCentro").load("preferencias_usuario.php");
              
            return false; 
        
        });
        
        
         
        $('#linkAmigos').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("amigos.php");
             
        return false; 
        });
        $('#linkSalir').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("acciones/salir.php");
            
            
        return false; 
        });
        $('#linkMensajes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("mensajes.php");
            
        return false; 
        });
        
       $('#linkVistoReciente').click(function(){
           $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
           $("#divCentro").load("visto_recientemente.php");
          
        return false; 
        });
         $('#linkGuardadoLater').click(function(){
             $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $("#divCentro").load("guardado_para_mas_tarde.php");
            
        return false; 
        });    
        
        $('#linkMarcadoRealizado').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("marcado_realizado.php");
            
        return false; 
        });   
        
        $('#linkColecciones').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
            $("#divCentro").load("colecciones.php");
            
            
        return false; 
        });  
        
                       
                       
        <?php 
        $nivelUsuario = getNivelUsuario($usuario);
        if($nivelUsuario==3){
            echo ' $("#linkMenuAdministrador").click(function(){
                            
                            $.ajax({
                                   type: "POST",
                                   url: "menu_administrador.php",
                                   data: "",
                                   success: function(msg){
                                     $("#divCentro").html(msg);
                                   }
                               });


                       return false; 
                       });';
        }
        ?>
        
        </script>

        
        <div class="div-contenedora-menus">
            <div class="div-menus">
                <br>
                
                    
                    <div class="elemento-menu">
                        <span id="linkHome"><img src="images/header/home.png" class="imagen-menus">Home</span>
                    </div>
                    
                    <div class="elemento-menu">
                        <span id="linkVistoReciente"><img src="images/header/visto_reciente.png" class="imagen-menus">Visto recientemente</span>
                    </div>
                    
                    <div class="elemento-menu">
                        <span id="linkGuardadoLater"><img src="images/header/guardado_later.png" class="imagen-menus">Guardados para mas tarde</span>
                    </div>
                    <div class="elemento-menu">
                        <span id="linkMarcadoRealizado"><img src="images/header/marcado_realizado.png" class="imagen-menus">Realizados</span>
                    </div>
                <br>
                    <div class="elemento-menu">
                        <span id="linkColecciones"><img src="images/header/colecciones.png" class="imagen-menus">Colecciones</span>
                    </div>
                    <br>
                    <div >
                        <script>
                            function verPerfil(){
                                $("#divCentro").load("amigos.php?p=<?php echo getID($usuario); ?>");
                            }
                        </script>
                        <?php
                            $imagen = getImagenDeUsuario($usuario);
                            $path = "images/imagenes_usuarios/"  . $imagen;
                            echo '<img style="cursor: pointer;" onclick="javascript:verPerfil();" class="imagen-usuario" border="1" src="'. $path . '">';
                            ?>
                        <div class="div-nombre-usuario"><span class="nombre-usuario">@<?php echo $usuario; ?></span></div>
                    </div>
                    
                    <div class="elemento-menu">
                        
                            <span id="linkNotificaciones" ><img src="images/header/notificacion.png" class="imagen-menus">
                            
                            <?php
                                $notificaciones = getNumeroNotificacionesNoVistas($usuario);
                                
                                if($notificaciones>0){
                                    echo 'Notificaciones <div id="divNumeroNotificacionesUsuario" class="notificacion-menu-izquierda" ><span class="numero-cantidad-menu">' . $notificaciones . '</span></div>';
                                }else{
                                    echo 'Notificaciones <div id="divNumeroNotificacionesUsuario"  class="notificacion-menu-izquierda"></div>' ;
                                }
                            ?>
                            </span>
                        
                    </div>
                    
                    <div class="elemento-menu">
                        <span id="linkMensajes"><img src="images/header/mensaje.png" class="imagen-menus">
                            <?php
                                $mensajes = getNumeroMensajesNoVistos($usuario);
                                if($mensajes>0){
                                    echo 'Mensajes <div id="divNumeroMensajesUsuario" class="notificacion-menu-izquierda"><span class="numero-cantidad-menu">' . $mensajes . '</span></div>';
                                }else{
                                    echo 'Mensajes <div id="divNumeroMensajesUsuario" class="notificacion-menu-izquierda"></div>';
                                }
                            ?>
                            </span>
                    </div>
                    
                    <div class="elemento-menu">
                        <span id="linkMenciones"><img src="images/header/mencion.png" class="imagen-menus">      

                                <?php
                                    $menciones = getNumeroMencionesNoVistas($usuario);
                                    
                                    if($menciones>0){
                                    echo 'Menciones  <div id="divNumeroMencionesUsuario" class="notificacion-menu-izquierda"><span class="numero-cantidad-menu">' . $menciones . '</span></div>';
                                    }else{
                                      echo 'Menciones <div id="divNumeroMencionesUsuario" class="notificacion-menu-izquierda"></div>';
                                    }
                                ?>

                            </span>
                    </div>
                    
                    <div class="elemento-menu">
                        <span id="linkAmigos"><img src="images/header/amigos.png" class="imagen-menus">Amigos

                            </span>
                    </div>
                    <br><br>
                    
                    <div class="elemento-menu">
                        <span id="linkPreferencias"><img src="images/header/preferencias.png" class="imagen-menus">Preferencias</span>
                    </div>
                    <?php 
                    $nivelUsuario = getNivelUsuario($usuario);
                    if($nivelUsuario==3){
                        ?>
                        
                        <div class="elemento-menu">
                            <span id="linkMenuAdministrador"><img src="images/header/menu_editor.png" class="imagen-menus">Menu admin</span>
                        </div>
                        
                        <?php
                    }
                    ?>
                        
                        <br><br>
                    
                    <div class="elemento-menu">
                        <span id="linkSalir"><img src="images/header/salir.png" class="imagen-menus">Salir</span>
                    </div>
                        <br>
        
            </div>
        
        </div>
        
<?php }else{
    
}

?>