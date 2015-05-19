function solicitarAmistad(id, nivel) {
    
    $.ajax({
        type: "GET",
        url: getNiveles(nivel) +  "acc/solicitud_amistad.php",
        data: "i=" + id ,
        success: function(msg){
          $("#divSolcitudAmistad" + id ).html(msg);
          //alert(msg);
          
        }
    });
}


function actualizarPrivacidad( nivel) {
    
    $.ajax({
        type: "GET",
        url: getNiveles(nivel) +  "acc/actualizar_privacidad_muro.php",
        data: $("#formPrivacidadMuro").serialize(),
        success: function(msg){
          $("#divResultadoActualizarPrivacidad").html(msg);
          //alert(msg);
          window.setTimeout(function(){
                document.location = "index.php";
            }, 1500);
        }
    });
}


var desfaseGuardados;
var desfaseRealizados;
var numPublicaciones;
function cargarMas(pag, contenido, nivel, ext){
    var d = "";
    ext = (typeof ext === "undefined") ? "" : ext;
    if(contenido==='3'){
        if((typeof desfaseGuardados === "number") && Math.floor(desfaseGuardados) === desfaseGuardados){
            d="&d="+desfaseGuardados;
        }
    }
    if(contenido==='4'){
        if((typeof desfaseRealizados === "number") && Math.floor(desfaseRealizados) === desfaseRealizados){
            d="&d="+desfaseRealizados;
        }
    }
    
    $.ajax({
       type: "POST",
       url: getNiveles(nivel) + "datos/cargar_mas.php",
       data: "pag=" + pag+"&c=" + contenido+"&n=" + nivel + d + ext,
       success: function(msg){
         $("#pag" + pag).html(msg);
       }
   });
   
   return false;
};

function cargarMasMuro(pag, nivel, usr){
    
    $.ajax({
       type: "POST",
       url: getNiveles(nivel) + "datos/cargar_mas_muro.php",
       data: "pag=" + pag+"&n=" + nivel + "&u=" + usr,
       success: function(msg){
         $("#pag" + pag).html(msg);
       }
   });
   
   return false;
};


function guardarParaMasTarde(id, nivel, des){
    desfaseGuardados = desfaseGuardados +1;
   
    des = (typeof des === "undefined") ? "0" : des;
    
    $.ajax({
    type: "POST",
    url: getNiveles(nivel) + "acc/guardar_para_mas_tarde.php",
    data: "id=" + id + "&nivel=" + nivel,
        success: function(msg){
            
            $("#imgGuardarParaMasTarde"+id).html(msg);
            if(des===1){
                
               $( "#divPublicacionResumen"+id).hide( "slow", function() {
                    
                });
                
            }
        }
    });
    if (desfaseGuardados===numPublicaciones){
        location.reload();
    }
    
   
}
function marcarRealizado(id, nivel, des){
    desfaseRealizados = desfaseRealizados +1;
    des = (typeof des === "undefined") ? "0" : des;
    
    $.ajax({
    type: "POST",
    url: getNiveles(nivel) + "acc/marcar_publicacion_realizada.php",
    data: "id=" + id + "&nivel=" + nivel,
        success: function(msg){
            $("#imgMarcarRealizado"+id).html(msg);
            if(des===1){
                $( "#divPublicacionResumen"+id).hide( "slow", function() {
                    
                });
                
                
            }
        }
    });
     if (desfaseRealizados===numPublicaciones){
        location.reload();
    }
}
function votarEncuesta(id, voto, nivel){
    
    $.ajax({
    type: "POST",
    url: getNiveles(nivel) + "acc/enviar_voto_encuesta.php",
    data: "id=" + id + "&voto=" + voto,
        success: function(msg){
            
            $("#divOpcionesEncuesta"+id).html(msg);
        }
    });
}
var contClickNotificarError=0;
function notificarError(id, nivel){
    if(contClickNotificarError % 2 === 0){
        $.ajax({
        type: "POST",
        url: getNiveles(nivel) + "datos/form/formulario_notificar_error.php",
        data: "id=" + id + "&nivel=" + nivel,
        success: function(msg){
            $("#divClickAccionPublicacion").html(msg);
        }   
    });
    }else{
        $("#divClickAccionPublicacion").html("");
    }
    contClickNotificarError++;
    
}
var contClickAyudaBusquedas=0;
function clickAyudasBusqueda(id, nivel){
    var str;
    if(contClickAyudaBusquedas % 2 === 0){
        str = $("#divContenidoAyudasBusqueda"+id).html();      
        
    }else{
         str = "";
    }
    
    $("#divClickAccionPublicacion").html(str);
    contClickAyudaBusquedas++;

}
var contClickMaterialComplementario=0;
function clickMaterialComplementario(id, nivel){
    var str;
    if(contClickMaterialComplementario % 2 === 0){
        str = $("#divContenidoMaterialComplementario"+id).html();     
    }else{
         str = "";
    }
    $("#divClickAccionPublicacion").html(str);
    contClickMaterialComplementario++;
}
var contClickColecciones=0;
function clickColecciones(id, nivel){
    var str;
    if(contClickColecciones % 2 === 0){
        str = $("#divContenidoColecciones"+id).html();     
    }else{
         str = "";
    }
     
    $("#divClickAccionPublicacion").html(str);
    contClickColecciones++;
}
var contClickHD=0;
function clickHD(id, nivel){
    var str;
    if(contClickHD % 2 === 0){
        str = $("#divContenidoAltaDefinicion"+id).html();     
    }else{
         str = "";
    }
         
    $("#divClickAccionPublicacion").html(str);
    contClickHD++;
}

