<?php

	require_once('Pusher.php');

	define('PUSHER_API_KEY', '2ded2143163474bf5f70');
	define('PUSHER_API_SECRET', '6dd269caaa2efc6f091b');
	define('PUSHER_APP_ID', '205821');
	
	$_pusher = new Pusher(PUSHER_API_KEY, PUSHER_API_SECRET, PUSHER_APP_ID);

?>