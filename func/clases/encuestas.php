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
    var $nivel;
    
    
    function __construct($id, $usuario, $nivel) {
        $this->id = $id;
        $this->usuario = $usuario;
        
        $this->fecha = getFechaUltimaModificacionEncuesta($id);
        $this->titulo = getTituloEncuesta($id);
        
        $this->cuerpo = getCuerpoEncuesta($id);
        $this->opciones = getOpcionesEncuesta($id);
        $this->tipo = getTipoEncuesta($id); 
        $this->nivel = $nivel;  
        
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
                
                $txtOp = '<div id="divOpcionesEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta" style="width: 50%;">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        
                                ';
                    $txtOp .= '<div onclick="javascript:votarEncuesta(\''.$this->id.'\',\''.$i.'\',\''.$this->nivel.'\')" class="div-opcion-encuesta" style="width: 40%;">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                break;
            case 2:   //VARIAS OPCIONES
    
                $txtOp = '<div id="divOpcionesEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta" style="width: 60%;">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        
                                ';
                    $txtOp .= '<div onclick="javascript:votarEncuesta(\''.$this->id.'\',\''.$i.'\',\''.$this->nivel.'\')"  class="div-opcion-encuesta" style="width: 30%;">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                
                break;
            case 3:   //0-10
                $txtOp = '<div id="divOpcionesEncuesta'. $this->id . '" class="div-contenedor-opcion-encuesta" style="width: 90%;">';
                for($i=0; $i<count($op); $i++){
                    $txtOp .= '
                        

                                ';
                    $txtOp .= '<div  onclick="javascript:votarEncuesta(\''.$this->id.'\',\''.$i.'\',\''.$this->nivel.'\')"  class="div-opcion-encuesta" style="width: 6%;">' . $op[$i] . "</div>" ;
                }
                $txtOp .= '</div>';

                break;

            default:
                break;
        }
        
        
        
        
        
        $salida = '
            

            <div class="div-contenedor-estandar"  style="margin-bottom:20px;">
                <h2>'. $this->titulo . '</h2>
                <div style="margin-left: 10px; margin-right: 10px;">
                   ' . nl2br($this->cuerpo) . '
                </div><br>
                <div>
                    '. $txtOp . '
                </div>
            </div>

        ';
        
        return $salida;

    }
    

}
