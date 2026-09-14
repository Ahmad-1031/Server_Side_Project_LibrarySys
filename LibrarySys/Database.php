<?php
    function DBConnection(){
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=librarysys;charset=utf8','root',);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
            return $pdo;
    }catch(PDOException $e){
        echo "Database connetion failed: ".$e->getMessage();
        return;
    }
}

?>
   
    
    
    