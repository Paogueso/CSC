<?php

function conectarbase(){

    $hostname = 'localhost';
    $port="3306";
    $username = "root";
    $base='deportes';

    try {
        $dbh = new PDO("mysql:host=".$hostname.";port=".$port.";dbname=".$base, $username);
        
    }
    catch(PDOException $e) {
        echo $e->getMessage();
         $dbh=null;
    }
    return $dbh;
}
?>
    

