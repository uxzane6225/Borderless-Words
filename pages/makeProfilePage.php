<?php
require('../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: accountTypePage.php");
	exit;
}

if ($_SESSION['role'] === "translator") {
	if (!$_SESSION['verified']) {
		header("Location: translatorPages/translatorApprovedPage.php");
		exit;
	}
}

$stmt = $pdo->prepare("SELECT * FROM accountType WHERE aid = :aid");
$stmt->bindParam(":aid", $_SESSION['aid']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	header("Location: accountTypePage.php");
	exit();
}

$stmt = $pdo->query("SELECT * FROM countries ORDER BY country ASC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($rows);
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
				<h1>Profile</h1>
			</header>
			<form class="containerContent" action="../processors/makeProfileProcessor.php" method="POST">
				<div class="containerInputs">
					<input type="text" id="dsplayName" name="displayName" class="containerInput" placeholder="Display / Company Name" autocomplete="off">
					<input type="text" id="address" name="address" class="containerInput" placeholder="Address" autocomplete="off">
					<select id="country" name="country" class="containerInput">
						<?php if ($count > 0): ?>
							<?php forEach ($rows as $row): ?>
								<option value="<?= $row["cid"] ?>"><?= htmlspecialchars($row['country']) ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<?php if (isset($_SESSION['notice'])): ?>
						<p class='notice'><?= htmlspecialchars($_SESSION['notice']) ?></p>
						<?php unset($_SESSION['notice']); ?>
					<?php endif; ?>
				</div>
				<button class="containerBtn" name="continueBtn">Continue</button>
			</form>
		</div>
	</main>
</body>
</html>