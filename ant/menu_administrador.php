<!DOCTYPE html>

<?php
        // put your code here
include_once 'config/configuracion.php';
include_once 'funciones/usuario.php';
include_once 'funciones/seguimiento.php';
session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estMenuAdmin;
    
    
    $nivel = getNivelUsuario($usuario);
    if($nivel == 3){
    
    ?>
    <h1>Menu administrador</h1><br>

    <script>
        $(document).ready(function() {
            document.title = '6T - Menu Admin';
        });
        </script>
        
        <script>
        $('#linkPublicidad').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_publicidad.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        });
        $('#linkAdminPublicacionesPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_publicaciones_pendientes.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkAdminPublicacionesAprobadas').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_publicaciones_aprobadas.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkPanelControlLlavesMaestras').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_llaves_maestras.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
                
        $('#linkAdminColeccionesPendientes').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_colecciones_pendientes.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkAdminColeccionesAprobadas').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_colecciones_aprobadas.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkNicksProhibidos').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_nicks_prohibidos.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkNoticias').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_noticias.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        $('#linkEncuestas').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_encuestas.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        $('#linkGrupos').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_grupos.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        $('#linkEliminarUsuario').click(function(){
            $("#divCentro").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "POST",
                    url: "admin/panel_control_eliminar_usuario.php",
                    data: "",
                    success: function(msg){
                      $("#divCentro").html(msg);
                    }
                });
             
            
        return false; 
        }); 
        
        $("#divUsuariosRegistrados").html('<?php echo $imagenCargandoHtml; ?>');

        $.ajax({
            type: "POST",
            url: "datos/previsualizar_grupo.php",
            data: "id=1",
            success: function(msg){
              $("#divUsuariosRegistrados").html(msg);

            }
        });
        
        </script>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Estadisticas</h1><br>

            </div>
            <div style="margin-left: 40px">
                
                <div id="divUsuariosRegistrados">
                    
                </div>
                
            </div>
    
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Publicaciones</h1><br>

            </div>
            <div style="margin-left: 40px">
                
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img id="linkAdminPublicacionesPendientes" src="images/header/publicacion.png" align="center" height="60px" width="60px">
                    <br>Pendientes
                    </div>
                </div>
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img id="linkAdminPublicacionesAprobadas" src="images/header/publicacion.png" align="center" height="60px" width="60px">
                    <br>Aprobadas
                    </div>
                </div>
            </div>
    
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div ><h1>Colecciones</h1><br>
            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkAdminColeccionesPendientes" src="images/header/colecciones.png" align="center" height="60px" width="60px">
                    <br>Pendientes</div>
                </div>
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkAdminColeccionesAprobadas" src="images/header/colecciones.png" align="center" height="60px" width="60px">
                    <br>Aprobadas</div>
                </div>
            </div>
            
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Noticias</h1><br>
                    
            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkNoticias" src="images/header/noticias.png" align="center" height="60px" width="60px">
                    <br>Noticias</div>
                </div>
                
            </div>
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Encuestas</h1><br>

            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkEncuestas" src="images/header/encuestas.png" align="center" height="60px" width="60px">
                    <br>Encuestas</div>
                </div>
                
            </div>
    
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Publicidad</h1><br>

            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkPublicidad" src="images/header/publicidad.png" align="center" height="60px" width="60px">
                    <br>Publicidad</div>
                </div>
                
            </div>
    
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Usuarios</h1><br>

            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkGrupos" src="images/header/amigos.png" align="center" height="60px" width="60px">
                    <br>Grupos</div>
                </div>
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkNicksProhibidos" src="images/header/amigos.png" align="center" height="60px" width="60px">
                    <br>Nicks</div>
                </div>
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkEliminarUsuario" src="images/header/amigos.png" align="center" height="60px" width="60px">
                    <br>Eliminar</div>
                </div>
            </div>
    
    
        </div>
        
        <div  class="div-ajuste-preferencias">

            <div><h1>Admin</h1><br>

            </div>
            <div style="margin-left: 40px">
                <div style="display: inline-block; margin-right: 20px; cursor: pointer;">
                    <div><img  id="linkPanelControlLlavesMaestras" src="images/header/administracion.png" align="center" height="60px" width="60px">
                    <br>Llaves maestras</div>
                </div>
                
            </div>
    
    
        </div>
        

    <?php
    registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
    }
    
}
?>
