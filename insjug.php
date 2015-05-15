<?php
	session_start();

	if (isset($_SESSION['tipo'])){
		if ($_SESSION['tipo']!=1){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}
	include_once 'conn.php';
	
	$co=true; // coincide contraseña
	$exito=false; //si da error la base
	$nada=true; //nada no entra a if
	if (isset($_POST['nombre'])) {
		
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
			      <strong>Equipo Creado Satisfactoriamente </strong> 
			    </div>

	    		<?php
	    			
	    		}elseif (!$co) {
	    			?>
					<div class="alert alert-danger">
			      <strong>  Las contraseñas no coinciden, vuelva a intentarlo</strong>
			    </div>

	    		<?php
	    			
	    		} elseif ($co && !$exito && !$nada) {
	    			?>
					<div class="alert alert-danger">
			      <strong>No se ha podido crear el equipo, intente con otro nombre </strong>
			    </div>

	    		<?php
	    			
	    		} ?>
	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="insjug.php">
						<fieldset>
						<legend>Insertar Jugadores a un Equipo</legend>
						<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Equipo</label>
					    <select class="form-control" id="equipo" name="equipo" ng-model="equipo"  ng-change="jugequipo()" placeholder="Equipo">
					    <?php 
					    $result=equipos();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idEquipo']."'>".$row['Nombre']."</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Buscar Jugadores</label>
					    <input type="text" class="form-control" ng-model="nombre"  id="jugador" name="jugador"  placeholder="Jugador" ng-keyup="buscar();jugequipo();" >
					    <br>
					    <STRONG>Seleccionar Jugador</STRONG> 
	                    <table class="table table-hover">
			  			<thead>
							<tr>
							<th>Nombres</th><th>Apellidos</th> <th>Deporte</th> <th>Categoría</th><th>Agregar</th>
							</tr>
						</thead>
						<tr></tr>
						<tbody>
							<tr ng-repeat="jugador in jugadores" ng-click="setjug(jugador);" >
							<td>{{jugador.Nombres}}</td>
							<td>{{jugador.Apellidos}}</td>
							<td>{{jugador.Deporte}}</td>
							<td>{{jugador.Categoria}}</td>
							<td ng-click="insjug(jugador);"><span class="glyphicon glyphicon-plus"></span></td> 
							</tr>
						</tbody>
						
					</table>

								    
					  </div>
						<hr size="5">
					  <STRONG>Jugadores del Equipo Actual</STRONG>
					  <table class="table table-hover">
			  			<thead>
							<tr>
							<th>Nombres</th><th>Apellidos</th> <th>Deporte</th> <th>Categoría</th>
							</tr>
						</thead>
						<tr></tr>
						<tbody>
							<tr ng-repeat="jugador in jugeq">
							<td>{{jugador.Nombres}}</td>
							<td>{{jugador.Apellidos}}</td>
							<td>{{jugador.Deporte}}</td>
							<td>{{jugador.Categoria}}</td> 
							</tr>
						</tbody>
						
					</table>
					   
					  
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
		
	    $nombre=$_POST['nombre'];
	    $torneo=$_POST['torneo'];

	    //echo $password;
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("INSERT into equipo (nombre) values (:nombre) ");
	        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 32);
	       
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        
	        $stmt = $dbh->prepare("SELECT max(idEquipo) as id FROM Equipo");
	        
	        /*** execute the prepared statement ***/
	        $stmt->execute();
	        $result = $stmt->fetch(PDO::FETCH_ASSOC);
	       // echo $result["id"];
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("INSERT into ins_torneo (Equipo_idEquipo, Torneo_idTorneo) values (:nombre, :torneo) ");
	        $stmt->bindParam(':nombre', $result["id"], PDO::PARAM_STR, 32);
	        $stmt->bindParam(':torneo', $torneo, PDO::PARAM_STR, 32);
	       
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

function jugadores()
{	

	    //echo $password;
	    try {

	        $dbh =conectarbase(); // new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        /*** echo a message saying we have connected ***/
	        //echo 'Connected to database';
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        /*** prepare the SQL statement ***/
	        $stmt = $dbh->prepare("SELECT * FROM usuario INNER JOIN persona ON idusuario=usuario_idusuario WHERE tipo = '4' AND Deporte = 'Futbol'");
	        
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
	        $stmt = $dbh->prepare("SELECT * FROM equipo WHERE activo =1");
	        
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
