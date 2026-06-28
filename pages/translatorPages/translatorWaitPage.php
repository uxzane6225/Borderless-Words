<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	$_SESSION['notice'] = "No ID attached was found!";
	header("location: translatorLanguagePage.php");
	exit();
}

try {
	$stmt = $pdo->prepare("SELECT * FROM verification WHERE aid = :aid ORDER BY verReq DESC");
	$stmt->bindParam(":aid", $_SESSION['aid']);
	if (!$stmt->execute()) {
		$_SESION['notice'] = "An unexpected error had occured during verification!";
		header("location: translatorWaitPage.php");
		exit;
	}
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if ($result['verify'] === "verified") {
		$_SESSION['verified'] = true;
		header("location: translatorApprovedPage.php");
		exit;
	}
	else if ($result['verify'] === "rejected") {
		header("location: translatorRejectedPage.php");
		exit;
	}
	else if ($result['verify'] === null) {
		header("Location: translatorVerificationPage.php");
		exit;
	}
}
catch (PDOException $e) {
	$_SESION['notice'] = "An unexpected error had occured during verification!";
	header("location: translatorWaitPage.php");
	exit();
}
catch (Exception $e) {
	$_SESION['notice'] = "An unexpected error had occured during verification!";
	header("location: translatorWaitPage.php");
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
				<h1>Waiting for approval</h1>
			</header>
			<div class="containerContent">
				<p>Please wait, your account is still waiting for approval</p>
			</div>
			<?php if (isset($_SESSION['notice'])): ?>
				<p class='notice'><?= $_SESSION['notice'] ?></p>
				<?php unset($_SESSION['notice']);?>
			<?php endif; ?>
		</div>
	</main>
</body>
</html>