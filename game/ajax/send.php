<?php
date_default_timezone_set('Europe/London');
if($_POST){
	require_once('../auth/pusher_info.php');
	$channel = 'presence-quien';
	$event = 'peticion_juego';

	$content = array(
		'petidor'=>$_POST['petidor'],
		'invitado'=>$_POST['invitado'],
		'nombrePetidor'=>$_POST['nombrePetidor']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>