<?php


class Noticia {
    
    var $id;
    var $usuario;
    
    var $fecha;
    var $autor;
    var $titulo;
    var $cuerpo;
    
    var $tipo;
    
    function __construct($id, $usuario) {
        $this->id = $id;
        $this->usuario = $usuario;
        
        $this->fecha = getFechaUltimaModificacionNoticia($id);
        $this->titulo = getTituloNoticia($id);
        $this->cuerpo = getCuerpoNoticia($id);
        $this->tipo = getTipoNoticia($id);
        
        
    }
    
    
    
    function getHtml(){
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    function getTabla(){
        
        
        switch ($this->tipo) {
            case 3:
                    $extra = $this->getBotonCerrar();

                break;
            case 4:
                    $extra = $this->getAceptarTerminos();

                break;

            default:
                break;
        }
        
        

        $salida = '
            

            <div id="divNoticia'. $this->id . '" class="div-contenedor-noticia">
                <h1>'. $this->titulo . ' </h1>
                <p class="div-texto-noticia">
                   ' . nl2br($this->cuerpo) . '
                       <br>'. $extra . '<br>
                </p>
                  
            </div>

        ';
        
        return $salida;

    }
    
    
    function getBotonCerrar(){
        $salida = '
            <div align="center">
                <form style=""  id="formMarcarCerrada'. $this->id . '">
                <input type="hidden" name="id" value="'  . $this->id . '">
                <input type="submit" value="Cerrar" onclick="javascript:marcarCerradaNoticia' . $this->id . '(); return false;">
                </form>
                <script>
                    function marcarCerradaNoticia' . $this->id . '() {
                        
                        $.ajax({
                            type: "POST",
                            url: "acciones/marcar_cerrada_noticia.php",
                            data: $("#formMarcarCerrada'. $this->id . '").serialize(),
                            success: function(msg){
                                $("#divNoticia'. $this->id . '").html(msg);
                            }
                        });

                    }


                </script>
           </div>

                         ';
        return $salida;
    }
    
    function getAceptarTerminos(){
        $salida = '
            <div align="center">
                <form style=""  id="formAceptarTerminos'. $this->id . '">
                <input type="checkbox" id="checkNoticia'. $this->id . '" name="check'. $this->id . '" value="e">  Entiendo y acepto los terminos expuestos  
                <input type="hidden" name="id" value="'  . $this->id . '">
                <input type="submit" id="btnNoticia'. $this->id . '" value="Cerrar" onclick="javascript:aceptarTerminosNoticia' . $this->id . '(); return false;">
                </form>
                <script>
                    document.getElementById("btnNoticia'. $this->id . '").disabled = true; 
                    $("#checkNoticia'. $this->id . '").change(function() {
                       
                       if($(this).is(":checked")) {
                            
                            document.getElementById("btnNoticia'. $this->id . '").disabled = false;  
                       }else{
                            
                            document.getElementById("btnNoticia'. $this->id . '").disabled = true;  
                       }
                    }); 



                    function aceptarTerminosNoticia' . $this->id . '() {
                        
                        
                        $.ajax({
                            type: "POST",
                            url: "acciones/marcar_cerrada_noticia.php",
                            data: $("#formAceptarTerminos'. $this->id . '").serialize(),
                            success: function(msg){
                                $("#divNoticia'. $this->id . '").html(msg);
                            }
                        });

                    }


                </script>
           </div>

                         ';
        return $salida;
    }
    

}
