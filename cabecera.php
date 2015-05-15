<html>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/styles.css">
   <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="css/script.js"></script>
</head>
<body>

<div id='cssmenu' style="z-index: 100;">
<ul>
   <li><a href='index.php'><i class="fa fa-home"></i> INICIO</a></li>
   <li class=' has-sub'><a href='#'>IDIOMA</a>
   <ul>
         <li ><a href='../CSCING'>INGLÉS</a>
    </ul>
   <?php
	if(isset($_SESSION['tipo']))
		if($_SESSION['tipo']==2) {
	?>
	<li class=' has-sub'><a href='#'>ESTADÏSTICAS</a>
      <ul>
         <li ><a href='tablaestabkb.php'>BALONCESTO</a>
         <li ><a href='tablaestafut.php'>FÚTBOL</a>
         <li ><a href='tablaestavol.php'>VOLEIBOL</a>
            </ul>
        <li class=' has-sub'><a href='#'>JUGADORES</a>
		<ul>
		<li><a href='crearpartido.php'>PLANILLA TITULAR</a></li>
		<li><a href='iniciarpartido.php'>CREAR PARTIDOS</a></li>
		</ul>
	
	
	<?php
	}
	if(isset($_SESSION['tipo']))
		if($_SESSION['tipo']==1) {   
	?> 
   <li class=' has-sub'><a href='#'>CREAR USUARIOS</a>
      <ul>
         <li ><a href='nuevoAdmin.php'>ADMINISTRADOR</a>
         <li ><a href='nuevoEstadistico.php'>ESTADÍSTICO</a>
         <li ><a href='nuevoEntrenador.php'>ENTRENADOR</a>
         <li ><a href='nuevoJugador.php'>JUGADOR</a>
            </ul>

	<li class=' has-sub'><a href='#'>CREAR EQUIPO</a>
      <ul>
         <li ><a href='nuevoTorneo.php'>CREAR TORNEO</a>
         <li ><a href='nuevoEquipo.php'>CREAR EQUIPO</a>
            </ul>
 
		<li class=' has-sub'><a href='#'>MOSTRAR</a>
		<ul>
		<li><a href='mostrarUsuario.php'>MOSTRAR USUARIOS</a></li>
		<li><a href='mostrarEquipo.php'>MOSTRAR EQUIPOS</a></li>
		<li><a href='mostrarTorneo.php'>MOSTRAR TORNEOS</a></li>
		</ul>
		<li class=' has-sub'><a href='#'>JUGADORES</a>
		<ul>
		<li><a href='insjug.php'>JUGADORES A EQUIPO</a></li>
		</ul>
		<li class=' has-sub'><a href='#'>REPORTES</a>
		<ul>
		<li><a href='reportes.php?modo=repusuarioes'>USUARIO</a></li>
		<li><a href='reportes.php?modo=repequiposes'>EQUIPOS</a></li>
		<li><a href='reportes.php?modo=reptorneoes'>TORNEOS</a></li>
		</ul>
    <?php
	}    
   if(isset($_SESSION['usuario'])){
   ?>
	<li class=' has-sub'><a href='#'>PERFIL</a>
	<ul>
	  <li><a href='home.php'>MI PERFIL</a></li>
   <li><a href='cerrar.php'>CERRAR SESIÓN</a></li>
   </ul>
   <?php
	}else {
	?>
   <li class="navbar-right"><a href='home.php'><i class="fa fa-sign-in"></i> INICIAR SESIÓN</a></li>
   <?php
   }
   ?>  

</ul>
</div>
</body>

<?php date_default_timezone_set('America/El_Salvador'); ?>

</html>
