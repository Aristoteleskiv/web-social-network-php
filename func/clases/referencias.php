<?php


class Referencia {
    //put your code here
    
    var $ref;
    var $tipo;
    var $nombre;
    var $refMadre;
    var $refHijas;
    var $refHermanas;
    var $descripcion;
    var $vectorTipo;
    var $usuario;
    var $cadenaReferencias;

    function __construct($usuario, $ref) {
        $this->ref = $ref;
        $this->usuario = $usuario;
        $datosRef = getReferencia($ref);
        $this->tipo = $datosRef["tipo"];
        $this->nombre = $datosRef["nombre"];
        $this->descripcion = $datosRef["descripcion"];
        $this->refMadre = $datosRef["referencia_madre"];
        $this->refHijas = getReferenciasHijas($ref);
        $this->cadenaReferencias = getCadenaReferencias($ref);
        
       
        
        $this->refHermanas = getReferenciasHermanas($ref);
        
        
        $this->vectorTipo = array(
            1 => "Origen",
            2 => "Conjunto",
            3 => "Centro de enseñanza",
            4 => "Comunidad",
            5 => "Año",
            6 => "Curso",
            7 => "Asignatura",
            8 => "Bloque asignatura",

        );
        
    }
    
    
    function getFormularioCrearRefHermana(){
        $nivelUsuario = getNivelUsuario($this->usuario);
        if($this->ref!=1){
            if($nivelUsuario==3){
                $salida = '
                    <script>
                         function crearRefHermana() {

                            $.ajax({
                                type: "POST",
                                url: "formulario_nueva_referencia.php",
                                data: "refMadre='. $this->refMadre .'",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });
                        }

                    </script>

                    <form id="formCrearRefHermana">
                        <input type="submit" value="crear nueva" onclick="javascript:crearRefHermana(); return false;">
                    </form>
                        ';
            }else{
                $salida = "";
            }
        }else{
            $salida = "";
        }
        
        return $salida;
    }
    
    function getFormularioCrearRefHija(){
        $nivelUsuario = getNivelUsuario($this->usuario);
        if($nivelUsuario==3){
            $salida = '
                <script>
                     function crearRefHija() {
                
                        $.ajax({
                            type: "POST",
                            url: "formulario_nueva_referencia.php",
                            data: "refMadre='. $this->ref .'",
                            success: function(msg){
                              $("#divCentro").html(msg);
                            }
                        });
                    }

                </script>
            
                <form id="formCrearRefHermana">
                    <input type="submit" value="crear nueva" onclick="javascript:crearRefHija(); return false;">
                </form>
                    ';
        }else{
            $salida = "";
        }
        
        return $salida;
    }
    
    
    
