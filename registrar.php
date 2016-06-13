<?php
session_start();
require "classes/databaseConnection.php";
require "connection.php";
if ($_POST['submit']=="Iniciar") {
	$result = $db->callProcedure("CALL load_user('".$_POST['user-email']."','".$_POST['user-pw']."')");
	
	if($db->getNumberRows($result) > 0) {
		$dato=$db->getData($result);
		$_SESSION['user_id'] = $dato['id_usuario'];
		$_SESSION['username'] = $dato['correo'];
		header("Location: game/profile.php");
		exit;
	}else{
		header("Location: login.php");
		exit;
	}
	
}elseif($_POST['submit']=="Crear"){
	$uniq_id = uniqid();
	$db->callProcedure("CALL insert_user('".$uniq_id."','".$_POST['user-email']."','".$_POST['user-pw']."')");
	$_SESSION['user_id'] = $uniq_id;
	$_SESSION['username'] = $_POST['user-email'];
	header("Location: game/profile.php");
	exit;
}