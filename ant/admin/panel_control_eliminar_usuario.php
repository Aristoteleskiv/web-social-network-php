
<?php
include_once '../config/configuracion.php';

include_once '../funciones/usuario.php';
include_once '../funciones/login.php';




session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    
    if($nivel == 3){
        
        
        
    
        ///var_dump($reglas);
        ?>

        <h1>Eliminar usuario</h1>
        <br><br>
        
        <script>
        function cargarInfo(){
            $("#divInfo").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "GET",
                    url: "datos/info_usuario.php" ,
                    data: $("#formUsuario").serialize(),
                    success: function(msg){
                      $("#divInfo").html(msg);
                    }
                });
       
        }
        
        function eliminarCuenta(t){
            $("#divInfo").html('<?php echo $imagenCargandoHtml; ?>');
             $.ajax({
                    type: "GET",
                    url: "acciones/eliminar_cuenta.php?t=" + t ,
                    data: $("#formUsuario").serialize(),
                    success: function(msg){
                      $("#divInfo").html(msg);
                    }
                });
       
        }
        
            
        </script>
        
        <form id="formUsuario">
            <input id="u" name="u" type="text">
            <input type="button" onclick="javascript:cargarInfo(); return false;" value="Cargar">
            <div id="divInfo"></div>
            <input type="button" onclick="javascript:eliminarCuenta(1); return false;" value="Desactivar">
            <input type="button" onclick="javascript:eliminarCuenta(2); return false;" value="Eliminar">
        </form>
            <?php
    
        
        
        
    }
        
        
}
?>
    