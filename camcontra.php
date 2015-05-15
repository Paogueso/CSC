<?php
	session_start();
	require_once('/PasswordHash.php');
	include_once 'conn.php';

	$co=true;
	$exito=true;
	$nada=true;
	$R=false;
	$E=false;
	if (isset($_REQUEST['contrasena1'])) {

        $R=modif();
	}
?>
<!doctype html>
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
			         <strong>¡Éxito!</strong> Contraseña Modificada correctamente
			        </div>

	    		

	    		<?php
	    			
	    		}elseif (!$R && !$exito) {
	    			?>
					<div class="alert alert-danger">
			      <strong>¡Alerta!</strong>  No se ha podido crear usuario, intente con otro nombre
			    </div>

	    		<?php
	    			
	    		} ?>	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="camcontra.php">
						<fieldset>
							<legend>Cambiar Contraseña</legend>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Usuario: <?=$_SESSION['usuario']?></label>				    
					    <input type="hidden" class="form-control " id="usuario" name="usuario" value=<?="'".$_SESSION['usuario']."'" ?> >
					    
					    <div id="resusu"></div>					    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="Pass" class=" control-label">Contraseña Actual</label>				    
					    <input type="Password" class="form-control" id="Pass" name= "contrasena" placeholder="Contraseña Actual" required>	
					    <div id="passsu"></div>					
						</div>
					  <div class="form-group has-feedback">
					    <label for="Password1" class=" control-label">Nueva Contraseña</label>				    
					    <input type="Password" class="form-control" id="Password1" name= "contrasena1" placeholder="Contraseña" required pattern=".{6,}" title="Debe ingresar 6 carácteres como mínimo">					
						<input type="Password" class="form-control" id="Password2" name= "contrasena2" placeholder="Repetir Contraseña" required pattern=".{6,}" title="Debe ingresar 6 carácteres como mínimo"> <span id="contval" class="glyphicon control-label"></span>					
					  </div>
					 
					  <input type="submit" id="enviar" class="btn btn-primary" value='Cambiar' disabled></input>
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
function modif()
{	if (buscar($_SESSION['usuario'],$_POST['contrasena'])) {
	
		$pass=$_POST['contrasena1'];
	    $pass=create_hash($pass);
	    
	    try {
	        $dbh = conectarbase();
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt = $dbh->prepare("UPDATE usuario set contrasena= :pass where usuario= :usuario ");
	        $stmt->bindParam(':usuario', $_SESSION['usuario'], PDO::PARAM_STR, 10);
	        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR, 32);
	       
	        $stmt->execute();
	        
	        $exito=true;

	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        $exito=false;
	    }
	    return $exito;
	    
	}	else{
		return false;
	}

}

function buscar($usuario,$contra)
{
	
	    $reultado=false;
	    try {
	        $dbh = conectarbase();
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("SELECT * from usuario where usuario=:usuario");
	        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 10);

	        $stmt->execute();
	        
	         $result = $stmt->fetchAll();
					        
			$existe=false;
            
	        foreach ($result as $row) {

	        	if(strcmp($row['usuario'], $usuario)==0){
	        		if (validate_password($contra, $row['contrasena'])) {
	        		   	$existe=true;
	        		   	$resultado=$existe;
	            		break;	        			
	        		}	            
	        	}
	        }
	        
	        $dbh = null;
	    }
	    catch(PDOException $e) {
            
	        $existe=false;
	        
	    }
	    $resultado=$existe;
	    return $resultado;

}?>

<script>
$(document).ready(function(){
	$("#Password2,#Password1,#Pass").keyup(function (){
		var Password1=$("#Password1").val();
		var Password2=$("#Password2").val();
		var Pass=$("#Pass").val();
		if (Password1 != Password2) {
			$("#contval").parent().addClass("has-error");
			$("#contval").parent().removeClass("has-success");
			$("#contval").text("Contraseñas no coinciden");
			$("#enviar").attr('disabled','disabled');
			
		}else if(Password1 == "" || Password2== "" || Pass == "" ){
					
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
