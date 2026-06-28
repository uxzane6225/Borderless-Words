<?php
session_start();

include('../processors/checkStatus.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login | Borderless Words!</title>
	<link rel="stylesheet" href="../resources/styles/formStyle.css">
	<link rel="icon" href="../resources/images/logo.png">
</head>
<body>
	<main class="formPage">
		<form class="form" action="../processors/formAuth.php" method="POST">
			<h1 class="formTitle">Welcome</h1>
			<div class="inputSection">
				<input type="email" id="email" name="email" class="formInput" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : "" ?>" placeholder="Email" autocomplete="off" aria-label="email">
				<div id="passwordSection" class="formInput" >
					<input type="password" id="password" name="password" placeholder="Password" autocomplete="off" aria-label="password">
					<button class="showPassword" id="showPassword">Show</button>
				</div>
				<a id="noAcc" href="registerPage.php">No Account? Register!</a>
				<?php if (isset($_SESSION['notice'])): ?>
						<p class='notice'><?= $_SESSION['notice'] ?></p>
					<?php unset($_SESSION['notice']); ?>
				<?php endif; ?>
			</div>
			<button id="loginBtn" name="loginBtn" class="formBtn">Login</button>
		</form>
		<div class="bgDesign">
			<h1>Borderless Words</h1>
		</div>
	</main>
	
	<script src="../scripts/loginScript.js"></script>
</body>
</html>