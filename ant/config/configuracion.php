<?php


$db_nombre = "web";
$db_dominio = 'localhost';
$db_user = 'administrador';
$db_password = 'Da52es62z5';



$db_nombre = "mysql";
$db_dominio = 'localhost';
$db_user = 'root';
$db_password = 'judes';





try {
    $pdo = new PDO("mysql:host=$db_dominio;dbname=$db_nombre", $db_user, $db_password);
}
catch(PDOException $e){
    echo $e->getMessage();
}  



$numeroResultadosPorPagina = 10;
$numeroResultadosPorPaginaMuro = 20;
$imagenCargandoHtml = '<br><br><div align="center"><img src="images/header/cargando.gif"></div><br><br>';

$numeroDiasParaMostrarNovedadesEnResumenAmigos = 2;


$arrayGruposEspeciales = array("1", "2", "3");
$minutosParaConsiderarOnline = 20;


$numeroImagenesIniciales = 63;

$ApiKeySeguimiento = "27cab65b0707edad3554847a248b7eae582fd10917627b64c74866d634211ba7";


$carpetaRoot = "/home/dani";



$nomCookieMantenerConectado = "k";
$nomCookieAceptarCookies = "a";



$redirectorRecuperarPassword = 1;
$redirectorConfirmarEmail = 2;
$redirectorPublicacionAnonimo = 3;


$estHome = "Home|";
$estIndex = "Index|";
$estAmigos = "Amigos|";
$estBusqueda = "Busqueda|";
$estColecciones = "Colecciones|";
$estGuardadoParaMasTarde = "SavedLater|";
$estMarcadoRealizado = "Realziado|";
$estMenciones = "Menciones|";
$estMensajes = "Mensajes|";
$estMenuAdmin = "MenuAdmin|";
$estNotificaciones = "Notificaciones|";
$estPreferencias = "Preferencias|";
$estPublicacion = "Publicacion|";
$estSobreNosotros = "SobreNosotros|";
$estVistoRecientemente = "VistoReciente|";


$accAceptarTerminos = "AceptarTerminos|";
$accActualizarPrivacidad = "ActualizarPrivacidad|";
$accLoginConMantenerConectado = "LoginConMantenerConectado|";
$accActivarMantenerConectado = "ActivarMantenerConectado|";
$accAceptarCookies = "AceptarCookies|";
$accAceptarSolicitudAmistad = "AceptarSolicitud|";
$accActualizarReglaAdmin = "ActualizarReglaAdmin|";
$accAddNickProhibido = "AddNickProhibido|";
$accCambiarMail = "CambiarMail|";
$accCambiarPassword = "CambiarPassword|";
$accEliminarCuenta = "EliminarCuenta|";
$accEliminarMencion = "EliminarMencion|";
$accEliminarMensaje = "EliminarMensaje|";
$accEliminarNickProhibido = "EliminarNickProhibido|";
$accEliminarNotificacion = "EliminarNotificacion|";
$accEnviarColeccion = "EnviarColeccion|";
$accEnviarComentario = "EnviarComentario|";
$accEnviarCorreoConfirmacion = "EnviarCorreoConfirmacion|";
$accEnviarEncuesta = "EnviarEncuesta|";
$accEnviarGrupo = "EnviarGrupo|";
$accEnviarMensaje = "EnviarMensaje|";
$accEnviarNoticia = "EnviarNoticia|";
$accEnviarNotificacionError = "EnviarNotificacionError|";
$accEnviarPublicacion = "EnviarPublicacion|";
$accEnviarVotoEncuesta = "EnviarVotoEncuesta|";
$accGuardarParaMasTarde = "GuardarParaMasTarde|";
$accMarcarCerradaNoticia = "MarcarCerradaNoticia|";
$accMarcarPublicacionRealizada = "MarcarPublicacionRealizada|";
$accSalir = "Salir|";
$accSolicitudAmistad = "SolicitudAmistad|";
$accUpload = "Upload|";
$accVotarComentario = "VotarComentario|";
$accDescargarPdf = "DescargarPdf|";


$formLoginInicio = "LoginInicio|";
$formLoginRecuperarPassword = "RecuperarPassword|";





$pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};


?>