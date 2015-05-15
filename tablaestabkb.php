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
	?>

<!doctype html>
<html lang='es' ng-app="tabla">
	<?php include 'head.php'; ?>
<body role="document" ng-controller="TablaController as tabla"  ng-keydown="onKeyDown($event)" ng-keyup="onKeyUp($event)">
	<?php include 'cabecera.php'; ?>
	<br>
	<br>
	<div class="container-fluid col-md-10 col-md-offset-1">
		<div class="panel panel-info">
			  <div class="panel-body">
				<div class="form-group has-feedback">
					    <label for="torneo" class=" control-label">Torneo</label>
					    <select class="form-control" ng-model="torneo"   ng-change="crpartidos()" placeholder="Torneo" id="torneo">
					    <?php 
					    $result=torneo();
					    foreach ($result as $row) {
	                     	echo "<option value='".$row['idTorneo']."'>".$row['Nombre']. " " .$row['Deporte']. " " .$row['Categoria']. "</option>";
	                     }
	                     ?>
						</select>
				</div>
				
			  	<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Partido</label>
					    <select class="form-control" id="partido" name="partido" ng-model="partido" ng-options="prt.nombre for prt in partidos" ng-change="crequipos()" >
						    
						</select>	

				</div>
				<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Equipo</label>
					    <select class="form-control" id="equipo" name="equipo" ng-model="equipo" ng-options="iq.Nombre for iq in equipos" ng-change="jugadoresact()" >
						    
						</select>		    
				</div>
				<table class="table table-hover">
			  			<thead>
							<tr>
								<th>Jugador</th> <th>Apellido</th> <th>Min</th>
								<th>P1</th><th>FP1</th><th>P1%</th>
								<th>P2</th><th>FP2</th><th>P2%</th>
								<th>P3</th><th>FP3</th><th>P3%</th>
								<th>AS</th><th>TO</th><th>OR</th>
								<th>DR</th><th>OF</th><th>DF</th>
							</tr>
						</thead>
						
						<tbody>
							<tr ng-repeat="juga in jugadoresfgd" >
							<td>{{juga.Nombres}}</td>
							<td>{{juga.Apellidos}}</td> 
							<td ng-dblclick="detenerJugador(juga);">{{juga.tiempo_juego| date:'HH:mm:ss'}}</td>
                                <td ng-dblclick="suma(juga ,'tiros_1',1);">{{juga.tiros_1}}</td> 
                                <td ng-dblclick="suma(juga ,'tiros_fallados_1',1);">{{juga.tiros_fallados_1}}</td> 
                                <td >{{juga.tiros_por_1| number:2}} %</td>
                                <td ng-dblclick="suma(juga ,'tiros_2',1);">{{juga.tiros_2}}</td> 
                                <td ng-dblclick="suma(juga ,'tiros_fallados_2',1);">{{juga.tiros_fallados_2}}</td> 
                                <td >{{juga.tiros_por_2| number:2}} %</td> 
                                <td ng-dblclick="suma(juga ,'tiros_3',1);">{{juga.tiros_3}}</td> 
                                <td ng-dblclick="suma(juga ,'tiros_fallados_3',1);">{{juga.tiros_fallados_3}}</td> 
                                <td >{{juga.tiros_por_3| number:2}} %</td> 
                                <td ng-dblclick="suma(juga ,'asistencias',1);">{{juga.asistencias}}</td> 
                                <td ng-dblclick="suma(juga ,'perdidas',1);">{{juga.perdidas}}</td> 
                                <td ng-dblclick="suma(juga ,'rebotes_def',1);">{{juga.rebotes_def}}</td> 
                                <td ng-dblclick="suma(juga ,'rebotes_of',1);">{{juga.rebotes_of}}</td> 
                                <td ng-dblclick="suma(juga ,'Faltas_of',1);">{{juga.Faltas_of}}</td> 
                                <td ng-dblclick="suma(juga ,'Faltas_def',1);">{{juga.Faltas_def}}</td> 
                                
						</tr>
							
						</tbody>
				</table>
				<button ng-click="guardar()" class="btn btn-primary" id="insertar">Insertar</button>
				{{tiempo| date:'HH:mm:ss'}}

				<button ng-click="iniciarTimer()" class="btn btn-primary" id="contar">contar</button>
				<button ng-click="detenerTimer()" class="btn btn-primary" id="contar">detener</button>

			  	<!--<table class="table table-hover">
			  			<thead>
							<tr>
								<th>Jugador</th><th>POS</th> <th>Min</th> <th>P1</th>
								<th>FP1</th><th>P1%</th><th>P2</th>
								<th>FP2</th><th>P2%</th><th>P3</th>
								<th>FP3</th><th>P3%</th>	<th>AS</th><th>FA</th>
								<th>TO</th><th>OR</th>	<th>DR</th>	<th>OF</th><th>DF</th>
							</tr>
						</thead>
						<tr></tr>
						<tbody>
							<tr >
							<td>{{tabla.select.nombre}}</td>
							<td>{{tabla.select.pos}}</td> 
							<td>{{tabla.select.min}}</td> 
							<td ng-dblclick="suma(tabla.select,'fg',1);">{{tabla.select.fg}}</td>
							<td ng-dblclick="suma(tabla.select,'fgpor',1);">{{tabla.select.fgpor}}</td> 
							<td ng-dblclick="suma(tabla.select,'p3',1);">{{tabla.select.p3}}</td> 
							<td ng-dblclick="suma(tabla.select,'p3por',1);">{{tabla.select.p3por}}</td>
							<td ng-dblclick="suma(tabla.select,'ft',1);">{{tabla.select.ft}}</td> 
							<td ng-dblclick="suma(tabla.select,'ftpor',1);">{{tabla.select.ftpor}}</td> 
							<td ng-dblclick="suma(tabla.select,'or',1);">{{tabla.select.or}}</td>
							<td ng-dblclick="suma(tabla.select,'dr',1);">{{tabla.select.dr}}</td> 
							<td ng-dblclick="suma(tabla.select,'reb',1);">{{tabla.select.reb}}</td> 
							<td ng-dblclick="suma(tabla.select,'as',1);">{{tabla.select.as}}</td>
							<td ng-dblclick="suma(tabla.select,'to',1);">{{tabla.select.to}}</td> 
							<td ng-dblclick="suma(tabla.select,'st',1);">{{tabla.select.st}}</td>
							<td ng-dblclick="suma(tabla.select,'bs',1);">{{tabla.select.bs}}</td>
							<td ng-dblclick="suma(tabla.select,'pf',1);">{{tabla.select.pf}}</td> 
							<td ng-dblclick="suma(tabla.select,'pts',1);">{{tabla.select.pts}}</td>
							<td ng-dblclick="suma(tabla.select,'eff',1);">{{tabla.select.eff}}</td>
						</tr>
						</tbody>
				</table>
			  	<table class="table table-hover">
			  			<thead>
							<tr>
								<th>Jugador</th><th>POS</th> <th>Min</th> <th>P1</th>
								<th>FP1</th><th>P1%</th><th>P2</th>
								<th>FP2</th><th>P2%</th><th>P3</th>
								<th>FP3</th><th>P3%</th>	<th>AS</th><th>FA</th>
								<th>TO</th><th>OR</th>	<th>DR</th>	<th>OF</th><th>DF</th>
							</tr>
						</thead>
						<tr></tr>
						<tbody>
							
						</tbody>
						<tr ng-repeat="jugador in tabla.jugadores" ng-click="setSelected(tabla,jugador);">
							<td>{{jugador.nombre}}</td>
							<td>{{jugador.pos}}</td> 
							<td>{{jugador.min}}</td> 
							<td ng-dblclick="suma(jugador,'fg',1);">{{jugador.fg}}</td>
							<td ng-dblclick="suma(jugador,'fgpor',1);">{{jugador.fgpor}}</td> 
							<td ng-dblclick="suma(jugador,'p3',1);">{{jugador.p3}}</td> 
							<td ng-dblclick="suma(jugador,'p3por',1);">{{jugador.p3por}}</td>
							<td ng-dblclick="suma(jugador,'ft',1);">{{jugador.ft}}</td> 
							<td ng-dblclick="suma(jugador,'ftpor',1);">{{jugador.ftpor}}</td> 
							<td ng-dblclick="suma(jugador,'or',1);">{{jugador.or}}</td>
							<td ng-dblclick="suma(jugador,'dr',1);">{{jugador.dr}}</td> 
							<td ng-dblclick="suma(jugador,'reb',1);">{{jugador.reb}}</td> 
							<td ng-dblclick="suma(jugador,'as',1);">{{jugador.as}}</td>
							<td ng-dblclick="suma(jugador,'to',1);">{{jugador.to}}</td> 
							<td ng-dblclick="suma(jugador,'st',1);">{{jugador.st}}</td>
							<td ng-dblclick="suma(jugador,'bs',1);">{{jugador.bs}}</td>
							<td ng-dblclick="suma(jugador,'pf',1);">{{jugador.pf}}</td> 
							<td ng-dblclick="suma(jugador,'pts',1);">{{jugador.pts}}</td>
							<td ng-dblclick="suma(jugador,'eff',1);">{{jugador.eff}}</td>
							 

						</tr>
					</table>-->
			  </div>
		</div>
	
	</div>
	<footer>
		

	</footer>
</body>
<script>
$(document).ready(function(){
		if ($("#torneo").val()=="" && $("#partido").val()=="" && $("#equipo").val()=="" ) {
	                		$("#insertar").removeAttr('disabled');
	                	}else{
							$("#insertar").attr('disabled', 'disabled');
						}
});

$(document).ready(function(){
		var torneo=$("#torneo").val();
		var partido=$("#partido").val();
		var equipo=$("#equipo").val();
		if(torneo == "" && partido== "" && equipo == ""){
			
			$("#insertar").attr('disabled','disabled');
		}else{
			$("#insertar").removeAttr('disabled');
			
		}


});
</script>
</html>
<?php
function torneo()
{	

	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("SELECT * FROM torneo WHERE Deporte='Baloncesto' AND activo='1'");
	        
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
