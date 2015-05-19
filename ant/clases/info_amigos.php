<?php



include_once $_SERVER['DOCUMENT_ROOT'] . '/includes.php';

class ResumenInformacionAmigo {
    
    
    
    function __construct($usuario , $id) {
        global $db_dominio;
        global $db_user;
        global $db_password;
        global $pdo;
    
    try {
            $pdo = new PDO("mysql:host=$db_dominio;dbname=mysql", $db_user, $db_password);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }  
        

        $consulta = $pdo->prepare("SELECT * FROM web.db_usuarios WHERE"
                . " usuario= :usuario ");
        $consulta->bindParam(":usuario", $amigo);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        
    }
    
    
    
}
