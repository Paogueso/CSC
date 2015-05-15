<?php
include 'head.php';
	
	if (isset($_POST['contrasena']) ) {
	    
	    $hostname = 'localhost';

	    $username = 'root';
	    
	    $password = '';
	    
	    $pass = validate_password($_POST['contrasena']);
	    
	    try {
	        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=deportes", $username, $password);

	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt = $dbh->prepare("SELECT usuario, contrasena FROM usuario WHERE usuario = :usuario AND contrasena = :contrasena");
	        $stmt->bindParam(':usuario', $_SESSION['usuario'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':contrasena', $pass, PDO::PARAM_STR, 10);

	        $stmt->execute();

	        $result = $stmt->fetchAll();
	        
	        if (count($result) != 0) {
			    echo "si";  
			} else {
			    echo "no";
			}
	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	    }
	}else{
		echo "no if";
	}
?>
