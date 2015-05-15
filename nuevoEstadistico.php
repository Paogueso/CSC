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
	require_once('/PasswordHash.php');
	$co=true;
	$exito=false;
	$nada=true;
	if (isset($_POST['contrasena1'])) {
		if(strcmp ($_POST['contrasena1'], $_POST['contrasena2'])==0){
			
		$exito=agregar();
		$nada=false;
			
		}else {
			$co=false;
			$nada=false;
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
		
		<div class="row">
	    	<div class=" col-md-6 col-md-offset-3 ">
	    		<?php if ($co && $exito ) {?>
					<div class="alert alert-success">
			      <strong>¡Éxito!</strong> Usuario Creado Satisfactoriamente
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
			      <strong>¡Alerta!</strong>  El formato de Imagen no es el indicado.
			    </div>

	    		<?php
	    			
	    		} ?>	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="nuevoEstadistico.php" enctype="multipart/form-data">
						<fieldset>
							<legend>Crear Nuevo Usuario Estadístico</legend>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Usuario</label>				    
					    <input type="text" class="form-control " id="usuario" name="usuario" placeholder="Usuario" required >
					    <div id="resusu"></div>					    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="Password1" class=" control-label">Contraseña</label>				    
					    <input type="Password" class="form-control" id="Password1" name= "contrasena1" placeholder="Contraseña" required pattern="\S{6,}" title="Introduzca como mínimo 6 carácteres">					
						<input type="Password" class="form-control" id="Password2" name= "contrasena2" placeholder="Repetir Contraseña" required pattern="\S{6,}" title="Introduzca como mínimo 6 carácteres"> 
                        <span id="contval" class="glyphicon control-label"></span>					
					  </div>
					  <div class="form-group has-feedback">
					    <label for="email" class=" control-label">Correo Electrónico</label>				    
					    <input type="email" class="form-control " id="email" name="email" placeholder="Correo Electrónico" required >				    
					  </div>
					  <div class="form-group has-feedback">           
                    <label for="img" class=" control-label">Imagen de Perfil (.jpg, .png, .jpeg)</label>		      
                    <div class="form-control">			    
					    <input name="img" type="file"/ value="Buscar archivo" required>				    
					  </div>
					  </div>
					  <input type="submit" id="enviar" class="btn btn-primary" value='Crear'>
					  
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
	
	    $pass=$_POST['contrasena1'];
	    $pass=create_hash($pass);
	    $usuario=trim($_POST['usuario']);
	    $email=$_POST['email'];
	    $img=$_FILES['img'];

		if ($_FILES["img"]["type"]=="image/jpeg" || $_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/jpg"){

            $guardar = "imagenes-user/".$usuario.".jpg"; 

            move_uploaded_file($_FILES['img']['tmp_name'], $guardar);
	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("INSERT into usuario (usuario,contrasena,correo,tipo,imagen) values (:usuario,:contrasena,:correo,'2',:img) ");
	        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 10);
	        $stmt->bindParam(':contrasena', $pass, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':correo', $email, PDO::PARAM_STR, 32);
	        $stmt->bindParam(':img', $usuario, PDO::PARAM_STR, 32);
	        
	        $stmt->execute();
	        
	        $exito=true;

	        $dbh = null;
	    }
	    catch(PDOException $e) {
	        echo $e->getMessage();
	        $exito=false;
	    }
	    return $exito;
	    }else{
        echo "<script>$(document).ready(function(){
        $('#enviar').attr('disabled','disabled');
        });</script>";
        }

} ?>

<script>
$(document).ready(function(){
	$("#Password2,#Password1").keyup(function (){
		var Password1=$("#Password1").val();
		var Password2=$("#Password2").val();
		if (Password1 != Password2) {
			$("#contval").parent().addClass("has-error");
			$("#contval").parent().removeClass("has-success");
			$("#contval").addClass("");
			$("#contval").text("Contraseñas no Coinciden");
			$("#contval").removeClass("");
			
			
		}else if(Password1 == "" || Password2== ""){
			
			$("#contval").parent().removeClass("has-success has-error");
			$("#contval").removeClass(" glyphicon-ok-circle  glyphicon-remove-circle");			
			$("#contval").text("");
		}else{
			$("#contval").parent().addClass("has-success ");
			$("#contval").parent().removeClass("has-error");
			$("#contval").text("Contraseñas coinciden");
			$("#contval").removeClass("");
			$("#contval").addClass("");
			
		}

	});

	$("#usuario").change(function (){
		if ($("#usuario").val()!="") {
	        var parametros = {"usuario" : $("#usuario").val() };
	        $.ajax({
                	data:  parametros,
	                url:   'serv_usuario.php',
	                type:  'post',
	                beforeSend: function () {
	                        $("#resusu").html("Procesando, espere por favor...");
	                },
	                success:  function (response) {
	                	if (response=="si") {
	                		$("#resusu").parent().addClass("has-error");
	                		$("#resusu").parent().removeClass("has-success");
	                		$("#resusu").html("");
	                		$("#resusu").text("El nombre de usuario ya existe. Elija otro por favor");
							$("#enviar").attr('disabled','disabled');
	                	}else{
	                		$("#resusu").parent().addClass("has-success");
	                		$("#resusu").parent().removeClass("has-error");
	                		$("#resusu").html("");
	                		$("#resusu").text("Usuario no existente");
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
