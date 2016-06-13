<?php
if (session_id() == '') session_start();

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
	header("Location: login.php");
	exit;
}else{
	header("Location: game/profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>¿Quien sabe mas?</title>
</head>
<body>
<a href="logout.php">Logout</a>
<h1>ID -> <?php echo $_SESSION['user_id']?></h1>
<h4>Correo -> <?php echo $_SESSION['username']?></h4>
</body>
</html>