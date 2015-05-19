<?php

function getHead($nivel){

    $n = getNiveles($nivel);

    $salida = '<link rel="stylesheet" href="'. $n .'conf/css/estilos.css"> 
    <link rel="stylesheet" href="'. $n .'conf/css/popup.css"> 
    <meta name="description" content="DESCRIPCION">
    <meta name="keywords" content="palabras, clave">
    <meta >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <script src="'. $n .'conf/js/jquery-1.11.0.js"></script>
    <title>Titulo</title>
    <script src="'. $n .'conf/js/visual.js"></script>
    <script src="'. $n .'conf/js/acciones.js"></script>
    <script src="'. $n .'conf/js/links.js"></script>
    <script src="'. $n .'conf/js/busqueda.js"></script>    
    <script src="'. $n .'conf/js/notificaciones.js"></script>      
    ';

    return $salida;
    
}

function getNiveles($nivel){
    $salida = "";
    for ($i = 0; $i < $nivel; $i++) {
        $salida .= "../";
    }
    
    return $salida;
}

function getHeader($nivel){
    
        $n = getNiveles($nivel);

        $salida = '<noscript>
                        <style type="text/css">
                            .pagecontainer {display:none;}
                        </style>
                        <div class="noscriptmsg">
                        No tiene activado Javascript. Para el correcto uso de esta pagina web es necesario tenerlo activado. Para ello vaya a la configuración de su navegador y actívelo. De lo contrario ni esta ni la mayoria de webs le funcionarán adecuadamente
                        </div>
                    </noscript>
                    <div id="divFlotanteResultadoBusqueda" style="background-color: white; position: absolute; z-index: 12"></div>
                    <div style="margin-top: 16px; width: 190px; display: inline-block; height: 42px;">
                    <img src="'. $n .'images/header/facebook.png" style="margin-left: 10px; opacity: 0.7; width: 32px; margin-right: 5px;">
                    <img src="'. $n .'images/header/twitter.png" style="opacity: 0.7; width: 32px; margin-right: 5px;">
                    <img src="'. $n .'images/header/youtube.png" style="opacity: 0.7; width: 32px; margin-right: 5px;">
                    <img src="'. $n .'images/header/gplus.png" style="opacity: 0.7; width: 32px; margin-right: 5px;">
                    </div>
                    <div class="div-header" style="display: inline-block; vertical-align: top;">
                        <a href="'.$n.'"><img  class="imagen-logo" src="'. $n .'images/header/logo.png"></a>
                        <div class="div-textbox-header">
                            <form action="'.$n.'busqueda" >
                            <input id="cuadroBusquedaSuperior" autocomplete="off" placeholder="Buscar publicaciones, @usuarios..." 
                            type="text" name="b"  
                            onkeyup ="javascript:mostrarResultadosBusquedaSuperior(this.value, '. $nivel .')"
                            onblur="javascript:ocultarResultadosClickFuera()"
                            class="textbox-header">
                            <input type="hidden" name="n" value="'.$nivel.'">  
                            </form>
                        </div>
                    </div>';
        
        
        return $salida;
    
}

function getScrolls($nivel){
    
        $n = getNiveles($nivel);
    
        
        $salida = '
        <div onclick="scrollToBottom()" id="btnScrollToBottom"><img style="cursor: pointer; width: 30px" src="'.$n.'images/header/flecha_arriba.png"></div>
        <div onclick="scrollToTop()" id="btnScrollToTop"><img style="cursor: pointer; width: 30px" src="'.$n.'images/header/flecha_abajo.png"></div>';
        
        return $salida;
    
}

function getPublicidadMenu1($nivel){  
    
        $n = getNiveles($nivel);
        $salida = '
        <div style="margin-top: 20px; height: 982px; width: 200px; color: blue;">
        Publi2. 200 x 982 px
        </div>';
        
        return $salida;
    
}

function getPublicidadMenu2($nivel){  
    
        $n = getNiveles($nivel);
        $salida = '
        <div style="margin-top: 20px; height: 982px; width: 200px; color: blue;">
        Publi3. 200 x 982 px
        </div>';
        
        return $salida;
    
}

function getPublicidadHead($nivel){  
    
        $n = getNiveles($nivel);
        $salida = '
        <div style="width: 982px; height: 100px; color: blue; margin-bottom: 10px;">
        Publi1. 982 x 100 px
        </div>';
        
        return $salida;
    
}

function getPublicidadCargarMas($nivel){  
    
        $n = getNiveles($nivel);
        $salida = '
        <div style="margin-top: 10px; margin-bottom: 10px; width: 768px; height: 100px; color: blue;">
        Publi4. 768 x 100 px
        </div>';
        
        return $salida;
    
}

function getFooter($nivel){
    
    
    $n = getNiveles($nivel);
        
        $salida = 'Seistemas &copy; 2014-2015';
        
        return $salida;
    
}

