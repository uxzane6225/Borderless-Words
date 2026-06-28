<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: translatorLanguagePage.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Make Profile | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/containers.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<main>
		<div class="container">
			<header id="makeProfileContainerHeader" class="containerHead">
				<h1>Verification</h1>
				<p>Upload proof of expertise (certificate, ID, diploma)</p>
			</header>
			<form class="containerContent" action="../../processors/translatorVerificationProcessor.php" method="POST" enctype="multipart/form-data">
				<div class="containerInputs">
					<input type="file" id="verify" name="verify" class="containerInput">
				</div>
				<button type="submit" class="containerBtn" name="continueBtn">Continue</button>
			</form>
			<?php if (isset($_SESSION['notice'])): ?>
				<p class='notice'><?= $_SESSION['notice'] ?></p>
				<?php unset($_SESSION['notice']);?>
			<?php endif; ?>
		</div>
	</main>
</body>
</html>