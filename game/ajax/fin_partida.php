<?php
session_start();
date_default_timezone_set('Europe/London');
if($_POST){
	require_once('../auth/pusher_info.php');
	require "../../classes/databaseConnection.php";
	require "../../connection.php";
	$result = $db->callProcedure("CALL insert_partida('".$_POST['jugador1']."','".$_POST['jugador2']."',".$_POST['punt_jug1'].",".$_POST['punt_jug2'].")");
	$channel = $_POST['canal'];
	$event = 'finpartida';

	$content = array(
		'jugador1'=>$_POST['jugador1'],
		'jugador2'=>$_POST['jugador2'],
		'punt_jug1'=>$_POST['punt_jug1'],
		'punt_jug2'=>$_POST['punt_jug2']
		);

	$_pusher->trigger($channel, $event, $content);

	echo(1);
}else{
	die("<p><b>Error:</b> No post data!</p>");
}

?>