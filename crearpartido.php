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
	$exito=false;

?>
<!DOCTYPE HTML>
<html lang='es' ng-app="tabla">
	<?php include 'head.php'; ?>
<body role="document" ng-controller="JugController as jug">
	<?php include 'cabecera.php'; ?>
	<br>
	<br>
	<div class="container-fluid">
		
		<div class="row">
	    	<div class=" col-md-6 col-md-offset-3 ">
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="insjug.php">
						<fieldset>
						<legend>Jugadores Titulares</legend>
						<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Equipos</label>
					    <select class="form-control" id="equipo" name="equipo" ng-model="equipo"  ng-change="jugequipo()">
					    <?php 
					    $result=equipos();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idEquipo']."'>".$row['Nombre']."</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
					  <STRONG>Jugadores del equipo</STRONG>
					  <table class="table table-hover">
			  			<thead>
							<tr>
							<th>Nombres</th><th>Apellidos</th> <th>Titular</th>
							</tr>
						</thead>
						<tr></tr>
						<tbody>
							<tr ng-repeat="jugador in jugeq">
							<td>{{jugador.Nombres}}</td>
							<td>{{jugador.Apellidos}}</td>
							<td ng-dblclick="titular(jugador);">{{jugador.titular==1 ? 'Sí' : 'No'}}</td> 
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

function equipos()
{	

	    try {

	        $dbh =conectarbase();
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("SELECT * FROM equipo where activo='1'");
	        
	        $stmt->execute();
	        $result = $stmt->fetchAll();

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
