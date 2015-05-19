
function mostrarResultadosBusquedaSuperior(busqueda, nivel){
    
    if (busqueda.length==0){ 
      document.getElementById("divFlotanteResultadoBusqueda").innerHTML="";
      document.getElementById("divFlotanteResultadoBusqueda").style.border="0px";
      return;
      }
    if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementById("divFlotanteResultadoBusqueda").innerHTML=xmlhttp.responseText;
        document.getElementById("divFlotanteResultadoBusqueda").style.border="2px solid #000";
        }
      }
    var p = $("#cuadroBusquedaSuperior");
    var position = p.offset();
    var x = position.left + "px";
    var y = (position.top + p.height() + 2) +  "px";
   $("#divFlotanteResultadoBusqueda").css({"top": y, "left": x });
    xmlhttp.open("GET", getNiveles(nivel) + "datos/busqueda_flotante.php?b="+busqueda + "&n=" + nivel,true);
    xmlhttp.send();
    }
    function ocultarResultados(){
        document.getElementById('divFlotanteResultadoBusqueda').innerHTML = '';
        document.getElementById("divFlotanteResultadoBusqueda").style.border="0px";
    }
    function ocultarResultadosClickFuera(){
        setTimeout(function(){
            document.getElementById('divFlotanteResultadoBusqueda').innerHTML = '';
            document.getElementById("divFlotanteResultadoBusqueda").style.border="0px";
           }, 200);
    }
    function home(){
        document.location="index.php";
    }


function clickResultadoBusquedaPublicacion(id){
    $("#divCentro").load("busqueda.php?idp=" + id);
       return false; 
}
function clickResultadoBusquedaColeccion(id){
   $("#divCentro").load("busqueda.php?idc=" + id);
       return false; 
}
function verMas(str){
       var inn = str.substring(0,1);

       if(inn=="@"){
           $("#divCentro").load("amigos.php?b=" + str);
       }else{
           $("#divCentro").load("busqueda.php?b=" + str);
       }
       return false; 
}
function verMasAmigos(str){
       $("#divCentro").load("amigos.php?b=" + str);
       return false; 
}
function verAmigo(str){
       $("#divCentro").load("amigos.php?p=" + str);
       return false; 
}