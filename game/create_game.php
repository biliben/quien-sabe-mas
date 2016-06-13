<?php
session_start();

$_SESSION['jugador_cont'] = $_POST['jugador_cont'];
$_SESSION['yo'] = $_POST['yo'];
$_SESSION['rival'] = $_POST['rival'];
$_SESSION['partida'] =  $_POST['partida'];

header('Location: game.php');
?>