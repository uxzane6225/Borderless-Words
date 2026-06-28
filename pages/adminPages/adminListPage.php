<?php
require('../../processors/config.php');
session_start();
require('adminAuthorized.php');

$stmt = $pdo->query("SELECT * FROM accounts a INNER JOIN profile p ON a.aid = p.aid WHERE role = 'admin'");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrator List | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php") ?>
	<main class="dashboardMain">
		<section class="mainContentContainer">
			<header class="mainContentHeader">
				<h2>Administrator List</h2>
				<?php if (isset($_SESSION['notice'])): ?>
					<p class="notice"><?=  $_SESSION['notice'] ?></p>
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
							<th id="crudHead" class="tableHead">Control</th>
						</tr>
					</thead>
					<tbody class="tableBody">
						<?php foreach($rows as $row): ?>
							<tr class="tableBodyRow">
								<td id="idContent" class="tableContent"><?= htmlspecialchars($row['aid']) ?></td>
								<td id="fullNameContent" class="tableContent"><?= htmlspecialchars($row['fullName']) ?></td>
								<td id="displayNameContent" class="tableContent"><?= htmlspecialchars($row['displayName']) ?></td>
								<td id="emailContent" class="tableContent"><?= htmlspecialchars($row['email']) ?></td>
								<td id="phoneContent" class="tableContent"><?= htmlspecialchars($row['phone']) ?></td>
								<td id="addressContent" class="tableContent"><?= htmlspecialchars($row['address']) ?></td>
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
			<a id="addAdminBtn" href="createAdminPage.php">Add Admin</a>
		</section>
	</main>
</body>
</html>