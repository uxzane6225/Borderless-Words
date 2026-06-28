<?php
require('../../processors/config.php');
session_start();

if (isset($_POST['continue'])) {
    header("Location: ../viewTranslatorPage.php ");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hired | Borderless Words</title>
    <link rel="stylesheet" href="../../resources/styles/containers.css">
    <link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
    <main>
		<div class="container">
			<header id="clientTypeContainerHeader" class="containerHead">
				<h1>Request Sent!</h1>
			</header>
			<form class="containerContent" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
				<p>Translator has been Hired!</p>
				<button name="continue" class="containerBtn">Continue</button>
			</form>
		</div>
	</main>
</body>
</html>