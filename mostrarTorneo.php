<?php
	session_start();
		if (isset($_SESSION['tipo'])){
		if ($_SESSION['tipo']!=1){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
	if (isset($_REQUEST['nombre'])) {

		    $hostname = 'localhost';

		    $username = 'root';

		    $password = '';
		    
		    try {
		        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=deportes", $username, $password);
		      
		        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        
		        $stmt = $dbh->prepare("DELETE FROM torneo WHERE nombre=:nombre");
		        
		        $stmt->bindParam(':nombre', $_REQUEST['nombre'], PDO::PARAM_STR, 10);

		        $stmt->execute();   

		        $dbh = null;
		    }
		    catch(PDOException $e) {
		        echo $e->getMessage();
		    }
	}

?>
<!DOCTYPE HTML>
<html lang='es'>
	<?php include 'head.php'; ?>
<body role="document">
	<?php include 'cabecera.php'; ?>
	<br>
	<br>
	<div class="container-fluid col-md-6 col-md-offset-3">
		<div class="panel panel-info">
			  <div class="panel-body">
			  	<table class="table table-hover">
			  			<thead>
							<tr>
								<th>Nombre</th>
								<th>Categoría</th> 
								<th>Deporte</th> 
								<th>Eliminar</th>
							</tr>
						</thead>
						<tbody>
<?php

					    $hostname = 'localhost';
					    
					    $username = 'root';

					    $password = '';
					    
					    try {
					        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=deportes", $username, $password);
					        
					        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					        $stmt = $dbh->prepare("SELECT nombre, categoria, deporte FROM torneo WHERE Activo=1 ");

					        $stmt->execute();

					        $result = $stmt->fetchAll();

					        foreach ($result as $row) {
					            ?>
					            			<tr>
												<td><?=$row ["nombre"]?></td><td><?=$row ["categoria"]?></td><td><?=$row ["deporte"]?></td>
												<td><a <?="href='mostrarTorneo.php?nombre=".$row ["nombre"]."'"?> onclick="return confirm('¿Está seguro?');">Eliminar</a></td>
											</tr>
					        <?php
                            }
					        $dbh = null;
					    }
					    catch(PDOException $e) {
					        echo $e->getMessage();
					    }
				?>
					

							
						</tbody>
					</table>
			  </div>
		</div>
	
	</div>
	<footer>

	</footer>
</body>
</html>
