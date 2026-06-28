<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: ../loginPage.php");
	exit();
}

require('adminAuthorized.php');
$stmt = $pdo->query("SELECT * FROM accounts a INNER JOIN profile p ON a.aid = p.aid INNER JOIN accountType act ON act.aid = p.aid WHERE aType = 'enterprise'");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Client Enterprise List | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php") ?>
	<main class="dashboardMain">
		<section class="mainContentContainer">
			<header class="mainContentHeader">
				<h2>Client Enterprise List</h2>
				<?php if (isset($_SESSION['notice'])): ?>
					<p class="notice"><?= $_SESSION['notice'] ?></p>
					<?php unset($_SESSION['notice'])?>
				<?php endif; ?>
			</header>
			<div class="tableContainer">
				<table class="table">
					<thead class="tableHeader">
						<tr class="tableHeaderRow">
							<th id="idHead" class="tableHead">ID</th>
							<th id="fullNameHead" class="tableHead">Full Name</th>
							<th id="displayNameHead" class="tableHead">Display Name</th>
							<th id="emailHead" class="tableHead">Email</th>
							<th id="phoneHead" class="tableHead">Phone #</th>
							<th id="addressHead" class="tableHead">Address</th>
							<th id="translatorTypeHead" class="tableHead">Client Type</th>
							<th id="crudHead" class="tableHead">Control</th>
						</tr>
					</thead>
					<tbody class="tableBody">
						<?php foreach($rows as $row): ?>
							<tr class='tableBodyRow'>
								<td id='idContent' class='tableContent'><?= htmlspecialchars($row['aid']) ?></td>
								<td id='fullNameContent' class='tableContent'><?= htmlspecialchars($row['fullName']) ?></td>
								<td id='displayNameContent' class='tableContent'><?= htmlspecialchars($row['displayName']) ?></td>
								<td id='emailContent' class='tableContent'><?= htmlspecialchars($row['email']) ?></td>
								<td id='phoneContent' class='tableContent'><?= htmlspecialchars($row['phone']) ?></td>
								<td id='addressContent' class='tableContent'><?= htmlspecialchars($row['address']) ?></td>
								<td id='clientTypeContent' class='tableContent'><?= htmlspecialchars($row['aType']) ?></td>
								<td id="crudContent" class="tableContent">
									<form action="../../processors/adminCrudProcessor.php" method="POST">
										<button id="viewBtn" name="viewBtn" class="crudBtn" value="<?= $row['aid'] ?>">View</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	</main>
</body>
</html>