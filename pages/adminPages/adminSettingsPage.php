<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: ../loginPage.php");
	exit;
}
require('adminAuthorized.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Settings Page | Borderlesswords</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php"); ?>
	<main class="dashboardMain">
	
	</main>
</body>
</html>