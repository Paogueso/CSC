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
		        
		        $stmt = $dbh->prepare("UPDATE equipo SET activo= '0' WHERE nombre=:nombre");
		        
		        $stmt->bindParam(':nombre', $_REQUEST['nombre'], PDO::PARAM_STR, 10);
		        
		        $stmt->execute();   
		        
		        $dbh = null;
		    }
		    catch(PDOException $e) {
		        echo $e->getMessage();
		    }
	}

?>
<!doctype html>
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
								<th>Modificar</th>
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
					        
					        $stmt = $dbh->prepare("SELECT Nombre, activo FROM equipo WHERE activo='1'");
					        
					        $stmt->execute();
					        
					        $result = $stmt->fetchAll();
					        
					        foreach ($result as $row) {
					            ?>
					            			<tr>
												<td><?=$row["Nombre"]?></td>
												<td><a <?="href='modificarEquipo.php?nombre=".$row ["Nombre"]."'"?>>Modificar</a></td>
												<td><a <?="href='mostrarEquipo.php?nombre=".$row ["Nombre"]."'"?> onclick="return confirm('¿Está Seguro?');">Eliminar</a></td>
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
