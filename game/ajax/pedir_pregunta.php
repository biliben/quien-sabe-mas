<?php
date_default_timezone_set('Europe/London');

if($_POST){
	require_once('../auth/pusher_info.php');
	require "../../classes/databaseConnection.php";
	require "../../connection.php";
	$result = $db->callProcedure("CALL get_pregunta()");

	if($db->getNumberRows($result) > 0) {
		$dato=$db->getData($result);
	}

	$channel = $_POST['canal'];
	$event = 'pregunta';

	$content = array(
		'pregunta'=>$dato['pregunta'],
		'respuesta1'=>$dato['respuesta_1'],
		'respuesta2'=>$dato['respuesta_2'],
		'respuesta3'=>$dato['respuesta_3'],
		'respuesta4'=>$dato['respuesta_4'],
		'correcta'=>$dato['respuesta_correcta'],
		'imagen'=>$dato['imagen']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>