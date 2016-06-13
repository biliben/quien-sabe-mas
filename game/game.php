<?php
require "../classes/databaseConnection.php";
require "../connection.php";
if (session_id() == '') session_start();
if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
	header("Location: ../login.php");
	exit;
}
$result = $db->callProcedure("CALL get_user_name('".$_SESSION['rival']."')");

if($db->getNumberRows($result) > 0) {
	$dato=$db->getData($result);
	$nombre_rival = $dato['correo'];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<title>GAME</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="jquery-ui/jquery-ui.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://js.pusher.com/3.1/pusher.min.js"></script>
	<script src="js/gamepush.js"></script>
</head>
<body>
	<div id="datos_partida" >
		<input type="hidden" id="control" value="<?php echo $_SESSION['jugador_cont']?>">
		<input type="hidden" id="partida" value="<?php echo $_SESSION['partida']?>">
		<input type="hidden" id="id_yo" value="<?php echo $_SESSION['yo']?>">
		<input type="hidden" id="id_rival" value="<?php echo $_SESSION['rival']?>">
		<input type="hidden" id="correcta" value="">
	</div>
	<div id="dialog-desconectado" title="Esperando respuesta" style="display:none;text-align:center;">
		<p>Su rival ha abandonado la partida</p>
	</div>
	<div class="container">
		<div class="row tama">
			<div class="col-xs-12 col-md-12 enemigo">
				<div class="col-xs-5 col-md-5 enemigo_nombre"><span><?php echo $nombre_rival ?></span></div>
				<div class="col-xs-2 col-md-2 puntuacion"><span id="punt-enemi">0</span><div class="correct" style="display:none;">Correcto</div><div class="incorrecto" style="display:none;">Incorrecto</div></div>
				<div class="col-xs-5 col-md-5 enemigo_foto"><img class="img_enemigo" src="img/icono.png"></div>
			</div>
			<div class="col-xs-12 col-md-12 ready centrado-porcentual" style="display:none;">
				<div class="item-ready col-xs-4 col-md-4 no_ready" id="yo_ready" value="0">
					<span class="centrado-porcentual">¿Preparado?</span>
				</div>
				<div class="contador-ready col-xs-4 col-md-4" >
					<span id="contador" class="centrado-porcentual num_contador">3</span>
				</div>
				<div class="item-ready col-xs-4 col-md-4 no_ready" id="rival_ready" value="0"></div>
			</div>
			<div class="col-xs-12 col-md-12 centrado-porcentual final" style="display:none">
				<div class="item-ready col-xs-12 col-md-12 resultadofinal" id="ganador" style="height:50%">
					<span class="centrado-porcentual"> Has Perdido </span>
				</div>
				<div class="item-ready col-xs-12 col-md-12 finalizar salir" style="height:50%">
					<span class="centrado-porcentual"> Salir </span>
				</div>
			</div>
			<div class="col-xs-12 col-md-12 loading centrado-porcentual">
				<span class="centrado-porcentual"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br>
					<span>Loading...</span>
				</span>
			</div>
			<div class="col-xs-12 col-md-12 tablero">

			</div>
			<div class="col-xs-12 col-md-12 jugador">
				<div class="col-xs-5 col-md-5 jugador_foto"><img class="img_jugador" src="img/icono.png"></div>
				<div class="col-xs-2 col-md-2 puntuacion">
					<div class="progress progress-striped" style="height:5px;margin:0;">
						<div id="progressbar" class="progress-bar progress-bar-success" role="progressbar"
						aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;margin:0;">
					</div>
				</div>
				<span id="my-punts">0</span>
				<div class="correct" style="display:none;">Correcto</div>
				<div class="incorrecto" style="display:none;">Incorrecto</div>
			</div>
			<div class="col-xs-5 col-md-5 jugador_nombre"><span><?php echo $_SESSION['username']?></span></div>
		</div>
	</div>
</div>
</body>
</html>