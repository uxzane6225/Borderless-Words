<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: ../loginPage.php");
	exit();
}

require('adminAuthorized.php');

$stmt = $pdo->query("SELECT * FROM verification v INNER JOIN accounts a ON a.aid = v.aid INNER JOIN accountType att ON att.aid = v.aid WHERE v.verify = 'unhandled'");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Translator Approval | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php") ?>
	<main class="dashboardMain">
		<section class="mainContentContainer">
			<header class="mainContentHeader">
				<h2>Translator Approval</h2>
				<?php if (isset($_SESSION['notice'])): ?>
					<p class="notice"><?= $_SESSION['notice'] ?></p>
					<?php unset($_SESSION['notice']);?>
				<?php endif; ?>
			</header>
			<div class="tableContainer">
				<table class="table">
					<thead class="tableHeader">
						<tr class="tableHeaderRow">
							<th id="idHead" class="tableHead">ID</th>
							<th id="fullNameHead" class="tableHead">Full Name</th>
							<th id="emailHead" class="tableHead">Email</th>
							<th id="translatorTypeHead" class="tableHead">Translator Type</th>
							<th id="proofHead" class="tableHead">Proof</th>
							<th id="approvalHead" class="tableHead">Approval</th>
						</tr>
					</thead>
					<tbody class="tableBody">
						<?php foreach($rows as $row): ?>
							<tr class='tableBodyRow'>
								<td id="idContent" class="tableContent"><?= htmlspecialchars($row['aid']) ?></td>
								<td id='fullNameContent' class='tableContent'><?= htmlspecialchars($row['fullName']) ?></td>
								<td id='emailContent' class='tableContent'><?= htmlspecialchars($row['email']) ?></td>
								<td id='translatorTypeContent' class='tableContent'><?= htmlspecialchars($row['aType']) ?></td>
								<td id='proofContent' class='tableContent'><a href="../<?= htmlspecialchars($row['filepath']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($row['filepath']) ?></a></td>
								<td id='approvalContent' class='tableContent'>
									<form class='approvalForm' action='../../processors/translatorApprovalProcessor.php' method='POST'>	
										<button type="submit" id="verifyBtn" class="approvalBtn" name="verify" value="<?= $row['aid'] ?>">Verify</button>
										<button type="submit" id="rejectBtn" class="approvalBtn" name="reject" value="<?= $row['aid'] ?>">Reject</button>
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