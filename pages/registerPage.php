<?php
session_start();
include('../processors/checkStatus.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register | Borderless Words!</title>
	<link rel="stylesheet" href="../resources/styles/formStyle.css">
	<link rel="icon" href="../resources/images/logo.png">
</head>
<body>
	<main class="formPage">
		<form class="form" action="../processors/formAuth.php" method="POST">
			<h1 class="formTitle">Registeration</h1>
			<div class="inputSection">
				<input type="text" id="fullName" name="fullName" class="formInput" value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : "" ?>" placeholder="Full Name" autocomplete="off">
				<input type="email" id="email" name="email" class="formInput" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : "" ?>" placeholder="Email" autocomplete="off">
				<input type="tel" id="phone" name="phone" class="formInput" value="<?= isset($_SESSION['oldPhone']) ? $_SESSION['oldPhone'] : "" ?>" placeholder="Phone #" autocomplete="off">
				<div id="passwordSection" class="formInput">
					<input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
					<button id="showPassword" class="showPassword">Show</button>
				</div>
				<div id="passwordSection" class="formInput">
					<input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off">
					<button id="showConfirmPassword" class="showPassword">Show</button>
				</div>
				<select id="role" name="role" class="formInput">
					<option value="client">Client</option>
					<option value="translator">Translator</option>
				</select>
				<a id="noAcc" href="loginPage.php">Have an Account? Login!</a>
				<?php if (isset($_SESSION['notice'])): ?>
						<p class='notice'><?= $_SESSION['notice'] ?></p>
					<?php unset($_SESSION['notice']); ?>
				<?php endif; ?>
			</div>
			<button id="registerBtn" name="registerBtn" class="formBtn">Register</button>
		</form>
		<div class="bgDesign">
			<h1>Borderless Words</h1>
		</div>
	</main>
	<script src="../scripts/registerScript.js"></script>
</body>
</html>