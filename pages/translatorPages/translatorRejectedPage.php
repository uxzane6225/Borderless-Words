<?php
require("../../processors/config.php");
session_start();

if (empty($_SESSION['aid'])) {
	header("Location: translatorWaitPage.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (isset($_POST['continue'])) {
		$_SESSION['notice'] = "Your verification was rejected, try again!";
		header("location: translatorVerificationPage.php");
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rejected | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/containers.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<main>
		<div class="container">
			<header id="clientTypeContainerHeader" class="containerHead">
				<h1>Rejected!</h1>
			</header>
			<form class="containerContent" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
				<p>We're sorry, your verification has been rejected! Please try again.</p>
				<button name="continue" class="containerBtn">Continue</button>
			</form>
		</div>
	</main>
</body>
</html>