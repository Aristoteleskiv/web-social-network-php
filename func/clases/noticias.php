<?php


class Noticia {
    
    var $id;
    var $usuario;
    
    var $fecha;
    var $autor;
    var $titulo;
    var $cuerpo;
    
    var $tipo;
    
    function __construct($id, $usuario, $nivel) {
        
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nivel = $nivel;
        $this->fecha = getFechaUltimaModificacionNoticia($id);
        $this->titulo = getTituloNoticia($id);
        $this->cuerpo =  getCuerpoNoticia($id);
        $this->tipo = getTipoNoticia($id);

    }

    function getHtml(){
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    function getTabla(){
        $extra = "";
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
            <div id="divNoticia'. $this->id . '" class="div-contenedor-estandar" style="margin-bottom:20px;">
                <h2>'. $this->titulo . ' </h2>
                <p style="margin-left: 10px; margin-right: 10px;">
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
                <input type="submit" value="Entendido" onclick="javascript:marcarCerradaNoticia(\''.$this->id.'\',\''.$this->nivel.'\'); return false;">
                </form>
               
           </div>
           ';
        return $salida;
    }
 
    function getAceptarTerminos(){
        $salida = '
            <div align="center">
                <form style=""  id="formAceptarTerminos'. $this->id . '">
                <input type="checkbox" id="checkNoticia'. $this->id . '" name="check'. $this->id . '" value="e">  Entiendo y acepto los terminos expuestos  
                <input type="submit" id="btnNoticia'. $this->id . '" value="Aceptar" onclick="javascript:aceptarTerminosNoticia(\''.$this->id.'\',\''.$this->nivel.'\'); return false;">
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
                </script>
           </div>

                         ';
        return $salida;
    }
    

}
