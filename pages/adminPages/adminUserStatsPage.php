<?php
require('../../processors/config.php');
session_start();
require('adminAuthorized.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php") ?>
	<main class="dashboardMain">
		<header class="mainContentHeader">
			<h2>User Stats</h2>
		</header>
		<div class="stats">
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Total Number of Users</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts WHERE role = 'client'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Total number of Client Users</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts WHERE role = 'translator'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Total number of Translator Users</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts WHERE role = 'admin'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Number of Administrators</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts a INNER JOIN accountType act ON a.aid = act.aid WHERE role = 'client' AND aType = 'personal'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Number of Personal Client Users</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts a INNER JOIN accountType act ON a.aid = act.aid WHERE role = 'client' AND aType = 'enterprise'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Number of Client Enterprise</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts a INNER JOIN accountType att ON a.aid = att.aid WHERE role = 'translator' AND aType = 'freelance'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Number of Freelance Translators</p>
			</div>
			<div class="statsCard">
				<?php
					$stmt = $pdo->query("SELECT COUNT(*) FROM accounts a INNER JOIN accountType att ON a.aid = att.aid WHERE role = 'translator' AND aType = 'organization'");
					$result = $stmt->fetch()['COUNT(*)'];
					echo "<h2>{$result}</h2>";
				?>
				<p>Number of Translation Organization</p>
			</div>
		</div>
	</main>
</body>
</html>