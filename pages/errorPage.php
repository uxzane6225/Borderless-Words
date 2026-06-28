<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Error </title>
	<link rel="stylesheet" href="../resources/styles/containers.css">
	<link rel="icon" href="../resources/images/logo.png">
</head>
<body>
	<main>
		<div id="errorContainer" class="container">
			<header class="containerHead">
				<h1>Error</h1>
				<p>It seems like there's a server error!</p>
			</header>
			<div class="containerContent">
				<?php if (isset($_SESSION['error'])): ?>
					<p class='notice'><?= $_SESSION['error']; ?></p>
				<?php endif; ?>
			</div>
		</div>
	</main>
</body>
</html>