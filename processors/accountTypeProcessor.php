<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	$_SESSION['notice'] = "You do not have the permission to execute the processor";
	header("Location: ../pages/accountTypePage.php");
	exit;
}

if (isset($_POST['continue'])) {
	$email = $_SESSION['email'];
	$aType = $_POST['aType'];
	
	try {
		$findId = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
		$findId->bindParam(":email", $email);
		$findId->execute();
		
		$result = $findId->fetch(PDO::FETCH_ASSOC);
		if (!$result) {
			session_unset();
			session_destroy();
			throw new PDOException("No account found!");
		}
		
		$_SESSION['aid'] = $result['aid'];
		
		$stmt = $pdo->prepare("INSERT INTO accountType (aType, aid) VALUES (:aType, :aid)");
		$stmt->bindParam(":aType", $aType);
		$stmt->bindParam(":aid", $_SESSION['aid']);
		$stmt->execute();
		
		switch ($_SESSION['role']) {
			case "client":
				header("Location: ../pages/makeProfilePage.php");
				break;
			case "translator":
				header("Location: ../pages/translatorPages/translatorLanguagePage.php");
				break;
			default:
				header("Location: ../pages/accountTypePage.php");
		}
		
		exit;
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = "Data Error: " . $e->getMessage();
		header("Location: ../pages/accountTypePage.php");
		exit;
	}
}