<?php
	session_start();
		if (isset($_SESSION['tipo'])){
		if ($_SESSION['tipo']!=1){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
	if (isset($_REQUEST['usuario'])) {

		    $hostname = 'localhost';
		    
		    $username = 'root';

		    $password = '';
		    
		    try {
		        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=deportes", $username, $password);

		        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        
		        $stmt = $dbh->prepare("DELETE FROM persona WHERE usuario_idusuario=(SELECT idusuario FROM USUARIO WHERE usuario=:usuario);DELETE FROM usuario WHERE usuario=:usuario");
		        
		        $stmt->bindParam(':usuario', $_REQUEST['usuario'], PDO::PARAM_STR, 10);
		        
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
		<div class="panel panel-default">
			  <div class="panel-body">
			  	<table class="table table-hover">
			  			<thead>
							<tr>
								<th>Nombre</th>
								<th>Tipo</th> 
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

					        $stmt = $dbh->prepare("SELECT usuario,tipo FROM usuario WHERE tipo!=1 ");

					        $stmt->execute();

					        $result = $stmt->fetchAll();

					        foreach ($result as $row) {
					            ?>
					            			<tr>
												<td><?=$row ["usuario"]?></td><td><?=$row ["tipo"]==1?"Administrador":""?><?= $row ["tipo"]==2?"Estadístico":""?><?=$row ["tipo"]==3?"Entrenador":""?><?=$row ["tipo"]==4?"Jugador":""?></td>
												<td><a <?="href='modificarUsuario.php?usuario=".$row ["usuario"]."'"?>>Modificar</a></td>
												<td><a <?="href='mostrarUsuario.php?usuario=".$row ["usuario"]."'"?> onclick="return confirm('¿Está seguro?');">Eliminar</a></td>
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
