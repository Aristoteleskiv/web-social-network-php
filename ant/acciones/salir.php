<?php

include_once '../config/configuracion.php';
include_once '../funciones/seguimiento.php';
include_once '../funciones/cookies.php';


session_start();

$usuario = $_SESSION["usr"];
unset($_SESSION["usr"]);

eliminarCookieMantenerConectado($usuario);

echo '<br><div align="center">Desconectando...</div>';
echo '<script>
        setTimeout(function(){
             document.location.href = "index.php";
        }, 2000);

        </script>    ';
