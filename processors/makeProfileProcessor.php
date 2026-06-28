<?php
require('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
	goBack("You do not have the permission to execute the processor!");
	exit();
}

if (isset($_POST['continueBtn'])) {
	$displayName = $_POST['displayName'];
	$address = $_POST['address'];
	$country = $_POST['country'];;
	
	if (empty($displayName)) {
		goBack("Display/Company name is empty!");
	}
	
	if (empty($address) ) {
		goBack("Address is empty!");
	}
	
	if (empty($country)) {
		goBack("Country is empty!");
	}
	
	try {
		$stmt = $pdo->prepare("INSERT INTO profile (aid, displayName, address, cid) VALUES (:aid, :displayName, :address, :cid)");
		$stmt->bindParam(":aid", $_SESSION['aid']);
		$stmt->bindParam(":displayName", $displayName);
		$stmt->bindParam(":address", $address);
		$stmt->bindParam(":cid", $country);
		$stmt->execute();
		$_SESSION['logged_in'] = true;
		switch ($_SESSION['role']) {
			case "client":
				header("location: ../pages/profilePage.php");
				exit();
				break;
			case "translator":
				header("location: ../pages/profilePage.php");
				exit();
				break;
			case "admin":
				header("location: ../pages/adminPages/adminProfilePage.php");
				exit();
				break;
			default:
				header("Location: ../pages/loginPage.php");
				exit();
				break;
		}
	}
	catch (PDOException $e) {
		goBack("Data Error: " . $e->getMessage());
	}
	catch (Exception $e) {
		goBack("Data Error: " . $e->getMessage());
	}
}


function goBack($message) {
	$_SESSION['notice'] = $message;
	switch ($_SESSION['role']) {
		case "client":
			header("location: ../pages/makeProfilePage.php");
			exit();
			break;
		case "translator":
			header("location: ../pages/makeProfilePage.php");
			exit();
			break;
		default:
			header("Location: ../pages/loginPage.php");
			exit();
			break;
	}
}