function getMenu($nivel, $usuario){
    
    $n = getNiveles($nivel);
    if($usuario==null){
        $salida = '
           <div class="div-contenedor-login-lateral">
           Identificate para acceder a tu cuenta
                <div id="divFormularioLoginIzquierda" style="text-align: right;">
                <form id="formLogin" action="'.$n.'user/login/" method="POST">
                <input name="u" id="" autocomplete="off" placeholder="Usuario" type="text" class="textbox-login-izquierda"><br> 
                <input name="p" id="" autocomplete="off" placeholder="Contraseña" type="password" class="textbox-login-izquierda"> 
                Recordarme <input name="r" value="si" type="checkbox" style="margin-right: 9px;">
                <input value="Login" type="submit" style="width: 60px; margin-right: 10px"><br>
                </form>
                </div>
                <div style="text-align: center; margin-top: 20px; color: blue;"><a href="'.$n.'user/recuperar/">No recuerdo mi contraseña</a></div>
                <div style="margin-top: 20px;">¿Aun no tienes cuenta? Registrate en 1 minuto para poder usar todos los servicios de manera gratuita.</div>
                <div style="margin-top: 10px; text-align: center; color: blue;"><a href="'.$n.'user/registro/">Registro</a></div>
           </div>';
        
    }else{
        
        $msgAdmin = "";
        if(getNivelUsuario($usuario)){
            $msgAdmin = '<a href="'.$n.'admin"><div  class="elemento-menu-principal">
                        <span><img src="'. $n .'images/header/menu_editor.png" class="images-menus-principal">Admin</span>
                    </div></a>';
        }
        $imagen = getImagenDeUsuario($usuario);
        
        $scripActualizar = '<script>window.setInterval(function(){actualizarNotificaciones('.$nivel.')}, 15000); actualizarNotificaciones('.$nivel.');</script>';
        
        $salida = $scripActualizar .
                '<div style="margin-left: 10px; margin-top: 10px;">
                    <a href="'.$n.'"><div class="elemento-menu-principal">
                        <span><img src="'. $n .'images/header/home.png" class="images-menus-principal">Home</span>
                    </div></a>
                    <a href="'.$n.'visto"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/visto_reciente.png" class="images-menus-principal">Visto reciente</span>
                    </div></a>
                    <a href="'.$n.'guardado"><div  class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/guardado_later.png" class="images-menus-principal">Guardado</span>
                    </div></a>
                    <a href="'.$n.'realizado"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/marcado_realizado.png" class="images-menus-principal">Realizado</span>
                    </div></a>
                    <br>
                    <a href="'.$n.'colecciones"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/colecciones.png" class="images-menus-principal">Colecciones</span>
                    </div></a>
                    <br>
                    <div class="div-contenedor-estandar" style="margin-left: 10px; height: 180px; width: 188px; position: relative; left: -20px;">
                    <a href="'.$n.'s/muro/"><div style="background-image:  url('.$n.'images/imagenes_usuarios/'. $imagen . '); background-repeat: no-repeat; width:  180px; height: 180px;">
                        <div class="div-nombre-usuario" >@'. $usuario.'</div>
                    </div></a>
                    </div>
                    <br>
                    <a href="'.$n.'s/notificaciones"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/notificacion.png" class="images-menus-principal">Notificaciones</span><div style="float:right; text-align: right; margin-right: 40px;"><span id="divMenuIzquierdaNumeroNotificaciones" class="numero-notificaciones-menu-izquierda"></span></div>
                    </div></a>
                    <a href="'.$n.'s/mensajes"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/mensaje.png" class="images-menus-principal">Mensajes</span><div style="float:right; text-align: right; margin-right: 40px;"><span id="divMenuIzquierdaNumeroMensajes"  class="numero-notificaciones-menu-izquierda"></span></div>
                    </div></a>
                    <a href="'.$n.'s/menciones"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/mencion.png" class="images-menus-principal">Menciones</span><div style="float:right; text-align: right; margin-right: 40px;"><span id="divMenuIzquierdaNumeroMenciones"  class="numero-notificaciones-menu-izquierda"></span></div>
                    </div></a>
                    <a href="'.$n.'s/amigos"><div  class="elemento-menu-principal">
                        <span><img src="'. $n .'images/header/amigos.png" class="images-menus-principal">Amigos</span>
                    </div></a>
                    <br><br>
                    <a href="'.$n.'pref"><div class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/preferencias.png" class="images-menus-principal">Preferencias</span>
                    </div></a>
                    '.$msgAdmin.'
                    <br>
                    <br>
                    <a href="'.$n.'user/logout"><div  class="elemento-menu-principal">
                        <span ><img src="'. $n .'images/header/salir.png" class="images-menus-principal">Salir</span>
                    </div></a>
                    
                </div>';
    }
    
        
        return $salida;
    
}

?>