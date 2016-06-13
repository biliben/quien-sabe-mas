<?php
session_start();
date_default_timezone_set('Europe/London');
if($_POST){
	require_once('../auth/pusher_info.php');
	$channel = $_POST['canal'];
	$event = 'respuestaIncorrecta';

	$content = array(
		'jugadorIncorrecto'=>$_POST['jugador_incorrecto']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>