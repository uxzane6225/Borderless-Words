<?php
$host = "localhost:3308";
$db = "borderlesswordsdb";
$user = "root";
$pass = "";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

try {
	$pdo = new PDO($dsn, $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	session_start();
	$_SESSION['error'] = $e->getMessage();
	header("location: ../pages/errorPage.php");
}