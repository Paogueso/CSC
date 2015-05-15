<?php
	session_start();

	include_once 'conn.php';
	require_once('/PasswordHash.php');
	$co=false;
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
	    		<?php if ($co) {?>
					<div class="alert alert-success">
			      <strong>¡Éxito!</strong> Usuario Creado Satisfactoriamente
			    </div>

	    		<?php
	    			
	    		}
				?>	    		
	    		<div class="panel panel-default ">
					  <div class="panel-body">
					    <form role="form"  style="padding: 20px;" method="post" action="cambiarimg.php" enctype="multipart/form-data">
							<fieldset>
								<legend>Cambiar Imagen de Perfil</legend>
                     <div class="form-group has-feedback">           
                    <label for="img" class=" control-label">Imagen de Perfil (.jpg, .png, .jpeg)</label>		      
                    <div class="form-control">			    
					    <input name="img" type="file"/ value="Buscar archivo" required>				    
					  </div>
                    </div>
					  <input type="hidden" class="form-control " id="usuario" name="usuario" value=<?="'".$_SESSION['usuario']."'" ?> >
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
if(isset($_POST['usuario'])){
	    $usuario=$_POST['usuario'];
        $img=$_FILES['img'];
	    
        if ($_FILES["img"]["type"]=="image/jpeg" || $_FILES["img"]["type"]=="image/png" || $_FILES["img"]["type"]=="image/jpg"){
			
			unlink('imagenes-user/'.$usuario.'.jpg');
            $guardar = "imagenes-user/".$usuario.".jpg";
            echo "<div class='col-md-6 col-md-offset-3'><div class='alert alert-success'>
			      <strong>Imagen Modificada con Éxito</strong>
			    </div></div>";

            move_uploaded_file($_FILES['img']['tmp_name'], $guardar);
            $co=true;
            
	        $dbh =conectarbase(); 
	        
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $stmt = $dbh->prepare("UPDATE usuario SET imagen = :img WHERE usuario = :usuario");
	        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR, 10);
	        $stmt->bindParam(':img', $usuario, PDO::PARAM_STR, 32);
	        
	        $stmt->execute();
            
            
        }else{
        echo "<div class='col-md-6 col-md-offset-3'><div class='alert alert-danger'>
		<strong>El Formato de Imagen no es el indicado</strong>
			    </div></div>";;
        $co=false;
        }
	}
?>
</html>
