<?php


include_once '../../func/secciones.php';
//session_start();


//if(isset($_SESSION["usr"]) ){
    

$id = $_POST["id"];
$nivel = $_POST["nivel"];
$s = getNiveles($nivel);

echo '
    
    <script>
        function enviarNotificarError(){
                $.ajax({
                    type: "POST",
                    url: "'. $s .'acc/enviar_notificacion_error.php",
                    data: $("#formNotificacionError").serialize(),
                    success: function(msg){
                        $("#divClickAccionPublicacion").html(msg);
                    }   
                });
            return false; 
        }
    </script>
    <b>Notificar error</b><br>
    <form id="formNotificacionError">
        <input type="hidden" name ="id" value="'. $id . '">
        Somos humanos y tambien nos equivocamos!<br>
        ¿Podrías explicarnos brevemente el error? Gracias!<br>
        <textarea name="descripcion" id="descripcion" cols="50" rows="6"></textarea><br>
        <input type="submit" value="enviar" onclick="javascript:enviarNotificarError(); return false;"><br>
    </form>
        ';

//}else{
//    echo '<script>document.location="index.php"</script>';
//}

?>