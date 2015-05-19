<?php
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/usuario.php';



session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    
    if($nivel == 3){
        
        
        
    
    $nicks = getNicksProhibidos();
    ///var_dump($reglas);
    ?>
    
    <h1>Panel de control de nicks prohibidos</h1>
    <br><br>
    <script>
        function eliminar(id){
            $.ajax({
                   type: "POST",
                   url: "acciones/eliminar_nick_prohibido.php",
                   data: $("#formNick" + id).serialize(),
                   success: function(msg){

                     $("#divCentro").load("admin/panel_control_nicks_prohibidos.php")
                   }
               });
       return false; 
       }
       function addNick(){
            $.ajax({

                   type: "POST",
                   url: "acciones/add_nick_prohibido.php",
                   data: $("#formAddNick").serialize(),
                   success: function(msg){

                     $("#divCentro").load("admin/panel_control_nicks_prohibidos.php")
                   }
               });


       return false; 
       }
        
    </script>
        
        <?php
        
        for($i=0; $i<count($nicks); $i++){
            echo '<form id="formNick'. $nicks[$i]["id"] . '">
                      ID: '. $nicks[$i]["id"] . ' - ' .  $nicks[$i]["nick"] . '<input type="hidden" name="id" id="id" value="'. $nicks[$i]["id"] . '">
                      <input type="submit" value="eliminar" onclick="javascript:eliminar('.  $nicks[$i]["id"]  . ');return false;">
                   </form>
                  ';
        }
        
        
        echo '<br>Añadir nick a la lista: <form id="formAddNick">
            Nick: <input type="text" id="nick" name="nick">
            <input type="submit" value="Añadir" onclick="javascript:addNick(); return false;">
        </form>

        ';
        

    }
        
        
}
?>
    