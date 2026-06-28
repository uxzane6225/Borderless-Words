<?php
require('../processors/config.php');
session_start();

if (empty($_SESSION['email'])) {
	header("location: loginPage.php");
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account Type | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/containers.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<main>
		<div id="clientTypeContainer" class="container">
			<header id="clientTypeContainerHeader" class="containerHead">
				<?php if($_SESSION['role'] === "client"): ?>
					<h1>Client Type</h1>
				<?php elseif($_SESSION['role'] === "translator"): ?>
					<h1>Translator Type</h1>
				<?php else: ?>
					<?php header('Location: makeProfilePage.php'); exit; ?>
				<?php endif; ?>
			</header>
			<form class="containerContent" action="../processors/accountTypeProcessor.php" method="POST">
				<select name="aType" class="containerInput">
					<?php if($_SESSION['role'] === "client"): ?>
						<option value="personal">Personal</option>
						<option value="enterprise">Enterprise</option>
					<?php elseif($_SESSION['role'] === "translator"): ?>
						<option value="freelance">Freelance</option>
						<option value="organization">Organization</option>
					<?php else: ?>
						<option value="undefined">Undefined</option>
					<?php endif; ?>
				</select>
				<button type="submit" id="continue" class="containerBtn" name="continue">Continue</button>
			</form>
		</div>
		<?php if (isset($_SESSION['notice'])): ?>
			<p class='notice'><?= $_SESSION['notice'] ?></p>
			<?php unset($_SESSION['notice']); ?>
		<?php endif; ?>
	</main>
</body>
</html>