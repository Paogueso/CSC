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
			      <strong>¡Éxito!</strong> Torneo Creado Satisfactoriamente
			    </div>

	    		<?php
	    			
	    		}elseif (!$co) {
	    			?>
					<div class="alert alert-danger">
			      <strong>¡Alerta!</strong>  Contraseñas no coinciden, vuelva a intentarlo
			    </div>

	    		<?php
	    			
	    		} elseif ($co && !$exito && !$nada) {
	    			?>
					<div class="alert alert-danger">
			      <strong>¡Alerta!</strong>  No se ha podido crear usuario, intente con otro nombre
			    </div>

	    		<?php
	    			
	    		} ?>	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="nuevoTorneo.php">
						<fieldset>
						<legend>Crear Nuevo Torneo</legend>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Nombre</label>				    
					    <input type="text" class="form-control " id="nombre" name="nombre" placeholder="Nombre" required pattern="^[A-Za-z\s\xF1\xD1]+$" title="Sólo se permite texto">	
					    <div id="restor"></div>			    
					  </div>
					  	<div class="form-group has-feedback">
					    <label for="deporte" class=" control-label">Deporte</label>
						  <select class="form-control" id="deporte" name="deporte" required>
					          <option value="Futbol">Fútbol</option>
					          <option value="Baloncesto">Baloncesto</option>
					          <option value="Voleibol">Voleibol</option>
					        </select>		    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="categoria" class=" control-label">Categoría</label>				    
						  <select class="form-control" id="categoria" name="categoria" required>
					          <option value="U-12">Sub-12</option>
					          <option value="U-14">Sub-14</option>
					          <option value="U-16">Sub-16</option>
					          <option value="U-17">Sub-17</option>
					          <option value="U-19">Sub-19</option>
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
<?php 

function agregar()
{	
		
	    $nombre=$_POST['nombre'];
	    $deporte=$_POST['deporte'];
	    $categoria=$_POST['categoria'];

	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("INSERT into torneo (nombre, deporte, categoria) values (:nombre, :deporte, :categoria) ");
	        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':deporte', $deporte, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR, 32);

	        $stmt->execute();
	        
	        $exito=true;
	        
	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return $exito;

} ?>

<script>
	$("#nombre").change(function (){
		if ($("#nombre").val()!="") {
	        var parametros = {"nombre" : $("#nombre").val() };
	        $.ajax({
                	data:  parametros,
	                url:   'serv_torneo.php',
	                type:  'post',
	                beforeSend: function () {
	                        $("#restor").html("Procesando...");
	                },
	                success:  function (response) {
	                	if (response=="si") {
	                		$("#restor").parent().addClass("has-error");
	                		$("#restor").parent().removeClass("has-success");
	                		$("#restor").html("");
	                		$("#restor").text("El nombre del torneo ya existe. Elija otro por favor");
							$("#enviar").attr('disabled','disabled');
	                	}else{
	                		$("#restor").parent().addClass("has-success");
	                		$("#restor").parent().removeClass("has-error");
	                		$("#restor").html("");
	                		$("#restor").text("Torneo no existente");
	                		$("#enviar").removeAttr('disabled');
	                	}
	                        
	                }
	        });
	    }else{

	    	$("#restor").parent().removeClass("has-error has-success");
	        $("#restor").html("");
	    }
	});
</script>

</html>
