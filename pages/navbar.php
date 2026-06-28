<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/main.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<header class="mainPagesHeader">
		<nav class="navbar">
			<?php if($_SESSION['role'] === "client"): ?>
				<a href="clientTranslatorsPage.php" rel="noopener noreferrer">Translators</a>
			<?php elseif($_SESSION['role'] === "translator"): ?>
				<!-- <a href="translatorClientsPage.php" rel="noopener noreferrer">Clients</a> -->
			<?php elseif($_SESSION['role'] === "admin"): ?>
				<a href="adminPages/adminUserStatsPage.php" class="page">Control Panel</a>
				<a href="clientTranslatorsPage.php" rel="noopener noreferrer">Translators</a>
				<!-- <a href="translatorClientsPage.php" rel="noopener noreferrer">Clients</a> -->
			<?php else: ?>
				<a>Undefined</a>
			<?php endif; ?>
			<a href="aboutPage.php" rel="noopener noreferrer">About</a>
			<a href="contactPage.php" rel="noopener noreferrer">Contact</a>
			<a href="profilePage.php" rel="noopener noreferrer">Profile</a>
			<a href="mailPage.php" rel="noopener noreferrer">Mail</a>
		</nav>
	</header>
</body>
</html>