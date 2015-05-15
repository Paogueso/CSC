<?php
	
	if (isset($_POST['nombre']) ) {
	    
	    $hostname = 'localhost';

	    $username = 'root';
	    
	    $password = '';
	    
	    try {
	        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=deportes", $username, $password);

	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt = $dbh->prepare("SELECT Nombre FROM torneo WHERE Nombre = :nombre");
	        $stmt->bindParam(':nombre', trim($_POST['nombre']), PDO::PARAM_STR, 10);

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
