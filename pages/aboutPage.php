<?php
session_start();
if (!$_SESSION['logged_in']) {
	header('Location: makeProfilePage.php');
	exit();
}
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
	<?php include('navbar.php') ?>
	<main class="mainPagesBody" style="height: 90vh;">
		<div class="aboutContent">
			<div>
				<h1>About</h1>
				<p>Borderless Words is a website that offers translators a platform to easily market themselves. <br> A platform that gives the clients the options to easily choose the right translator.</p>
			</div>	
			<div>
				<h1>Mission</h1>
				<p>Our mission is to provide a platform that offers easy to access translators for professional or personal needs.</p>
			</div>	
			<div>
				<h1>Vision</h1>
				<p>Borderless Words is a platforms that envisions itself to offer everyone the opportunity to connect and break through language barriers, to freely communicate with one another.</p>
			</div>	
		</div>
	</main>
</body>
</html>