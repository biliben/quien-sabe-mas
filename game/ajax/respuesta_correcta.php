<?php
session_start();
date_default_timezone_set('Europe/London');
if($_POST){
	require_once('../auth/pusher_info.php');
	$channel = $_POST['canal'];
	$event = 'respuestaCorrecta';

	$content = array(
		'jugadorCorrecto'=>$_POST['jugador_correcto'],
		'resp_correcta'=>$_POST['resp_correcta']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>