function getNiveles(nivel){
    text="";
    for (i = 0; i < nivel; i++){     
        text += "../";
    }
    return text;
}


$(document).ready(function() {
        
        $('.masterTooltip').hover(function(){
                var title = $(this).attr('title');
                
                $(this).data('tipText', title).removeAttr('title');
                $('<p class="tooltip"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function() {
                $(this).attr('title', $(this).data('tipText'));
                $('.tooltip').remove();
        }).mousemove(function(e) {
               
                var x = $(this).offset().left - ($('.tooltip').width() - $(this).width())/2;
                var y = $(this).offset().top - $('.tooltip').height() -8 ; 
                
                $('.tooltip')
                .css({ top: y, left: x});
        });
});

function verComentariosPublicacion(id, nivel, filtro){
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) +  "datos/comentarios.php",
        data: "id=" + id + "&nivel=" + nivel + "&filtro="+filtro,
        success: function(msg){
          $("#divComentarios").html(msg);
        }
    });
}

function enviarComentario(id, nivel, filtro) {
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/enviar_comentario.php",
        data: $("#formEnviarComentario").serialize(),
        success: function(msg){
          $("#divFormularioEnviarComentario").html(msg);
            setTimeout(function(){
                  verComentariosPublicacion(id, nivel, filtro);
           }, 2000);
        }
    });
}

function votarComentario(id, posicion, nivel, voto){ 
   
$.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/votar_comentario.php",
        data: "id=" + id + "&nivel=" + nivel + "&p="+posicion+"&voto=" + voto,
        success: function(msg){
           
          $("#divVotar" + posicion).html(msg);
        }
    });
}

function scrollToTop(){
    
    $('html, body').animate({
        scrollTop: $(document).height()
    }, 'fast');
    return false;
}

function scrollToBottom(){
    $('html, body').animate({
        scrollTop:0
    }, 'fast');
    return false;
}

function actualizarNoticiaSubTipo(id, nivel, combo){
    
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) + "datos/form/crear_noticia_tipo.php",
        data: "tipo=" + $(combo).val()+"&id=" + id,
        success: function(msg){
          
          $("#divNoticiaSubTipo").html(msg);

        }
    });
}

