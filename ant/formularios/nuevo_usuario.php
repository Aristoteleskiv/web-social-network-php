<!DOCTYPE html>

<?php 
include_once '../config/configuracion.php';
include_once '../funciones/login.php';
include_once '../funciones/otras.php';
include_once '../funciones/muro.php';
include_once '../funciones/usuario.php';




session_start();
if(!isset($_SESSION["usr"])){

?>
        
        <script>
             function checkDatosIntroducidos() {
                
                $.ajax({
                    type: "POST",
                    url: "formularios/nuevo_usuario.php",
                    data: $("#formNuevoUsuario").serialize(),
                    success: function(msg){
                      $("#divPrincipal").html(msg);
                    }
                });
            }
        </script>    
        <h1>Formulario para nuevo usuario</h1>
        <?php
        
        
            
        if(!isset($_POST["password"]) OR !isset($_POST["nombre"]) OR !isset($_POST["usuario"]) 
                OR !isset($_POST["sexo"]) OR !isset($_POST["email"]) OR 
                !isset($_POST["ano_nacimiento"])){
            ?>
            

            <form id="formNuevoUsuario">
                    <table>
                        <tr>
                            <td align="right">Nombre y apellido: </td><td><input type="text" name="nombre" id="nombre" ></td>
                        </tr>
                        <tr>
                            <td align="right">Alias: </td><td><input type="text" name="usuario" id="usuario" ></td>
                        <tr>
                            <td align="right">Email: </td><td><input type="text" name="email" id="email" ></td>
                        </tr>
                        <tr>
                            <td align="right">Contraseña: </td><td><input type="password" name="password" id="password"></td>
                        </tr>
                        <tr>
                            <td align="right">Sexo: </td><td>
                                <select name="sexo" id="sexo">
                                <option value="h" >Hombre</option>
                                <option value="m" >Mujer</option>

                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Año de nacimiento: </td><td><select  name="ano_nacimiento" id="ano_nacimiento"><?php
                    $anoActual = date("Y");
                    for($i=$anoActual-6; $i>=1920; $i--){
                        
                        echo "<option value=\"$i\">$i</option>";
                        
                    }
                    ?>
                                </select></td><td></td>
                        </tr>
                        <tr><td align="center" colspan="3"><input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;"></td></tr>

                    </table>


                </form>
        
            <?php
        }else{
            
            
            $password = $_POST["password"];
            $nombre = $_POST["nombre"];
            $usuario = $_POST["usuario"];
            $sexo = $_POST["sexo"];
            $email = $_POST["email"];
            $anoNacimiento = $_POST["ano_nacimiento"];
           
            
            $validacionNombre = validarNombre($nombre);
            $validacionNick = validarNick($usuario);
            $validacionEmail= validarEmail($email);
            $validacionPassword= validarPassword($password);
            
            
            //validacion gramatical
            if(!$validacionNombre or !$validacionNick or !$validacionEmail or !$validacionPassword){
                
                ?>
            
                <form id="formNuevoUsuario">
                    <table>
                        <tr>
                            <td align="right">Nombre y apellido: </td><td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST["nombre"]; ?>"></td><td style="width: 200px">
                                <?php if(!$validacionNombre){
                                      echo '<font color="red">nombre no valido</font>';} ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Alias: </td><td><input type="text" name="usuario" id="usuario"  value="<?php echo $_POST["usuario"]; ?>"></td><td style="width: 200px">
                                <?php if(!$validacionNick){
                                      echo '<font color="red">Alias contiene caracteres no validos o no contiene entre 4 y 20 caracteres</font>';} ?>
                            </td>
                        <tr>
                            <td align="right">Email: </td><td><input type="text" name="email" id="email" value="<?php echo $_POST["email"]; ?>"></td><td style="width: 200px">
                                <?php if(!$validacionEmail){
                                      echo '<font color="red">email no valido</font>';} ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Contraseña: </td><td><input type="password" name="password" id="password"></td><td style="width: 200px">
                                <?php if(!$validacionPassword){
                                      echo '<font color="red">password debe ser de entre 6 y 40 caracteres</font>';} ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Sexo: </td><td>
                                <select name="sexo" id="sexo">
                                <option value="h" <?php if($_POST["sexo"]=="h"){echo "selected";} ?>>Hombre</option>
                                <option value="m" <?php if($_POST["sexo"]=="m"){echo "selected";} ?>>Mujer</option>
                        
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Año de nacimiento: </td><td><select  name="ano_nacimiento" id="ano_nacimiento"><?php
                    $anoActual = date("Y");
                    for($i=$anoActual-6; $i>=1920; $i--){
                        if($i!=$anoNacimiento){
                        echo "<option value=\"$i\">$i</option>";
                        }else{
                            echo "<option selected value=\"$i\">$i</option>";
                        }
                    }
                    ?>
                                </select></td><td></td>
                        </tr>
                        <tr><td align="center" colspan="3"><input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;"></td></tr>
                        
                    </table>
          

                </form>
            
            
            
            
                <?php
                
            }else{
                
                $existeUsuario = comprobarSiUsuarioExiste_Login($usuario);
                $exiteEmail = comprobarSiMailExiste_Login($email);
                
                
                $esvalido = true;
                
               
                
                if($existeUsuario OR  $exiteEmail ){
                    $esvalido = false;
                    ?>

                        <form id="formNuevoUsuario">
                            <table>
                                <tr>
                                    <td align="right">Nombre y apellido: </td><td><input type="text" name="nombre" id="nombre" value="<?php echo $_POST["nombre"]; ?>"></td>
                                </tr>
                                <tr>
                                    <td align="right">Alias: </td><td><input type="text" name="usuario" id="usuario"  value="<?php echo $_POST["usuario"]; ?>"></td>
                                <tr>
                                    <td align="right">Email: </td><td><input type="text" name="email" id="email" value="<?php echo $_POST["email"]; ?>"></td>
                                </tr>
                                <tr>
                                    <td align="right">Contraseña: </td><td><input type="password" name="password" id="password"></td>
                                </tr>
                                <tr>
                                    <td align="right">Sexo: </td><td>
                                        <select name="sexo" id="sexo">
                                        <option value="h" <?php if($_POST["sexo"]=="h"){echo "selected";} ?>>Hombre</option>
                                        <option value="m" <?php if($_POST["sexo"]=="m"){echo "selected";} ?>>Mujer</option>

                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Año de nacimiento: </td><td><select  name="ano_nacimiento" id="ano_nacimiento"><?php
                            $anoActual = date("Y");
                            for($i=$anoActual-6; $i>=1920; $i--){
                                if($i!=$anoNacimiento){
                                echo "<option value=\"$i\">$i</option>";
                                }else{
                                    echo "<option selected value=\"$i\">$i</option>";
                                }
                            }
                            ?>
                                        </select></td><td></td>
                                </tr>
                                <tr><td align="center" colspan="3"><input type="submit" value="enviar" onclick="checkDatosIntroducidos(); return false;"></td></tr>

                            </table>


                        </form>
                         <font color="red">nick o email ya registrados en nuestra base de datos</font>
                         <br>
                         <a href="">link para recuperar password</a>
                    <?php   
                }
                
                
                if($esvalido){
                    
                    $passwordMD5 = md5($password);
                   
                    registrarNuevoUsuario($nombre, $usuario, $email, $passwordMD5, $anoNacimiento, $sexo);
                    actualizarAceptacionTerminosYCondiciones($usuario);
                    addEventoMuro($usuario, "inicio");
                    echo "Ususario registrado correctamente. Se le redirigirá hacia la pagina princial...";
                    ?>
                    <script>
                        setTimeout(function(){

                              $.ajax({
                               type: "POST",
                               url: "formularios/login_inicio.php",
                               
                                data: {usuario:"<?php echo $usuario; ?>",passwordMD5:"<?php echo $passwordMD5; ?>"},
                               success: function(msg){
                               $("#divPrincipal").html(msg);
                               }
                           });



                       }, 1500);
                    </script>    
                             
                    <?php
                }
                
            }
            
            
        }
}
        ?>
        
        
        
        
    
        
  