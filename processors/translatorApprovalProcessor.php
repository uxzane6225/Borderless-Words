<?php
require('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	$_SESSION['notice'] = "why";
	header("Location: ../pages/adminPages/translatorsApprovalPage.php");
	exit();
}

if (isset($_POST['verify'])) {
	try {
		echo $_POST['verify'];
		$stmt = $pdo->prepare("UPDATE verification SET verify = 'verified' WHERE aid = :aid");
		$stmt->bindParam(":aid", $_POST['verify']);
		$stmt->execute();
		header("Location: ../pages/adminPages/translatorsApprovalPage.php");
		exit();
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = "Data Error: " . $e->getMessage();
		header("Location: ../pages/adminPages/translatorsApprovalPage.php");
		exit();
	}
}

if (isset($_POST['reject'])) {
	try {
		$stmt = $pdo->prepare("UPDATE verification SET verify = 'rejected' WHERE aid = :aid");
		$stmt->bindParam(":aid", $_POST['reject']);
		$stmt->execute();
		header("Location: ../pages/adminPages/translatorsApprovalPage.php");
		exit();
	}
	catch (PDOException $e) {
		$_SESSION['notice'] = "Data Error: " . $e->getMessage();
		header("Location: ../pages/adminPages/translatorsApprovalPage.php");
		exit();
	}
}