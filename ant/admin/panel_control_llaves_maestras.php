
<?php
include_once '../config/configuracion.php';
include_once '../funciones/panel_control.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
    $usuario = $_SESSION["usr"];
    
    $nivel = getNivelUsuario($usuario);
    
    if($nivel == 3){
        
        
        
    
    $reglas = getReglas();
    ///var_dump($reglas);
    ?>
    
    <h1>Panel de control</h1>
    <br><br>

        <?php
    
        for($i=0; $i<count($reglas); $i++){
            
          
              echo   '<form id="formRegla'. $reglas[$i]["id"] . '">
                        ID: '. $reglas[$i]["id"] . ' - ' .  $reglas[$i]["nombre_regla"] . '<input type="hidden" name="id" id="id" value="'. $reglas[$i]["id"] . '">
                        <input type="text" name="estado" value="'. $reglas[$i]["estado"] .'" id="estado">
                        <input type="submit" value="actualizar" onclick="javascript:actualizar'.  $reglas[$i]["id"]  . '();return false;">
                     </form>
                     <script>
                    
                     function actualizar'.  $reglas[$i]["id"]  . '(){
            
                            $.ajax({
                                   type: "POST",
                                   url: "acciones/actualizar_regla.php",
                                   data: $("#formRegla'.  $reglas[$i]["id"]  . '").serialize(),
                                   success: function(msg){
                                     alert(msg);
                                   }
                               });


                       return false; 
                       }
                       </script>


                    ';
        }
        
        
        
        }
        
        
}
?>
    