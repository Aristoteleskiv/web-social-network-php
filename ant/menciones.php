<!DOCTYPE html>

<?php
include_once 'config/configuracion.php';
include_once 'funciones/menciones_comentarios.php';
include_once 'clases/menciones.php';
include_once 'funciones/usuario.php';
include_once 'funciones/publicaciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/muro.php';
include_once 'funciones/usuarios_online.php';

session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estMenciones;
    
?>
<br>
        <h1>Menciones
        </h1>
        <script>
        $(document).ready(function() {
                document.title = '6T - Menciones';
            });
            
        function verAmigos(str){
            $("#divCentro").load("amigos.php?pp=" + str);
            return false; 
        }
        function verMencion(idP, pc){
            $("#divPopUp").bPopup({
                follow: [false, false],
                loadUrl: "publicacion.php?id=" + idP + "&pc=" + pc
            });
        }
        function eliminarMencion(str) {
            if (confirm("¿Estas seguro de eliminar la mencion?")) {
                $.ajax({
                    type: "GET",
                    url: "acciones/eliminar_mencion.php?i=" + str,
                    data: "",
                    success: function(msg){

                        $("#divCentro").load("menciones.php");


                    }
                });

            }
         }
        </script>
<br>
        <?php
            $menciones = getMenciones($usuario);
            
            if(count($menciones)==0){echo "No tiene ninguna mencion.";}
            for($i=0; $i<count($menciones); $i++){
                
                $id = $menciones[$i]["id"];
                $idPublicacion = $menciones[$i]["id_publicacion"];
                $usuario = $menciones[$i]["usuario"];
                $mencionador = $menciones[$i]["mencionador"];
                $fecha = $menciones[$i]["fecha"];
                $posicion = $menciones[$i]["posicion"];
                
                $elemento = new Mencion($id,$idPublicacion,  $usuario, 
                        $mencionador, $fecha, $posicion);
                echo $elemento->getHTML();
            }
            setTodasMencionesVistas($usuario);

            
        ?>
        
        
        <script>
            $.ajax({
                    type: "POST",
                    url: "datos/datos_home_izquierda.php",
                    data: "t=3",
                    success: function(msg){
                        $("#divNumeroMencionesUsuario").html(msg);

                    }
                });
        </script>

<?php  

registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);
}else{
   echo '<script>document.location="index.php"</script>'; 
} ?>