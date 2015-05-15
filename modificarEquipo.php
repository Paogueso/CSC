<?php
	session_start();
	require_once('/PasswordHash.php');
	include_once 'conn.php';
	if (isset($_SESSION['tipo'])){
		if ($_SESSION['tipo']!=1){
			header('Location: index.php');
		}
	}else{
		header('Location: index.php');
	}

	$co=true;
	$exito=false;
	$nada=true;
	$R=false;
	if (isset($_REQUEST['nombre']) AND isset($_POST['nombre'])) {

        $R=modif();
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
	    		<?php if ($R) {?>
					<div class="alert alert-success">
			      <strong>Equipo Modificado Satisfactoriamente</strong>
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
					    <form role="form"  style="padding: 20px;" method="post" action="modificarEquipo.php">
							<fieldset>
							<legend>Cambiar Nombre de Equipo</legend>
					  <div class="form-group has-feedback">
					    <label for="equipo" class=" control-label">Equipo: <?=$_REQUEST['nombre']?></label>				    
					    <input type="hidden" class="form-control " id="ant" name="ant" value=<?="'".$_REQUEST['nombre']."'" ?> >
					    
					    				    
					  </div>
						<div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Nuevo nombre</label>				    
					    <input type="text" class="form-control " id="nombre" name="nombre" placeholder="Nombre" required >	
					    <div id="resusu"></div>			    
					  </div>
					 
					  <input type="submit" id="enviar" class="btn btn-primary" value='Cambiar' disabled></input>
					  
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
function modif()
{
	$name=$_POST['nombre'];
	    
	    try {
	        $dbh =conectarbase();
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("UPDATE equipo set Nombre= :nombreact where Nombre= :nombreant ");
	        $stmt->bindParam(':nombreact', $name, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':nombreant', $_REQUEST['ant'], PDO::PARAM_STR, 10);
	       
	        $stmt->execute();
	        
	        $exito=true;
	        
	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        $exito=false;
	    }
	    return $exito;

}
?>

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
</html>
