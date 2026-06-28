<?php
require('config.php');
require('functionForProcessors.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	$_SESSION['notice'] = "You do not have the permission to execute the processor";
	header("Location: ../pages/translatorPages/translatorLanguagePage.php");
	exit();
}

if (isset($_POST['continueBtn'])) {
	if (empty($_POST['firstLanguage']) || empty($_POST['secondLanguage'])) {
		goBack("../pages/translatorPages/translatorLanguagePage.php", "How did you manage to choose blanks!?");
	}
	
	if ($_POST['firstLanguage'] === $_POST['secondLanguage']) {
		goBack("../pages/translatorPages/translatorLanguagePage.php", "Languages must be differnt from each other!");
	}
	
	$email = $_SESSION['email'];
	$first = $_POST['firstLanguage'];
	$second = $_POST['secondLanguage'];

	try {		
		$findId = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
		$findId->bindParam(":email", $email);
		$findId->execute();
		$result = $findId->fetch(PDO::FETCH_ASSOC);
		
		if (!$result) {
			throw new PDOException("No account found!");
		}
		$aid = $result['aid'];
		
		$stmt = $pdo->prepare("INSERT INTO translatorsFirstLanguage (lid, aid) VALUES (:lid, :aid)");
		$stmt->bindParam(":lid", $first);
		$stmt->bindParam(":aid", $aid);
		if (!$stmt->execute()) {
			throw new PDOException("Error: First language failed to execute!");
		}
		
		$stmt = $pdo->prepare("INSERT INTO translatorsSecondLanguage (lid, aid) VALUES (:lid, :aid)");
		$stmt->bindParam(":lid", $second);
		$stmt->bindParam(":aid", $aid);
		if (!$stmt->execute()) {
			throw new PDOException("Error: Second language failed to execute!");
		}
		
		$_SESSION['aid'] = $aid;
		$_SESSION['hasLanguage'] = true;
		header("location: ../pages/translatorPages/translatorVerificationPage.php");
		exit();
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = "Data Error: " . $e->getMessage();
		header("Location: ../pages/translatorPages/translatorLanguagePage.php");
		exit();
	}
	catch (Exception $e) {
		$_SESSION['notice'] = "General Error: " . $e->getMessage();
		header("Location: ../pages/translatorPages/translatorLanguagePage.php");
		exit();
	}
}
