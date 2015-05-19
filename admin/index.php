<!DOCTYPE html>
<?php
include_once '../func/secciones.php';
include_once '../conf/conf.php';

include_once '../conf/sesion.php';
include_once '../func/usuario.php';
$nivel = 1;

$usuario = $_SESSION["usr"];

if(getNivelUsuario($usuario)<3){
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
                            <h1>Panel de administración</h1>
                            <div id="div-contenido-no-titulo">

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Estadisticas</h1>

                                    </div>
                                    <div style="margin-left: 40px">

                                        <div id="divUsuariosRegistrados">

                                        </div>

                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Publicaciones</h1><br>

                                    </div>
                                    <div style="margin-left: 40px">


                                        <div onclick="window.location='s/publicaciones_pendientes.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/publicacion.png" align="center" height="60px" width="60px">
                                            <br>Pendientes
                                            </div>
                                        </div>

                                        <div onclick="window.location='s/publicaciones_aprobadas.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img src="../images/header/publicacion.png" align="center" height="60px" width="60px">
                                            <br>Aprobadas
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Usuarios</h1><br>

                                    </div>
                                    <div style="margin-left: 40px">
                                        <div onclick="window.location='s/grupos.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/amigos.png" align="center" height="60px" width="60px">
                                            <br>Grupos</div>
                                        </div>
                                        <div onclick="window.location='s/nicks.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/amigos.png" align="center" height="60px" width="60px">
                                            <br>Nicks</div>
                                        </div>
                                        <div onclick="window.location='s/.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/amigos.png" align="center" height="60px" width="60px">
                                            <br>Login</div>
                                        </div>
                                        <div onclick="window.location='s/.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/eliminar.png" align="center" height="60px" width="60px">
                                            <br>Eliminar</div>
                                        </div>
                                        <div onclick="window.location='s/rehabilitar_cuenta.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/amigos.png" align="center" height="60px" width="60px">
                                            <br>Restaurar</div>
                                        </div>
                                        <div onclick="window.location='s/crear_usuario.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/amigos.png" align="center" height="60px" width="60px">
                                            <br>Crear</div>
                                        </div>
                                        <div onclick="window.location='s/confirmar_email.php'" style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/mail.png" align="center" height="60px" width="60px">
                                                <br>Confirmar<br>email</div>
                                        </div>
                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div ><h1>Colecciones</h1><br>
                                    </div>
                                    <div style="margin-left: 40px">
                                        <div onclick="window.location='s/colecciones_pendientes.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/colecciones.png" align="center" height="60px" width="60px">
                                            <br>Pendientes</div>
                                        </div>
                                        <div onclick="window.location='s/colecciones_aprobadas.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/colecciones.png" align="center" height="60px" width="60px">
                                            <br>Aprobadas</div>
                                        </div>
                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Noticias</h1><br>

                                    </div>
                                    <div onclick="window.location='s/noticias.php'"  style="margin-left: 40px">
                                        <div style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/noticias.png" align="center" height="60px" width="60px">
                                            <br>Noticias</div>
                                        </div>

                                    </div>
                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Encuestas</h1><br>

                                    </div>
                                    <div  onclick="window.location='s/encuestas.php'" style="margin-left: 40px">
                                        <div style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/encuestas.png" align="center" height="60px" width="60px">
                                            <br>Encuestas</div>
                                        </div>

                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Publicidad</h1><br>

                                    </div>
                                    <div  onclick="window.location='s/publicidad.php'"  style="margin-left: 40px">
                                        <div style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/publi.png" align="center" height="60px" width="60px">
                                            <br>Publicidad</div>
                                        </div>

                                    </div>


                                </div>



                                <div  class="div-contenedor-estandar">

                                    <div><h1>Admin</h1><br>

                                    </div>
                                    <div style="margin-left: 40px">
                                        <div onclick="window.location='s/llaves.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img   src="../images/header/llaves.png" align="center" height="60px" width="60px">
                                            <br>Llaves</div>
                                        </div>
                                        <div onclick="window.location='s/mensaje.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/mensaje.png" align="center" height="60px" width="60px">
                                            <br>Mensaje</div>
                                        </div>
                                        <div onclick="window.location='s/notificacion.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/notificacion.png" align="center" height="60px" width="60px">
                                            <br>Notificacion</div>
                                        </div>
                                        <div onclick="window.location='s/mencion.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/mencion.png" align="center" height="60px" width="60px">
                                            <br>Mencion</div>
                                        </div>
                                    </div>


                                </div>

                                <div  class="div-contenedor-estandar">

                                    <div><h1>Gestion masiva</h1><br>

                                    </div>
                                    <div style="margin-left: 40px">
                                        <div onclick="window.location='s/gm_publicaciones.php'"  style="text-align: center; display: inline-block; margin-right: 20px; cursor: pointer;">
                                            <div><img  src="../images/header/publicacion.png" align="center" height="60px" width="60px">
                                            <br>Publicaciones</div>
                                        </div>

                                    </div>


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

    
</html>


