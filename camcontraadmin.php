<?php
	session_start();
	
	$exito=false;
	$R=false;
	if (isset($_REQUEST['contrasena1'])) {

        $R=modif();
	}
?>
<!DOCTYPE HTML>
<html lang='es'>
	<?php include 'head.php'; ?>
<body role="document">
	<?php include 'cabecera.php'; ?>
	<div class="container-fluid">
		
		<div class="row">
	    	<div class=" col-md-6 col-md-offset-3 ">
	    		<?php if ($R) { ?>
					<div class="alert alert-success">
			      <strong>¡Éxito!</strong> Contraseña modificada Exitosamente
			    </div>

	    		<?php
	    			
	    		}
	    		?>    		
	    		<div class="panel panel-default ">
					  <div class="panel-heading"><b>Cambiar Contraseña</b></div>
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="modificarUsuario.php">

					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Usuario: <?=$_SESSION['usuario']?></label>				    
					    <input type="hidden" class="form-control " id="usuario" name="usuario" value=<?="'".$_SESSION['usuario']."'" ?> >
					    
					    <div id="resusu"></div>					    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="Password1" class=" control-label">Nueva Contraseña</label>				    
					    <input type="Password" class="form-control" id="Password1" name= "contrasena1" placeholder="Contraseña" required pattern=".{6,}" title="Debe ingresar 6 carácteres como mínimo">					
						<input type="Password" class="form-control" id="Password2" name= "contrasena2" placeholder="Repetir Contraseña" required pattern=".{6,}" title="Debe ingresar 6 carácteres como mínimo"> <span id="contval" class="glyphicon control-label"></span>					
					  </div>
					 
					  <input type="submit" id="enviar" class="btn btn-default" value='Cambiar' disabled></input>
					  
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
	    $hostname = 'localhost';
	    
	    $username = 'root';
	    
	    $password = '';
	    
	    try {
	        $dbh = new PDO("mysql:host=" . $hostname . ";dbname=cssreservation", $username, $password);
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("UPDATE usuario set contrasena= :pass where usuario= :usuario ");
	        $stmt->bindParam(':usuario', $_SESSION['usuario'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':pass', $_REQUEST['contrasena1'], PDO::PARAM_STR, 32);
	       
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
	$("#Password2,#Password1").keyup(function (){
		var Password1=$("#Password1").val();
		var Password2=$("#Password2").val();
		if (Password1 != Password2) {
			$("#contval").parent().addClass("has-error");
			$("#contval").parent().removeClass("has-success");
			$("#contval").text("Contraseñas no coinciden");
			$("#enviar").attr('disabled','disabled');
			
		}else if(Password1 == "" || Password2== ""){
					
			$("#contval").text("");
			$("#enviar").attr('disabled','disabled');
		}else{
			$("#contval").parent().addClass("has-success ");
			$("#contval").parent().removeClass("has-error");
			$("#contval").text("Contraseñas coinciden");
			$("#enviar").removeAttr('disabled');
			
		}

	});

});
	
	</script>
</html>
