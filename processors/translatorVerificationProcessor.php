<?php
require('config.php');
require('functionForProcessors.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	$_SESSION['notice'] = "No permission to continue";
	header("location: ../pages/translatorPages/translatorVerificationPage.php");
	exit();
}

if (isset($_POST['continueBtn'])) {
	if (empty($_FILES['verify'])) {
		goBack("../pages/translatorPages/translatorVerificationPage.php","File is empty!");
	}
	
	$file = $_FILES['verify'];
	
	$fileName = $_FILES['verify']['name'];
	$fileTmpName = $_FILES['verify']['tmp_name'];
	$fileSize = $_FILES['verify']['size'];
	$fileError = $_FILES['verify']['error'];
	$fileType = $_FILES['verify']['type'];
	
	$fileExt = explode(".", $fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed = array('jpg', 'jpeg', 'png', 'pdf');
	
	if (!in_array($fileActualExt, $allowed)) {
		goBack("../pages/translatorPages/translatorVerificationPage.php","File type is not allowed!");
	}
	
	if ($fileError !== 0) {
		goBack("../pages/translatorPages/translatorVerificationPage.php","Upload failed!");
	}
	
	if ($fileSize > 1000000) {
		goBack("../pages/translatorPages/translatorVerificationPage.php","File is too large!");
	}
	
	$fileNameNew = uniqid('', true).".".$fileActualExt;
	$fileDestination = '../storage/verification/'.$fileNameNew;
	move_uploaded_file($fileTmpName, $fileDestination);
	
	try {
		$stmt = $pdo->prepare("INSERT INTO verification (filepath,aid) VALUES (:filepath, :aid)");
		$stmt->bindParam(":filepath", $fileDestination);
		$stmt->bindParam(":aid", $_SESSION['aid']);
		$stmt->execute();
		header("location: ../pages/translatorPages/translatorWaitPage.php");
		exit();
	}
	catch (PDOException $e) {
		session_unset();
		session_destroy();
		$_SESSION['notice'] = "Data Error: " . $e->getMessage();
		header("location: ../pages/translatorPages/translatorVerificationPage.php");
		exit();
	}
	catch (Exception $e) {
		session_unset();
		session_destroy();
		$_SESSION['notice'] = "General Error: " . $e->getMessage();
		header("location: ../pages/translatorPages/translatorVerificationPage.php");
		exit();
	}
}