<?php
	session_start();
	require_once('/PasswordHash.php');
	include 'conn.php';
	$noexiste=false;
	if (isset($_POST['usuario'])) {
		
		$usuario= trim($_POST['usuario']);
		$pass= $_POST['contrasena'];
	    
	    try {
	        $dbh = conectarbase();
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("SELECT usuario,contrasena,tipo,imagen FROM usuario  WHERE usuario = :usuario");
	        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 10);

	        $stmt->execute();

	        $result = $stmt->fetchAll();
	        $noexiste=true;

	        foreach ($result as $row) {

	        	if(strcmp($row['usuario'], $usuario)==0){
	        		if (validate_password($pass, $row['contrasena'])) {
	        			$_SESSION['usuario'] = $row['usuario'];
	        			$_SESSION['contrasena'] = $row['contrasena'];
	           			$_SESSION['tipo'] = $row['tipo'];
	           			$_SESSION['imagen'] = $row['imagen'];
	    
	            		$noexiste=false;
	            		break;	        			
	        		}	            
	        	}
	        }
	        
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
	<div class="container-fluid">
	
			    <?php
			 if(isset($_SESSION['usuario'])){	 
			?>
			<div class="panel panel-primary" style="width:50%;margin: 0 auto">
				<div class="panel-heading">
					<h3 class="panel-title">Perfil</h3>
				</div>
				<div class="panel-body">
					<?php
					echo "<img src='imagenes-user/".$_SESSION['imagen'].".jpg' alt='user' class='img-rounded' style='width:140px;height:140px; float: left'>"; 
				echo "<FONT ALIGN=center SIZE=5 COLOR=#FFFFFF style='float:center'><center><h2>¡BIENVENIDO/A!</h2><h2>".$_SESSION['usuario']."</h2></center><br></FONT>"; 
					?>
				<a href="cambiarimg.php">Cambiar imagen de Perfil</a><br><br>
				<a href="camcontra.php">Modificar mi Contraseña</a><br><br>
				<a href="cerrar.php">Salir</a>
				
				</div>
			</div>
				<?php 
			}else {
			    ?>
			    <div class="row">
			    	<div class="col-md-6 col-md-offset-3">
			    		<?php if ($noexiste) {
			    			
			    		?>
			    		<div class="alert alert-dismissible alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
					     <strong>¡Alerta!</strong>  El usuario o contraseña están incorrectas.
					    </div>

			    		<?php }   ?>
					    
						    <div class="panel panel-primary">
							  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="home.php">
							<fieldset>
							<legend>Iniciar Sesión</legend>

					  <div class="form-group">
					    <label for="usuario" class=" control-label">Usuario</label>				    
					    <input type="text" class="form-control " id="usuario" name="usuario" placeholder="Usuario" required >				    
					  </div>
					  <div class="form-group">
					    <label for="Password" class=" control-label">Contraseña</label>				    
					    <input type="Password" class="form-control" id="contrasena" name= "contrasena" placeholder="Contraseña" required>					
					  </div>				  
					  
					  <button type="submit" class="btn btn-primary">Ingresar</button>
					  </fieldset>
					</form>
					  </div>
					</div>
					</div>
				</div>
		<?php

			}
			?>
	</div>
	<footer>

	</footer>
</body>
</html>
