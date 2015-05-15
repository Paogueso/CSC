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
					    <form role="form"  style="padding: 20px;" method="post" action="nuevoJugador.php" enctype="multipart/form-data">
						<fieldset>
						<legend>Crear Nuevo Jugador</legend>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Usuario</label>				    
					    <input type="text" class="form-control " id="usuario" name="usuario" placeholder="Usuario" required >
					    <div id="resusu"></div>					    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="Password1" class=" control-label">Contraseña</label>				    
					    <input type="Password" class="form-control" id="Password1" name= "contrasena1" placeholder="Contraseña" required pattern="\S{6,}" title="Introduzca como mínimo 6 carácteres">					
						<input type="Password" class="form-control" id="Password2" name= "contrasena2" placeholder="Repetir Contraseña" required pattern="\S{6,}" title="Introduzca como mínimo 6 carácteres"> 
                        <div id="contval"></div>				
					  </div>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Nombre</label>				    
					    <input type="text" class="form-control " id="nombre" name="nombre" placeholder="Nombre" required pattern="^[A-Za-z\s\xF1\xD1]+$" title="Sólo se permite texto">
					    <div id="nameval"></div>	    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Apellido</label>				    
					    <input type="text" class="form-control " id="apellido" name="apellido" placeholder="Apellido" required pattern="^[A-Za-z\s\xF1\xD1]+$" title="Sólo se permite texto">
					    <div id="apeval"></div>			    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="usuario" class=" control-label">Fecha de Nacimiento</label>				    
					    <input type="date" class="form-control " id="fechanac" name="fechanac" placeholder="Fecha de Nacimiento" required >			    
					  </div>
					  <div class="form-group has-feedback">
					    <label for="correo" class=" control-label">Correo</label>				    
					    <input type="text" class="form-control " id="correo" name="correo" placeholder="Correo Electrónico" required>			    
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
					  <div class="form-group has-feedback">
					    <label for="tel" class=" control-label">Teléfono</label>				    
					    <input type="text" class="form-control " id="tel" name="tel" placeholder="Teléfono" required >				    
					  </div>
					  <div class="form-group has-feedback">           
                    <label for="img" class=" control-label">Imagen de Perfil (.jpg, .png, .jpeg)</label>		      
                    <div class="form-control">			    
					    <input name="img" type="file"/ value="Buscar archivo" required>				    
					  </div>
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
		$usuario=trim($_POST['usuario']);
	    $pass=$_POST['contrasena1'];
	    $pass=create_hash($pass);
	    $nombre=$_POST['nombre'];
	    $apellido=$_POST['apellido'];
	    $fechaNac=$_POST['fechanac'];
	    $correo=$_POST['correo'];
	    $deporte=$_POST['deporte'];
	    $categoria=$_POST['categoria'];
	    $telefono=$_POST['tel'];
	    $img=$_FILES['img'];
	    
	    if ($_FILES["img"]["type"]=="image/jpeg" || $_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/jpg"){

            $guardar = "imagenes-user/".$usuario.".jpg"; 

            move_uploaded_file($_FILES['img']['tmp_name'], $guardar);

	    try {

	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("INSERT into usuario (usuario, contrasena, correo, tipo, imagen) values (:usuario, :contrasena, :correo, '4', :img) ");
	        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':contrasena', $pass, PDO::PARAM_STR, 132);
	        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':img', $usuario, PDO::PARAM_STR, 32);

	        $stmt->execute();

	        $stmt = $dbh->prepare("SELECT max(idusuario) as id FROM usuario");

	        $stmt->execute();
	        $result = $stmt->fetch(PDO::FETCH_ASSOC);

	        $stmt = $dbh->prepare("INSERT into persona (Nombres, Apellidos, Fecha_Nac, Deporte, Categoria, DUI, Telefono, usuario_idusuario) values (:Nombre, :Apellido, :Fecha_Nac, :Deporte, :Categoria, 'N/D', :Telefono, :idusuario) ");
	        
	        $stmt->bindParam(':Nombre', $nombre, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':Apellido', $apellido, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':Fecha_Nac', $fechaNac, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':Deporte', $deporte, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':Categoria', $categoria, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':Telefono', $telefono, PDO::PARAM_STR, 50);
	        $stmt->bindParam(':idusuario', $result["id"], PDO::PARAM_STR, 50);

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
			$("#enviar").attr('disabled','disabled');
			
			
		}else if(Password1 == "" || Password2== ""){
			
			$("#contval").parent().removeClass("has-success has-error");		
			$("#contval").text("");
		}else{
			$("#contval").parent().addClass("has-success ");
			$("#contval").parent().removeClass("has-error");
			$("#contval").text("Contraseñas coinciden");
			$("#contval").removeClass("");
			$("#contval").addClass("");
			$("#enviar").removeAttr('disabled'); 
			
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
	
$("#nombre").keyup(function (){
		var nombre=$("#nombre").val();
		
		if(nombre.match(/^[A-Za-z\s\xF1\xD1]+$/)){
			$("#nameval").parent().addClass("has-success");
			$("#nameval").parent().removeClass("has-error");
			$("#nameval").html(""); 
			$("#nameval").text("El nombre está correcto");
			$("#enviar").removeAttr('disabled'); 
			
		}else if (nombre == ""){
			$("#nameval").parent().removeClass("has-success has-error");		
			$("#nameval").text("");
		}else{
			$("#nameval").parent().addClass("has-error ");
			$("#nameval").parent().removeClass("has-success");
			$("#nameval").text("El nombre sólo debe contener texto");
			$("#enviar").attr('disabled','disabled');
			
		}

	});
	
	$("#apellido").keyup(function (){
		var apellido=$("#apellido").val();
		
		if(apellido.match(/^[A-Za-z\s\xF1\xD1]+$/)){
			$("#apeval").parent().addClass("has-success");
			$("#apeval").parent().removeClass("has-error");
			$("#apeval").html(""); 
			$("#apeval").text("El apellido está correcto");
			$("#enviar").removeAttr('disabled'); 
			
		}else if (apellido == ""){
			$("#apeval").parent().removeClass("has-success has-error");		
			$("#apeval").text("");
		}else{
			$("#apeval").parent().addClass("has-error");
			$("#apeval").parent().removeClass("has-success");
			$("#apeval").text("El apellido sólo debe contener texto");
			$("#enviar").attr('disabled','disabled');
			
		}

	});
	
});
	
	</script>

<link rel="stylesheet" type="text/css" href="js/datetimepicker.css"/ >

		<script type="text/javascript" src="js/jquery.maskedinput.js"></script>	
		<script type="text/javascript" src="js/datetimepicker.js"></script>
		<script type="text/javascript">

			$("#dui").mask("99999999-9");
			$('#fechanac').datetimepicker({value:'2007-12-31' ,lang:'es',maxDate:'2007/12/31',format:'Y-m-d',timepicker:false, mask:true});
            $("#tel").mask("9999-9999");
		</script>
</html>
