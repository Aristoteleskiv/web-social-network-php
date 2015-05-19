<!DOCTYPE html>
<?php
include_once '../../func/secciones.php';
include_once '../../conf/conf.php';
include_once '../../conf/sesion.php';

$nivel = 2;
$usuario = $_SESSION["usr"];

include_once '../../func/login.php';
include_once '../../func/usuario.php';



if($usuario==null){
    echo codigoRedireccionHome($nivel);
}
?>


<html lang="es">
    
    <head>
       
        <?php echo getHead($nivel); ?>

    </head>
    <body>
        <header id="header"> 
            <?php echo getPublicidadHead($nivel); ?>
            <?php echo getHeader($nivel); ?>
        </header>
        
            
            <div id="vertical">
                <aside id="menu">
                
                <?php echo getMenu($nivel, $usuario); ?>
                <?php echo getPublicidadMenu1($nivel); ?>    
                <?php echo getPublicidadMenu2($nivel); ?>  
                </aside>

                <section id="contenido">
                    <?php
                    if(getNivelUsuario($usuario)<3){
                        echo codigoRedireccionHome($nivel);
                    }else{
                        ?>
                            <div class="div-contenido">
                                <h1>Crear usuario</h1>
                                <div id="div-contenido-no-titulo">
                                    <div class="div-contenedor-estandar">
                                    <br>
                                    <script>cargarFormularioRegistro('<?php echo $nivel; ?>')</script>
                                    <script>
                                        function rellenar(){
                                                                                var pass = '123456';
                                            var sexo = Array('h','m');
                                            var dominios = Array('hotmail.com','gmail.com','altavista.com','outlook.com',
                                            'outlook.es','seistemas.com','hotmail.es','facebook.com', 'uc3m.es','upm.es');
                                            var apps = Array('diaz','granizo','leon','barrena',
                                            'diez','caballero','blanco','sanchez', 'boza','martin','soto','canete',
                                            'garcia','carcelen','sanchez','patricia', 'pavon','banos','carrera','nozal');
                                            var nombres = Array('dani','alvi','carlos','jesus',
                                            'miguel','tono','antonio','alba', 'toni','david','nando','alex',
                                            'juan','juancarlos','soralla','patricia', 'cristina','jorge','ruben','oscar');
                                            var nombre = nombres[Math.floor(Math.random()*nombres.length)] + ' ' + apps[Math.floor(Math.random()*apps.length)];
                                            var email = nombres[Math.floor(Math.random()*nombres.length)] + apps[Math.floor(Math.random()*apps.length)]+ '@' + dominios[Math.floor(Math.random()*dominios.length)];
                                            var sex = sexo[Math.floor(Math.random()*sexo.length)];

                                            $('#nombre').val(nombre);
                                            $('#email').val(email);
                                            $('#sexo').val(sex);
                                            $('#password').val('123456');
                                            $('#ano_nacimiento').val(1920 + Math.floor(Math.random()*89));

                                        }
                                    </script>
                                    <div id="divFormularioNuevoRegistro">
                                    </div>
                                    <div style="text-align: right;"><div class="div-boton-estandar" onclick="javascript:rellenar()">Rellenar</div></div>
                                    <?php
                                    ?>
                                    </div>
                                </div>

                            </div>
                        
                    
                        <?php
                    }
                    ?>
                    
                <footer id="pie">
                    <?php echo getFooter($nivel); ?>
                </footer>
                </section>
                
            </div>
        
        
        <div>
            <?php echo getScrolls($nivel); ?>
        </div>
        
        
    </body>