function marcarCerradaNoticia(id, nivel) { 
    
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/marcar_cerrada_noticia.php",
        data: "id=" + id,
        success: function(msg){
            $("#divNoticia"+id).html("");
        }
    });

}
function aceptarTerminosNoticia(id, nivel) {
        $.ajax({
            type: "POST",
            url: getNiveles(nivel) + "acc/marcar_cerrada_noticia.php",
            data: "id=" + id,
            success: function(msg){
                $("#divNoticia"+id).html("Términos aceptados");
            }
        });

    }


function cargarFormularioRegistro(nivel){
    
    $.ajax({
    type: "POST",
    url: getNiveles(nivel) + "datos/form/nuevo_usuario.php",
    data: $("#formNuevoUsuario").serialize() + "&n=" + nivel,
        success: function(msg){
            $("#divFormularioNuevoRegistro").html(msg);
        }
    });
}

function cargarFormularioLogin(nivel){
    
    $.ajax({
    type: "POST",
    url: getNiveles(nivel) + "datos/form/login.php",
    data: $("#formLogin").serialize() + "&n=" + nivel,
        success: function(msg){
            $("#divFormularioLogin").html("hola");
        }
    });
}

function aceptarSolicitudAmistad(id,  nivel, idU){ 
 
$.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/aceptar_solicitud_amistad.php",
        data: "id=" + id + "&idU=" + idU,
        success: function(msg){
           //alert(msg);
          $("#divAceptarAmistad" + id).html(msg);
        }
    });
}

function eliminarNotificacion(id,  nivel, tipo){ 
 numNotificacionesEliminadas = numNotificacionesEliminadas +1;
$.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/eliminar_notificacion.php",
        data: "id=" + id + "&t=" + tipo,
        success: function(msg){
            
            if(msg.localeCompare("1")){
                $( "#divNotificacion"+tipo + "_" + id).hide( "slow", function() {    
                 });
             }else{
                 alert("Error");
             }
        }
    });
    if(numNotificacionesEliminadas===numNotificaciones){
        location.reload();
    }
}


function eliminarMensaje(id,  nivel){ 
 numMensajesEliminados = numMensajesEliminados +1;
$.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/eliminar_mensaje.php",
        data: "id=" + id,
        success: function(msg){
            
            if(msg.localeCompare("1")){
                $( "#divMensaje"+ id).hide( "slow", function() {    
                 });
                 
             }else{
                 alert("Error");
             }
        }
    });
    if(numMensajesEliminados===numMensajes){
        location.reload();
    }
}

function enviarMensaje(id, nivel){            
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) +  "acc/enviar_mensaje.php",
        data: $("#formEnviarMensaje").serialize() + "&id=" + id,
        success: function(msg){
            
          $("#divEnviarMensaje").html(msg);
        }
    });
  return false; 
}

function eliminarMencion(id,  nivel){ 
 numMencionesEliminadas = numMencionesEliminadas +1;
$.ajax({
        type: "POST",
        url: getNiveles(nivel) + "acc/eliminar_mencion.php",
        data: "id=" + id,
        success: function(msg){
            
            if(msg.localeCompare("1")){
                $( "#divMencion"+ id).hide( "slow", function() {    
                 });
                 
             }else{
                 alert("Error");
             }
        }
    });
    if(numMencionesEliminadas===numMenciones){
        location.reload();
    }
}


$(document).ready( function() {
    setTimeout( function(){ 
       unloadPopupBox();
    }
   , 5000 );
    loadPopupBox();

    function unloadPopupBox() {    // TO Unload the Popupbox
        $('#popup_box').fadeOut("slow");
        $("#container").css({ // this is just for style        
            "opacity": "1"  
        }); 
    }    

    function loadPopupBox() {    // To Load the Popupbox
        $('#popup_box').fadeIn("slow");
        $("#container").css({ // this is just for style
            "opacity": "0.3"  
        });         
    } 

});
