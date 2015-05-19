<?php


class Encuesta {
    
    var $id;
    var $usuario;
    
    var $fecha;
    var $autor;
    var $titulo;
    var $cuerpo;
    var $opciones;
    var $tipo;
    
    function __construct($id, $usuario) {
        $this->id = $id;
        $this->usuario = $usuario;
        
        $this->fecha = getFechaUltimaModificacionEncuesta($id);
        $this->titulo = getTituloEncuesta($id);
        $this->cuerpo = getCuerpoEncuesta($id);
        $this->opciones = getOpcionesEncuesta($id);
        $this->tipo = getTipoEncuesta($id); 
                
        
    }
    
    
    
    function getHtml(){
        $salida = $this->getTabla();
        
        return $salida;
    }
    
    
    function getTabla(){
        
        
        
        
        $op = explode("\n", $this->opciones);
        $txtOp = "";
        
        
        switch ($this->tipo) {
            case 1:   //sino
                
                $txtOp = '<div id="divEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta-sino">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        <script>
                        $("#divEncuesta'. $this->id . 'voto'. $i . '").click(function(){

                                $.ajax({
                                    type: "POST",
                                    url: "acciones/enviar_voto_encuesta.php",
                                    data: "id='. $this->id .'&voto='. $i .'&tipo=1",
                                    success: function(msg){
                                      $("#divEncuesta'. $this->id . '").html(msg);
                                    }
                                });

                        return false; 
                        });
                        </script>

                                ';
                    $txtOp .= '<div id="divEncuesta'. $this->id . 'voto'. $i . '" class="div-opcion-encuesta-sino">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                break;
            case 2:   //VARIAS OPCIONES
    
                $txtOp = '<div id="divEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta-varias-opciones">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        <script>
                        $("#divEncuesta'. $this->id . 'voto'. $i . '").click(function(){

                                $.ajax({
                                    type: "POST",
                                    url: "acciones/enviar_voto_encuesta.php",
                                    data: "id='. $this->id .'&voto='. $i .'&tipo=1",
                                    success: function(msg){
                                      $("#divEncuesta'. $this->id . '").html(msg);
                                    }
                                });

                        return false; 
                        });
                        </script>

                                ';
                    $txtOp .= '<div id="divEncuesta'. $this->id . 'voto'. $i . '" class="div-opcion-encuesta-varias-opciones">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                
                break;
            case 3:   //0-10
                $txtOp = '<div id="divEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta-010">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        <script>
                        $("#divEncuesta'. $this->id . 'voto'. $i . '").click(function(){

                                $.ajax({
                                    type: "POST",
                                    url: "acciones/enviar_voto_encuesta.php",
                                    data: "id='. $this->id .'&voto='. $i .'&tipo=1",
                                    success: function(msg){
                                      $("#divEncuesta'. $this->id . '").html(msg);
                                    }
                                });

                        return false; 
                        });
                        </script>

                                ';
                    $txtOp .= '<div id="divEncuesta'. $this->id . 'voto'. $i . '" class="div-opcion-encuesta-010">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                break;

            default:
                break;
        }
        
        
        
        
        
        $salida = '
            

            <div class="div-contenedor-encuesta">
                <h1>'. $this->titulo . ' </h1>
                <p class="div-texto-encuesta">
                   ' . nl2br($this->cuerpo) . '
                       
                </p><br>
                <p>
                    '. $txtOp . '<br>
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
                <input type="checkbox" id="check'. $this->id . '" name="check'. $this->id . '" value="Entiendo y acepto los terminos expuestos">  Entiendo y acepto los terminos expuestos  
                <input type="hidden" name="id" value="'  . $this->id . '">
                <input type="submit" id="btn'. $this->id . '" value="Cerrar" onclick="javascript:aceptarTerminosNoticia' . $this->id . '(); return false;">
                </form>
                <script>
                    document.getElementById("btn'. $this->id . '").disabled = true; 
                    $("#check'. $this->id . '").change(function() {
                       if($(this).is(":checked")) {
                            document.getElementById("btn'. $this->id . '").disabled = false;  
                       }else{
                            document.getElementById("btn'. $this->id . '").disabled = true;  
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
