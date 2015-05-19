
<?php

include_once '../config/configuracion.php';
include_once '../WideImage/WideImage.php';
include_once '../funciones/otras.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/muro.php';
include_once '../funciones/usuario.php';

session_start();


if(isset($_SESSION["usr"]) ){
        $usuario = $_SESSION["usr"];
        $_SESSION["acc"] = $accUpload;
        
        
        if($_SESSION["est"]==$estPreferencias){
        
            $output_dir = "../images/imagenes_usuarios/";
            if(isset($_FILES["myfile"])){


                //Filter the file types , if you want.
                if ($_FILES["myfile"]["error"] > 0)
                {
                  echo "Error al cambiar la imagen";
                  $_SESSION["exi"] = 0;
                }
                else
                {
                    $extensionesValidas = array('.jpg', '.jpeg', '.gif', '.png');
                    // get extension of the uploaded file
                    $extensionImagen = strrchr($_FILES['myfile']['name'], ".");
                    // check if file Extension is on the list of allowed ones
                    if (in_array($extensionImagen, $extensionesValidas)) {

                        $nombreImagen = $_FILES["myfile"]["name"];
                        $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);

                        $identificativo = getHashUnicoImagenUsuario();
                        
                        $nombre = $identificativo . ".jpg";

                        $imagen = WideImage::load($_FILES["myfile"]["tmp_name"])
                                ->resize(180, 180, "outside")
                                ->crop("center", "middle", 180, 180)
                                ->saveToFile($output_dir . $nombre);


                        global $pdo;

                        $consulta = $pdo->prepare("UPDATE web.db_usuarios_preferencias SET imagen= :imagen WHERE usuario = :usuario;");
                        $consulta->bindParam(":usuario", $usuario);
                        $consulta->bindParam(":imagen", $nombre);
                        $consulta->execute();

                        addCambioImagenMuro($usuario, $nombre);

                        echo "$nombre";

                        $_SESSION["exi"] = 1;

                    }else{
                        echo "No has seleccionado una imagen";
                        $_SESSION["exi"] = 0;
                    }



                }

            }else{
                 echo "No has seleccionado ninguna!";
                 $_SESSION["exi"] = 0;
            }
        }else{
            $_SESSION["exi"] = -1;
        }
        registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
                $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
}else{
    echo '<script>document.location="../index.php"</script>';
    
} ?>