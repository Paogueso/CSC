<?php
	session_start();

	if (isset($_SESSION['tipo'])){
		if ($_SESSION['tipo']!=2){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
	include_once 'conn.php';
	$co=true;
	$exito=false;
	$nada=true;
	if (isset($_POST['torneo'])) {
		
			$exito=agregar();
		$nada=false;			
		
	}

?>
<!doctype html>
<html lang='es' ng-app="tabla">
	<?php include 'head.php'; ?>
<body role="document" ng-controller="JugController as jug">
	<?php include 'cabecera.php'; ?>
	<br>
	<br>
	<div class="container-fluid">
		
		<div class="row">
	    	<div class=" col-md-6 col-md-offset-3 ">
	    		<?php if ($co && $exito ) {?>
					<div class="alert alert-success">
			      <strong>Partido Creado Exitosamente</strong> 
			    </div>

	    		<?php
	    			
	    		}elseif (!$co) {
	    			?>
					<div class="alert alert-danger">
			      <strong>Ingresa otros equipos diferentes</strong>
			    </div>

	    		<?php
	    			
	    		} elseif ($co && !$exito && !$nada) {
	    			?>
					<div class="alert alert-danger">
			      <strong>Ingresa otros equipos diferentes</strong>
			    </div>

	    		<?php
	    			
	    		} ?>
	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="iniciarpartido.php">
						<fieldset>
						<legend>Crear Partidos</legend>
						<div class="form-group has-feedback">
					    <label for="torneo" class=" control-label">Torneo</label>
					    <select class="form-control" id="torneo" name="torneo">
					    <?php 
					    $result=torneo();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idTorneo']."'>".$row['Nombre']. " " .$row['Deporte']. " " .$row['Categoria']. "</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
						<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Equipo 1</label>
					    <select class="form-control" id="equipo" name="equipo1">
					    <?php 
					    $result=equipos();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idEquipo']."'>".$row['Nombre']."</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Equipo 2</label>
					    <select class="form-control" id="equipo" name="equipo2">
					    <?php 
					    $result=equipos();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idEquipo']."'>".$row['Nombre']."</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
					  <button type="submit" class="btn btn-primary">Crear</button>
					   
					  
					  </fieldset>
					</form>
					  </div>
				</div>
			</div>

		</div>		
	
	</div>
	<footer>

	</footer>
</body>
<?php 

function agregar()
{	
		
	    $torneo=$_POST['torneo'];
	    $e1=$_POST['equipo1'];
	    $e2=$_POST['equipo2'];

		if($e1 != $e2){
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("INSERT into partido (torneo_idTorneo, equipo_idEquipo1, equipo_idEquipo2) values (:torneo, :e1, :e2) ");
	        $stmt->bindParam(':torneo', $torneo, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':e1', $e1, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':e2', $e2, PDO::PARAM_STR, 32);
	       
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        
	        $exito=true;
	        
	        /*** close the database connection ***/
	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return $exito;
	}

} 

function jugadores()
{	

	    //echo $password;
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("SELECT * FROM usuario INNER JOIN persona ON idusuario=usuario_idusuario WHERE tipo = '4'");
	        
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        $result = $stmt->fetchAll();
	        
	        
	        
	        /*** close the database connection ***/
	        $dbh = null;
	        return $result;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return null;

}

function equipos()
{	

	    //echo $password;
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("SELECT * FROM equipo WHERE activo='1'");
	        
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        $result = $stmt->fetchAll();
	        
	        
	        
	        /*** close the database connection ***/
	        $dbh = null;
	        return $result;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return null;

}

function torneo()
{	

	    //echo $password;
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("SELECT * FROM torneo WHERE activo='1'");
	        
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        $result = $stmt->fetchAll();
	        
	        
	        
	        /*** close the database connection ***/
	        $dbh = null;
	        return $result;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return null;

}
?>






</html>
