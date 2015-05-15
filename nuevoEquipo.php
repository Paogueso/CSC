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
	
	$co=true;
	$exito=false;
	$nada=true;
	if (isset($_POST['nombre'])) {
		
			$exito=agregar();
		$nada=false;			
		
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
					    <form role="form"  style="padding: 20px;" method="post" action="nuevoEquipo.php">
						<fieldset>
						<legend>Crear Nuevo Equipo</legend>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Nombre</label>				    
					    <input type="text" class="form-control " id="nombre" name="nombre" placeholder="Nombre" required pattern="^[A-Za-z\s\xF1\xD1]+$" title="Sólo se permite texto">
                        <div id="resusu"></div>
					  </div>

					  	<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Torneo</label>
					    <select class="form-control" id="torneo" name="torneo" >
					    <?php 
					    $result=torneos();
					    foreach ($result as $row) {
	                     echo "<option value='".$row['idTorneo']."'>".$row['Nombre']." ".$row['Categoria']." ".$row['Deporte']."</option>";
	                     }
	                     ?>
						</select>		    
					  </div>
					  <input type="submit" id="enviar" class="btn btn-primary" value='Crear'> 
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
    
<script>
$(document).ready(function(){
	$("#nombre").change(function (){
		if ($("#nombre").val()!="") {
	        var parametros = {"nombre" : $("#nombre").val() };
	        $.ajax({
                	data:  parametros,
	                url:   'serv_equipo.php',
	                type:  'post',
	                beforeSend: function () {
	                        $("#resusu").html("Procesando, espere por favor...");
	                },
	                success:  function (response) {
	                	if (response=="si") {
	                		$("#resusu").parent().addClass("has-error");
	                		$("#resusu").parent().removeClass("has-success");
	                		$("#resusu").html("");
	                		$("#resusu").text("El nombre de equipo ya existe. Elija otro por favor");
							$("#enviar").attr('disabled','disabled');
	                	}else{
	                		$("#resusu").parent().addClass("has-success");
	                		$("#resusu").parent().removeClass("has-error");
	                		$("#resusu").html("");
	                		$("#resusu").text("Equipo no existente");
	                		$("#enviar").removeAttr('disabled');        		
	                	}
	                        
	                }
	        });
	    }else{

	    	$("#resusu").parent().removeClass("has-error has-success");
	        $("#resusu").html("");
	    }
	});
});
	
	</script>   
    
    
<?php 

function agregar()
{	
		
	    $nombre=$_POST['nombre'];
	    $torneo=$_POST['torneo'];

	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt = $dbh->prepare("INSERT into equipo (nombre, activo) values (:nombre, '1') ");
	        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 32);
	       
	        $stmt->execute();
	        
	        $stmt = $dbh->prepare("SELECT max(idEquipo) as id FROM Equipo");
	        
	        $stmt->execute();
	        $result = $stmt->fetch(PDO::FETCH_ASSOC);

	        $stmt = $dbh->prepare("INSERT into ins_torneo (Equipo_idEquipo, Torneo_idTorneo) values (:nombre, :torneo) ");
	        $stmt->bindParam(':nombre', $result["id"], PDO::PARAM_STR, 32);
	        $stmt->bindParam(':torneo', $torneo, PDO::PARAM_STR, 32);

	        $stmt->execute();
	        $exito=true;

	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return $exito;

} 

function torneos()
{	

	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("SELECT * FROM torneo WHERE activo = '1'");
	        
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

}?>

</html>
