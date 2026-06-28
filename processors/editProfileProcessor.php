<?php
require('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	header("Location: ../pages/profilePage.php");
	exit();
}

if (isset($_POST['updateBtn'])) {
	$newName = $_POST['newName'];
	$newAddress = $_POST['newAddress'];
	$newDescription = $_POST['newDescription'];
	
	if (empty($_SESSION['role'])) {
		goBackToProfile("You have no account type!", $_SESSION['role']);
	}
	
	if (empty($newName) && empty($newAddress) && empty($newDescription) && empty($_FILES['newPfp']['name'])) {
		goBackToProfile("No changes were made!", $_SESSION['role']);
	}
	
	if (empty($newName)) {
		$newName = $_SESSION['oldName'];
	}

	if (empty($newAddress)) { 
		$newAddress = $_SESSION['oldAddress'];
	}
	
	if (empty($newDescription)) { 
		$newDescription = $_SESSION['oldDescription'];
	}
	
	if (empty($_FILES['newPfp']['name'])) {
		$fileDestination = $_SESSION['oldPfp'];
		echo "file is empty";
	}
	else {
		$fileName = $_FILES['newPfp']['name'];
		$fileTmpName = $_FILES['newPfp']['tmp_name'];
		$fileSize = $_FILES['newPfp']['size'];
		$fileError = $_FILES['newPfp']['error'];
		$fileType = $_FILES['newPfp']['type'];

		$fileExt = explode(".", $fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		$allowed = array('jpg', 'jpeg', 'png', 'pdf');
		
		if (!in_array($fileActualExt, $allowed)) {
			goBackToProfile("File type is not allowed!", $_SESSION['role']);
		}
		
		if ($fileError !== 0) {
			goBackToProfile("Upload failed!", $_SESSION['role']);
		}
		
		if ($fileSize > 1000000) {
			goBackToProfile("File is too large!", $_SESSION['role']);
		}
		
		$fileNameNew = uniqid('', true).".".$fileActualExt;
		$fileDestination = '../storage/pfp/'.$fileNameNew;
		move_uploaded_file($fileTmpName, $fileDestination);
	}

	try {		
		$stmt = $pdo->prepare("UPDATE profile SET pfp = :pfp, displayName = :displayName, address = :address, description = :description, updateDateTime = CURRENT_TIMESTAMP() WHERE aid = :aid");
		$stmt->bindParam(":aid" , $_SESSION['aid']);
		$stmt->bindParam(":pfp", $fileDestination);
		$stmt->bindParam(":displayName", $newName);
		$stmt->bindParam(":address", $newAddress);
		$stmt->bindParam(":description", $newDescription);
		$stmt->execute();
		
		$_SESSION['notice'] = "Profile has been updated!";
		switch ($_SESSION['role']) {
			case "client":
			case "translator":
				header("Location: ../pages/profilePage.php");
				break;
			case "admin":
				header("Location: ../pages/adminPages/adminProfilePage.php");
				break;
			default:
				throw new Exception("I absolutely have no idea what you're doing here.");
		}
		exit();
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = $e->getMessage();
		switch ($_SESSION['role']) {
			case "client":
			case "translator":
				header("Location: ../pages/profilePage.php");
				break;
			case "admin":
				header("Location: ../pages/adminPages/adminProfilePage.php");
				break;
			default:
				header("Location: ../pages/loginPage.php");
				break;
		}
		exit();
	}
	catch (Exception $e) {
		$_SESSION['notice'] = $e->getMessage();
		switch ($_SESSION['role']) {
			case "client":
			case "translator":
				header("Location: ../pages/profilePage.php");
				break;
			case "admin":
				header("Location: ../pages/adminPages/adminProfilePage.php");
				break;
			default:
				header("Location: ../pages/loginPage.php");
				break;
		}
		exit();
	}
}

function goBackToProfile($message, $role) {
	$_SESSION['notice'] = $message;
	switch ($role) {
		case "client":
		case "translator":
			header("Location: ../pages/profilePage.php");
			break;
		case "admin":
			header("Location: ../pages/adminPages/adminProfilePage.php");
			break;
		default:
			header("Location: ../pages/loginPage.php");
			break;
	}
	exit();
}