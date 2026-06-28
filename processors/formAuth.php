<?php
session_start();
require('config.php');
require('functionForProcessors.php');


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	$_SESSION['notice'] = "You did not have the proper permission to execute the processor";
	header("Location: ../pages/loginPage.php");
	exit;
}

if (isset($_POST['loginBtn'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$_SESSION['oldEmail'] = $email;
	
	if (empty($email)) {
		goBack("../pages/loginPage.php", "Email is empty!");
	}
	else if (empty($password)) {
		goBack("../pages/loginPage.php", "Password is empty!");
	}
		
	try {
		$stmt = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
		$stmt->bindParam(":email", $email);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!$result) {
			throw new PDOException("Email doesn't exist");
		}
		
		$_SESSION['email'] = $email;
		$_SESSION['role'] = $result['role'];
		$_SESSION['aid'] = $result['aid'];
		
		if (!password_verify($password, $result['password'])) {
			throw new Exception("Wrong password!");
		}

		unset($_SESSION['oldEmail']);

		$_SESSION['logged_in'] = true;

		switch ($_SESSION['role']) {
			case "client":
				header("location: ../pages/profilePage.php");
				break;
			case "translator":
				header("location: ../pages/profilePage.php");
				break;
			case "admin":
				header("location: ../pages/adminPages/adminUserStatsPage.php");
				break;
			default:
				header("location: ../pages/loginPage.php");
				break;
		}
		exit;
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = $e->getMessage();
		header("Location: ../pages/loginPage.php");
		exit;
	}
	catch (Exception $e) {
		$_SESSION['notice'] = $e->getMessage();
		header("Location: ../pages/loginPage.php");
		exit;
	}
}

if (isset($_POST['registerBtn'])) {
	$fullName = $_POST['fullName'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	$role = $_POST['role'];

	$_SESSION['oldName'] = $fullName;
	$_SESSION['oldEmail'] = $email;
	$_SESSION['oldPhone'] = $phone;
	
	if (empty($fullName)) {
		goBack("../pages/registerPage.php","Full name is empty!");
	}
	
	if (empty($email)) {
		goBack("../pages/registerPage.php","Email is empty!");
	}
	
	if (empty($phone)) {
		goBack("../pages/registerPage.php","Phone number is empty!");
	}
	
	if (empty($password) ) {
		goBack("../pages/registerPage.php","Password is empty!");
	}
	
	if (empty($role)) {
		goBack("../pages/registerPage.php","Role is empty!");
	}
	
	if ($password !== $confirmPassword) {
		goBack("../pages/registerPage.php","Password doesn't match!");
	}
	
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	try {
		$reg = $pdo->prepare("INSERT INTO accounts (fullName, email, password, phone, role) VALUES (:fullName, :email, :password, :phone, :role)");
		$reg->bindParam(":fullName", $fullName);
		$reg->bindParam(":email", $email);
		$reg->bindParam(":password", $hashedPassword);
		$reg->bindParam(":phone", $phone);
		$reg->bindParam(":role", $role);
		$reg->execute();
		
		$_SESSION['email'] = $email;
		$_SESSION['role'] = $role;
		$_SESSION['logged_in'] = true;

		unset($_SESSION['oldName']);
		unset($_SESSION['oldEmail']);
		unset($_SESSION['oldPhone']);
		
		if ($role === "client") {
			header("location: ../pages/accountTypePage.php");
		}
		else if ($role === "translator") {
			header("location: ../pages/accountTypePage.php");
		}
		exit;
	}
	catch (PDOException $e) {
		if ($e->getCode() == 23000) {
			$_SESSION['notice'] = "Account already exists!";
			header("location: ../pages/registerPage.php");
			exit;
		}
		else {
			$_SESSION['notice'] = "Data Error: " . $e->getMessage();
			header("location: ../pages/registerPage.php");
			exit;
		}
	}
	catch (Exception $e) {
		$_SESSION['notice'] = "General Error: " . $e->getMessage();
		header("location: ../pages/registerPage.php");
		exit;
	}
}
