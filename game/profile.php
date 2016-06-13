<?php
if (session_id() == '') session_start();

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
	header("Location: ../login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<title>Profile - User</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style_profile.css">
	<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="jquery-ui/jquery-ui.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://js.pusher.com/3.1/pusher.min.js"></script>
	<script src="js/howtopush.js"></script>
</head>
<body>
	<div class="container">
		<div id="datos">
			<input type="hidden" id="myId" value="<?php echo $_SESSION['user_id'] ?>">
			<input type="hidden" id="myName" value="<?php echo $_SESSION['username'] ?>">
		</div>
		<div id="dialog-enviado" title="Esperando respuesta" style="display:none;text-align:center;">
			<p>Enviada peticion de partida<br>Esperando respuesta</p>
		</div>
		<div id="dialog-confirm" title="Esperando respuesta" style="display:none;text-align:center;"></div>
		<div id="dialog-denegado" title="Esperando respuesta" style="display:none;text-align:center;">
			<p>Peticion rechazada</p>
		</div>
		<div class="row tama">
			<div class="col-xs-12 col-md-12 panel">
				<div class="col-xs-12 col-md-12 apartados"><span class="pos-name"><?php echo $_SESSION['username']?></span></div>
			</div>
			<div class="col-xs-12 col-md-12 panel panel-img">
				<img class="img" src="img/icono.png">
			</div>
			<div class="col-xs-12 col-md-12 tablero">
				<div id="online" class="col-md-4 col-xs-12">
					<h2>Jugadores Online</h2>
				</div>
			</div>
		</div>
	</div>
</body>
</html>