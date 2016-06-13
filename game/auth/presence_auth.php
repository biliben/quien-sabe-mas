<?php

session_start();
header('Content-Type: application/json');
require_once('pusher_info.php');

if(!isset($_SESSION['user_id']))
{
	$_SESSION['user_id'] = uniqid();
}
$presence_data = array('name' => $_SESSION['username']);

echo $_pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $_SESSION['user_id'], $presence_data);

?>