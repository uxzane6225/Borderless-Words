<?php
require_once '../../processors/config.php';
session_start();

if (empty($_SESSION['email'])) {
	header("location: ../loginPage.php");
	exit;
}

$stmt = $pdo->query("SELECT * FROM languages ORDER BY language ASC");
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
				<h1>Languages</h1>
			</header>
			<form class="containerContent" action="../../processors/translatorLanguageProcessor.php" method="POST">
				<div class="containerInputs">
					<div class="containerSectionInputs">
						<label for="firstLanguage">First Language</label>
						<select id="firstLanguage" name="firstLanguage" class="containerInput">
							<?php
								$stmt = $pdo->query("SELECT * FROM languages ORDER BY language ASC");
								$stmt->execute();
								$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
								$count = count($rows);
							?>
							<?php if($count > 0): ?>
								<?php foreach($rows as $row): ?>
									<option value="<?= $row['lid'] ?>"><?= $row['language'] ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="containerSectionInputs">
						<label for="secondLanguage">Second Language</label>
						<select id="secondLanguage" name="secondLanguage" class="containerInput">
							<?php if($count > 0): ?>
								<?php foreach($rows as $row): ?>
									<option value="<?= $row['lid'] ?>"><?= htmlspecialchars($row['language']) ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>

					</div>
					<?php if(isset($_SESSION['notice'])): ?>
						<p class='notice'><?= $_SESSION['notice'] ?></p>;
						<?php unset($_SESSION['notice']); ?>
					<?php endif; ?>
				</div>
				<button class="containerBtn" name="continueBtn">Continue</button>
			</form>
		</div>
	</main>
</body>
</html>