    function getFormularioEditarReferencia(){
        $nivelUsuario = getNivelUsuario($this->usuario);
        if($nivelUsuario==3){
            $salida = '
                <script>
                     function editarRef() {
                
                        $.ajax({
                            type: "POST",
                            url: "formulario_editar_referencia.php",
                            data: "ref='. $this->ref .'",
                            success: function(msg){
                              $("#divCentro").html(msg);
                            }
                        });
                    }

                </script>
            
                <form id="formEditarRef">
                    <input type="submit" value="editar" onclick="javascript:editarRef(); return false;">
                </form>
                    ';
        }else{
            $salida = "";
        }
        
        return $salida;
    }
    
    
    
    
    function getReferenciaMadre(){
        
        if($this->ref == 1){
            $salida = "Ninguna. Origen de referencias";
        }else{
        
            $salida = '
                <script>
                    $("#linkRefMadre'. $this->refMadre. '").click(function(){

                        $.ajax({
                            type: "POST",
                            url: "referencias.php",
                            data: "ref='. $this->refMadre . '",
                            success: function(msg){
                              $("#divCentro").html(msg);
                            }
                        });
                    return false; 
                    });
                </script>

                    ';
            $salida .= '<span id="linkRefMadre'. $this->refMadre. '" class="referencia">'. getNombreReferencia($this->refMadre) . ' (Ref.' .
                    $this->refMadre . ') </span>
                ';
        }
        return $salida;
    }
    function getReferenciaHermanas(){
        
        if($this->ref == 1){
            $salida = "Ninguna. Origen de referencias";
        }else{
            $salida = "";
            for($i=0; $i<count($this->refHermanas); $i++){
                $salida .= '
                    <script>

                        $("#linkRefHerm'. $this->refHermanas[$i]["referencia"] . '").click(function(){

                            $.ajax({
                                type: "POST",
                                url: "referencias.php",
                                data: "ref='. $this->refHermanas[$i]["referencia"] . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });
                        return false; 
                        });


                    </script>
                        ';
                $salida .= '<span id="linkRefHerm'. $this->refHermanas[$i]["referencia"] . '" class="referencia">'. $this->refHermanas[$i]["nombre"] . ' (Ref.' .
                        $this->refHermanas[$i]["referencia"] . ') '. '</span>
                    ';
            }
        }
        
        return $salida;
    }
    
    function getReferenciaHijas(){
        
     
            $salida = "";
            for($i=0; $i<count($this->refHijas); $i++){
                $salida .= '
                    <script>

                        $("#linkRefHijas'. $this->refHijas[$i]["referencia"] . '").click(function(){

                            $.ajax({
                                type: "POST",
                                url: "referencias.php",
                                data: "ref='. $this->refHijas[$i]["referencia"] . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });
                        return false; 
                        });


                    </script>
                        ';
                $salida .= '<span id="linkRefHijas'. $this->refHijas[$i]["referencia"] . '" class="referencia">'. $this->refHijas[$i]["nombre"] . ' (Ref.' .
                        $this->refHijas[$i]["referencia"] . ') '. '</span>
                    ';
            
            }
        return $salida;
    }
    
    
    function getCadenaReferencias(){
        
        $salida = "";
        for($i=count($this->cadenaReferencias)-1; $i>=0; $i--){
            $salida .= '
                <script>
                    $("#linkRefCadena' .$this->cadenaReferencias[$i]["referencia"] .  '").click(function(){

                            $.ajax({
                                type: "POST",
                                url: "referencias.php",
                                data: "ref='. $this->cadenaReferencias[$i]["referencia"] . '",
                                success: function(msg){
                                  $("#divCentro").html(msg);
                                }
                            });
                        return false; 
                        });

                </script>

                    
                <span id="linkRefCadena' .$this->cadenaReferencias[$i]["referencia"] .  '" class="referencia">'. $this->cadenaReferencias[$i]["nombre"] . '
                (Ref.' .$this->cadenaReferencias[$i]["referencia"] .  ') </span>
                    ';
            if($i>0){$salida .= " -> ";}
        }
        return $salida;
    }
    
    function getHtml(){
        $salida = '
                
                <table>
                <tr>
                    <td align="center">Referencia '. $this->ref . '</td>
                </tr>
                <tr><td align="center"><b><u>Nombre:</u></b> '. $this->nombre .  $this->getFormularioEditarReferencia() .'
                

                </td>
                <tr><td align="center"><b><u>Descripcion:</u></b> '. $this->descripcion . '
                </td>
                </tr>
                <tr><td align="center"><b><u>Tipo:</u></b> '. $this->vectorTipo[$this->tipo] . '
                </td>
                </tr>
                <tr><td align="center"><b><u>Cadena de referencias:</u></b> '. $this->getCadenaReferencias() . '
                </td>
                </tr>
                <tr><td align="center"><b><u>Referencia madre:</u></b> '. $this->getReferenciaMadre() . '

                </td>
                </tr>
                <tr><td align="center"><b><u>Referencias hermanas:</u></b><br> '. $this->getReferenciaHermanas(). '
                <br>' . $this->getFormularioCrearRefHermana() . '
                </td>
                </tr>
                <tr><td align="center"><b><u>Referencias hijas:</u></b><br> '. $this->getReferenciaHijas(). '
                <br>' . $this->getFormularioCrearRefHija() . '
                </td>
                </tr>
                </table>
                
                
                
                
                ';
        
        
        return $salida;
    }
    
}
