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
	require_once('/PasswordHash.php');
?>
<!DOCTYPE HTML>
<html lang='es'>
<?php include 'head.php'; ?>
<body role="document">
	<?php include 'cabecera.php'; ?>
	<br>
	<br>
	<div class="container-fluid">
			<div class="panel panel-info" style="width:50%;margin: 0 auto">
				<div class="panel-heading">
					<h3 class="panel-title">Confirmar</h3>
				</div>
				<div class="panel-body">
				<FONT ALIGN=center SIZE=3 COLOR=#FFFFFF style='float:center'><center><h2>Estadísticas Ingresadas con Éxito!</h2></FONT>
				<a href="home.php"><button type="submit" class="btn btn-primary" style="color: white">Regresar</button></a></center>
				</div>
			</div>
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
</html>
