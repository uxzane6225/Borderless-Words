<?php
require('../../processors/config.php');
$stmt = $pdo->prepare("SELECT * FROM accounts a INNER JOIN profile p ON p.aid = a.aid WHERE a.aid = :aid AND role = 'admin'");
$stmt->execute([ ":aid" => $_SESSION['aid'] ]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	header("location: ../makeProfilePage.php");
	exit();
}

$_SESSION['role'] = $result['role'];
$_SESSION['oldPfp'] = $result['pfp'];
$_SESSION['oldName'] = $result['displayName'];
$_SESSION['oldAddress'] = $result['address'];
$_SESSION['oldDescription'] = $result['description'];