<!DOCTYPE html>


    
    
<?php




include_once 'config/configuracion.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuario.php';
include_once 'clases/amigo.php';
include_once 'funciones/notificaciones.php';
include_once 'funciones/otras.php';
include_once 'funciones/muro.php';
include_once 'clases/muro.php';
include_once 'funciones/menciones_comentarios.php';
include_once 'funciones/publicaciones.php';
include_once 'funciones/usuarios_online.php';
include_once 'funciones/login.php';


session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estAmigos;
    
    
?>
        <script>
             $(document).ready(function() {
                document.title = '6T - Amigos';
                 $("#busqueda").select().blur();
                 
            });
            
            function verAmigo(str){
                $("#divCentro").load("amigos.php?p=" + str);
                return false; 
            }
            function enviarMensaje(str){
                $("#divCentro").load("mensajes.php?i=" + str);
                return false;
            }
            function solicitarAmistad(str){
                $("#divSolcitudAmistad" + str).load("acciones/solicitud_amistad.php?i=" + str);
                return false;
            }
            
            function verAmigos(str){
                $("#divCentro").load("amigos.php?pp=" + str);
                return false; 
            }
            function aceptarSolicitud(i, inn) {
               
                    
                    $.ajax({
                       type: "GET",
                       url: "acciones/aceptar_solicitud_amistad.php?i=" + i + "&in=" + inn,
                       data: "",
                       success: function(msg){
                           
                            $("#divAceptarAmistad" + inn).html(msg);
                       }
                   });
               
            }
        </script>

        
       <br> 
       <?php
            
            if(isset($_GET["b"])){
                echo "<h1>Resultados de busqueda de usuario</h1><br>";
                $persona = substr($_GET["b"], 1,  strlen($_GET["b"])-1);
                
                $amigos = busquedaPersonasSoloAmigos($usuario, $persona);
                $pendientes = busquedaPersonasSoloPendientes($usuario, $persona);
                
                $noAmigos = busquedaPersonasSoloNoAmigos($usuario, $persona, 1);
                
                
                
                for($i=0; $i<  count($amigos); $i++){
                    
                    $elemento = new AmigoResumen($usuario, $amigos[$i]["amigo"]);
                    echo $elemento->getHtml();

                }
                for($i=0; $i<  count($pendientes); $i++){
                    
                    $elemento = new PendienteAmigoResumen($usuario, $pendientes[$i]["amigo"]);
                    echo $elemento->getHtml();

                }
                
                for($i=0; $i< min( count($noAmigos), $numeroResultadosPorPagina) ; $i++){
                    $elemento = new PersonaResumen($usuario, $noAmigos[$i]["amigo"]);
                    echo $elemento->getHtml();

                }
                
                if(count($amigos)+count($pendientes)+count($noAmigos) == 0){
                    echo "No se han encontrado resultados";
                }
                
                if(count($noAmigos)>$numeroResultadosPorPagina){
               
                echo '
                    <div id="pag2">
                    <div class="div-contenedor-boton-cargar-mas">
                                <div id="btnCargarMasPersonas" class="div-boton-cargar-mas">Cargar más</div>
                            </div>

                    <script> 
                    $(window).scroll(function() {
                       if($(window).scrollTop() + $(window).height() == $(document).height()) {
                            
                       }
                    });
                    $("#btnCargarMasPersonas").click(function(){

                            $("#pag2").html(\'' . $imagenCargandoHtml . '\');
                            $.ajax({
                               type: "POST",
                               url: "datos/busqueda_personas_mas.php",
                               data: "pag=2&b='. $persona .'",
                               success: function(msg){
                                 $("#pag2").html(msg);
                               }
                           });
                    });


                    </script>
                    </div>';

                }
                
                
            }elseif (isset ($_GET["p"])) {
                
                $idAmigo = $_GET["p"];
                $amigo = getNombreUsuario($idAmigo);
                $elemento = new AmigoMuro($usuario, $amigo);
                echo $elemento->getHTML();
                
            }elseif (isset ($_GET["pp"])){
                
                $amigo = getNombreUsuario($_GET["pp"]);
                
                
                if(sonAmigos($usuario, $amigo)){
                    echo "<h1>Amigos de @" . $amigo . "</h1><br>";
                    
                    $amigos = getAmigosDe($amigo);
                    for($i=0; $i<  count($amigos); $i++){
                        if($amigos[$i]["amigo"]!=$usuario){
                            $elemento = new PersonaAmigoNoAmigoResumen($usuario, $amigos[$i]["amigo"]);
                            echo $elemento->getHtml();
                        }
                    }
                }else{
                    
                    //TERMINAR BIEN. SI NO SON AMIGOS ES PORQUE ALGUIEN ESTA INTENANDO HACER
                    // ALGO MALO
                    echo '<script>document.location="index.php"</script>';
                }
                
                
            }else{
        
    
            
          
          ?>
            



          <h1>Resumen de amigos</h1><br>
            <?php
                $muro = array();
                $cantidad = array();
                $amigos = getAmigosDe($usuario);
                for($i=0; $i<count($amigos); $i++){
                    $linea = array();
                    $linea["amigo"] = $amigos[$i]["amigo"];
                    $linea["cant"] = count(getMuroUltimosXDias($amigos[$i]["amigo"], $numeroDiasParaMostrarNovedadesEnResumenAmigos));
                    $muro[] = $linea;
                    
                }
                
               
                
                $muro = ordenarArrayNumerico($muro, "cant", true);

               
                for($i=0; $i<count($amigos); $i++){
                    $elemento = new AmigoResumen($usuario, $muro[$i]["amigo"]);
                    echo $elemento->getHtml();

                }


            ?>
            
            
            
            
       
 

        <?php  
            }
registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
    echo '<script>document.location="index.php"</script>';
} ?>