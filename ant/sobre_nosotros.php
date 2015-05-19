<!DOCTYPE html>


<?php


include_once 'config/configuracion.php';
include_once 'funciones/publicaciones.php';
include_once 'clases/publicaciones.php';
include_once 'funciones/seguimiento.php';
include_once 'funciones/usuarios_online.php';
session_start();


if(isset($_SESSION["usr"]) ){
    
    
    $usuario = $_SESSION["usr"];
    actualizarFechaUltimaVisita($usuario);
    $_SESSION["esta"] = $_SESSION["est"];
    $_SESSION["est"]=$estSobreNosotros;
    
    ?>

<br>
        
      
        <h1>Sobre nosotros</h1><br>
       <script>
        $(document).ready(function() {
                document.title = '6T - Sobre nosotros';
            });
        </script>
        
        <h2>¿Quienes somos?</h2>
        <p>6T somos un grupo de personas que nos gusta enseñar y aprender enseñando. Todos nosotros consideramos que este servicio habría sido de mucha ayuda en algun momento de nuestros estudios en el pasado, y por ello pensamos que puede ser una gran oportunidad de crear una comunidad dedicada a enseñar a futuros jovenes que simplemente quieren enriquecer sus habilidades de cara a su futuro.</p>
        <br><h2>¿Cómo de preparados estamos?</h2>
        <p>En el equipo de 6T estamos todos aquellos que nos gusta hacer algo. El equipo lo forman personas con estudios y personas sin estudios pero con alto dominio en un campo. No buscamos ser formales. No buscamos ser estrictos. Nos equivocaremos en muchos videos de los que hagamos, y seremos poco rigurosos en muchos otros. Pero en Seistemas.com lo que buscamos es acercar nuestras experiencias en un campo a personas interesadas sobre ello. Nos gustaría ser considerados como un complemento a los estudios oficiales de cualquier rama. Nada más.</p>
        <br><h2>¿Es 6T un negocio?</h2>
        <p>Si. A pesar de que los componentes del equipo disfrutamos haciendo esto, también esperamos poder vivir de ello.</p>
        <br><h2>¿Cómo obtenemos beneficios?</h2>
        <p>Por publicidad que se incluirá en la página web y en los videos que subamos. De haber beneficios, nos comprometemos a donar un 10% de los mismos a causas relacionadas con la educacion en nuestro pais.</p>
        <br><h2>¿Qué libertad tienen los usuarios de 6T?</h2>
        <p>Los usuarios pueden hacer lo que ellos quieran tanto con los videos como con los documentos PDFs. No existe ningun tipo de restricción en ese sentido. También se espera que los usuarios se comporten adecuadamente en los foros de cada publicacion. El equipo de 6T no es lo suficientemente grande como para poder dedicar recursos humanos a la vigilancia del buen comportamiento de los usuarios en la pagina web. Es por ello que si se detectase un mal uso por parte de un usuario, nos reservamos el derecho de eliminar la cuenta. Estamos aqui para subir videos y documentos PDFs, no para vigilar el comportamiento de los usuarios.</p>
        <br><h2>¿Cuáles serán nuestras lineas de edición?</h2>
        <p>Por lo general dedicaremos nuestro tiempo a subir videos sobre contenido que notamos sea demandado por los usuarios. Para ello participaremos activamente en los foros de debate y realizaremos encuestas a los usuarios de la página.</p>
        
        <br><h2>¿Tiene usted alguna otra duda?</h2>
        <p>Contacte con nosotros en la direccion contacto@seistemas.com y estaremos encantados de resolverle cualquier duda.</p>
        <br><br>
<?php  
registrarSeguimiento($_SESSION["usr"], $_SESSION["est"], $_SESSION["esta"], $_SESSION["acc"]);


}else{
    echo '<script>document.location="index.php"</script>';
} ?>