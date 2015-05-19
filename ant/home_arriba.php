

<script>
            function mostrarResultados(busqueda){
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
                xmlhttp.open("GET","datos/busqueda_flotante.php?busqueda="+busqueda,true);
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
                    document.location="home.php";
                }
             
</script>
<div style="">
    

    <div style="display: inline-block;">     
        <img onclick = "javascript:home();" style="cursor: pointer; margin-right: 100px" src="images/header/logo.png">
        
    </div> 
    


    <div style="display: inline-block; z-index: 10; ">
        
        <form>
            <input autocomplete="off" placeholder="Buscar publicaciones, @usuarios..." 
                   type="text" id="busqueda" name="busqueda"  
                   onkeyup ="javascript:mostrarResultados(this.value)"
                  
                   onclick="javascript:mostrarResultados(this.value);"
                   
                   onblur="javascript:ocultarResultadosClickFuera()"
                   onsubmit=""
                   style="width: 300px; font-size: 16px; "
                   
                   >
            <input type="submit" value="buscar" onclick="javascript:verMas(document.getElementById('busqueda').value); return false;">
            <div id="divFlotanteResultadoBusqueda" style="position: absolute; z-index: 12">

            </div>
        </form>
        
        <script>
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
                    
        </script>
        
    </div>
    
    <div style="display: inline-block; float: right; padding-top: 20px">
        <a href="https://www.youtube.com/channel/UCxhgDAvxPJH-60ElzmoUrlA" target="blank"><img src="images/header/youtube.png" class="imagen-menu-superior"></a>
        <a href="http://twitter.com/seistemas" target="blank"><img src="images/header/twitter.png" class="imagen-menu-superior"></a>
        <a href="http://www.facebook.com/seistemas" target="blank"><img src="images/header/facebook.png" class="imagen-menu-superior"></a>
        <a href="https://plus.google.com/112207412442779869455" target="blank"><img src="images/header/googleplus.png" class="imagen-menu-superior"></a>
    </div>

</div>