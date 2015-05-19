function actualizarNotificaciones(nivel){
       
    $.ajax({
        type: "POST",
        url: getNiveles(nivel) + "datos/notificaciones.php",
        data: "t=1",
        success: function(msg){
            $("#divMenuIzquierdaNumeroNotificaciones").html(msg);

        }
    });

    $.ajax({
        type: "POST",
        url:  getNiveles(nivel) + "datos/notificaciones.php",
        data: "t=2",
        success: function(msg){
            $("#divMenuIzquierdaNumeroMensajes").html(msg);

        }
    });

    $.ajax({
        type: "POST",
        url:  getNiveles(nivel) + "datos/notificaciones.php",
        data: "t=3",
        success: function(msg){
            $("#divMenuIzquierdaNumeroMenciones").html(msg);

        }
    });

};