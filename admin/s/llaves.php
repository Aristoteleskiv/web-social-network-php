<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/panel_control.php';
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
                            <h1>Llaves maestras</h1>
                            <script>
                            function actualizar(id){

                                $.ajax({
                                       type: "POST",
                                       url: "form/acc/actualizar_regla.php",
                                       data: $("#formRegla"+id).serialize(),
                                       success: function(msg){
                                         alert(msg);
                                       }
                                   });
                           return false; 
                           }
                            </script>
                            <div id="div-contenido-no-titulo">
                                <br>
                                <?php
                                $reglas = getReglas();
                                for($i=0; $i<count($reglas); $i++){
                                    echo   '<form id="formRegla'. $reglas[$i]["id"] . '">
                                         ID: '. $reglas[$i]["id"] . ' - ' .  $reglas[$i]["nombre_regla"] . '<input type="hidden" name="id" id="id" value="'. $reglas[$i]["id"] . '">
                                         <input type="text" name="estado" value="'. $reglas[$i]["estado"] .'" id="estado">
                                         <input type="submit" value="actualizar" onclick="javascript:actualizar('.  $reglas[$i]["id"]  . ');return false;">
                                      </form>
                                     ';
                                }
                                ?>
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
