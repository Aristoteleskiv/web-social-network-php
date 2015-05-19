<?php



include_once '../config/configuracion.php';
include_once '../funciones/publicaciones.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $id = $_POST["id"];
    
    
        $idMat = getIdMaterialComplementarioPublicacion($id);
    if($idMat==0){
        $msg = 'Este contenido no tiene material complementario';
    }else{
        $tipo = getTipoDocumentoPublicacion($idMat);

        $msg = ' 
            <script>
                function verMaterialComplementario(){

                    $.ajax({
                            type: "POST",
                            url: "publicacion.php?id='. $idMat . '",
                            data: "",
                            success: function(msg){

                                $("#divPopUp").html(msg);


                            }   
                    });
                return false; 
                }
            </script>

                    ';

        if($tipo==1){
            $msg .= 'Este material está tambien disponible en formato Video<br>';
        }else{
            $msg .= 'Este material está tambien disponible en formato PDF<br>';
        }

        $msg .= '
            <form>
                <input type="submit" value="ver" onclick="javascript:verMaterialComplementario(); return false;">
            </form>

                ';
    }


    echo '
        <b>Material complementario</b><br>'. $msg . '<br>
        <br>';
    
}else{
    echo '<script>document.location="index.php"</script>';
}





    


?>