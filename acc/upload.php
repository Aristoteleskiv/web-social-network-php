
<?php

include_once '../conf/conf.php';
include_once '../conf/sesion.php';
include_once '../conf/WideImage/WideImage.php';
include_once '../func/otras.php';
include_once '../func/seguimiento.php';
include_once '../func/muro.php';
include_once '../func/usuario.php';



$usuario = $_SESSION["usr"];
$nivel = 1;
//if(isset($_SESSION["usr"]) ){
 if($usuario!=null){  
    $output_dir = "../images/imagenes_usuarios/";
    echo $usuario;
    if(isset($_FILES["myfile"])){
        //Filter the file types , if you want.
        if ($_FILES["myfile"]["error"] > 0){
          echo "Error al cambiar la imagen";

        }else{
            $extensionesValidas = array('.jpg', '.jpeg', '.gif', '.png');
            // get extension of the uploaded file
            $extensionImagen = strrchr($_FILES['myfile']['name'], ".");
            // check if file Extension is on the list of allowed ones
            if (in_array($extensionImagen, $extensionesValidas)) {

                $nombreImagen = $_FILES["myfile"]["name"];
                echo $nombreImagen . "<br>";
                $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);
                echo $extension. "<br>";

                $identificativo = getHashUnicoImagenUsuario();
                echo $identificativo. "<br>";
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

            }else{
                echo "No has seleccionado una imagen";

            }
        }

    }else{
         echo "No has seleccionado ninguna!";

    }
}    
  //     registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], 
  //              $_SESSION["esta"], $_SESSION["acc"], $_SESSION["exi"]);
        
//}else{
//    echo '<script>document.location="../index.php"</script>';
    
//} ?>