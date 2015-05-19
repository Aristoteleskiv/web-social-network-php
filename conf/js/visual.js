
$(function(){         
//reajustamos el ancho de los divs
 var $window = $(window).on('resize', function(){
     var windowWidth = ((parseInt($(window).width())) ) - 220;
     var busquedaWidth = windowWidth - 300;
     //var anchoDispo = $('.div-contenedor-botones-orden-comentarios').width();
     
     windowWidth = Math.min(windowWidth, 960);
     //$('#vertical').css({'width':windowWidth  });
     //$('#cuatro-busqueda').css({'width':busquedaWidth });
     //$('.div-cuerpo-comentarios').css({'width':anchoDispo-200 });
     
     //$('#centro').css({'width':windowWidth  });

 }).trigger('resize'); //on page load

});

jQuery(function($) {
  function fixDiv() {
    var $cache = $('#btnScrollToBottom');
    
    
    if ($(window).scrollTop() > 100)
      $cache.css({
        'position': 'fixed',
        'top': '10px',
        'right': '10px',
        'visibility': 'visible'
        
      });
    else
      $cache.css({
        'position': 'relative',
        'top': 'auto',
        'visibility': 'hidden',
        'right': '10px'
        
      });
  var $cache = $('#btnScrollToTop');
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 100)
    $cache.css({
        'position': 'relative',
        'bottom': 'auto',
        'visibility': 'hidden',
        'right': '10px'
      });
  
    else
      $cache.css({
        'position': 'fixed',
        'bottom': '10px',
        'visibility': 'visible',
        'right': '10px'
      });
    
  }
  $(window).scroll(fixDiv);
  fixDiv();
});