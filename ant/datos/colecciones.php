<?php



include_once '../config/configuracion.php';
include_once '../funciones/colecciones.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    $id = $_POST["id"];
    
    
    $col = getColeccionesDePublicacion($id);
    
    
    if(count($col)==0){
        $msg = "Este problema no se encuentra dentro de ninguna colección todavía.";
    }else{
        $msg = "Este problema se encuentra dentro de las siguientes colecciones:<br> ";
        for($i=0; $i<count($col); $i++){
            $nombre = getNombreColeccion($col[$i]);
            $msg .= '<span onclick="javascript:verColeccionDeEstaPublicacion('.$col[$i].')" class="referencia">' . $nombre . "</span><br>";
        }
        
        
        $msg .= '<script>function verColeccionDeEstaPublicacion(id){
                
                 $.ajax({
                            type: "POST",
                            url: "busqueda.php?idc=" + id,
                            data: "",
                            success: function(msg){
                              $("#divCentro").html(msg);
                              
                                parent.$("#divPopUp").bPopup().close();
                              
                            }
                        });
                        
                        
                    return false; 
            }</script>';
    }

    echo '
        <b>Colecciones.</b><br>'. $msg . '<br>
        <br>';
    
}else{
    echo '<script>document.location="index.php"</script>';
}





    


?>