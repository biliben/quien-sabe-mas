<?php
date_default_timezone_set('Europe/London');
if($_POST){
	require_once('../auth/pusher_info.php');
	$channel = 'presence-quien';
	$event = 'peticion_juego_aceptada';

	$content = array(
		'jugador1'=>$_POST['jugador1'],
		'jugador2'=>$_POST['jugador2'],
		'partida'=>$_POST['jugador1']."_vs_".$_POST['jugador2']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>