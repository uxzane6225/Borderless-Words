<?php
if (empty($_SESSION['aid'])) {
	header("location: ../loginPage.php");
	exit();
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: ../loginPage.php");
	exit();
}

$stmt = $pdo->prepare("SELECT * FROM accounts a INNER JOIN profile p ON a.aid = p.aid WHERE a.aid = :aid");
$stmt->bindParam(":aid", $_SESSION['aid']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
	header("Location: adminmakeProfile.php");
	exit();
}
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
	<aside class="dashboardSidebar">
		<h1 class="dashboardSidebarHeader">Administrator's Control Panel</h1>
		<button id="expandBtn">Expand</button>
		<section class="pagesList">
			<a href="adminUserStatsPage.php" class="pageList" rel="noopener noreferrer">User Stats</a>
			<a href="adminListPage.php" class="pageList" rel="noopener noreferrer">Administrator List</a>
			<a href="personalClientListPage.php" class="pageList" rel="noopener noreferrer">Personal Client List</a>
			<a href="enterpriseClientListPage.php" class="pageList" rel="noopener noreferrer">Client Enterprise List</a>
			<a href="freelanceTranslatorListPage.php" class="pageList" rel="noopener noreferrer">Freelance Translator List</a>
			<a href="organizationTranslatorListPage.php" class="pageList" rel="noopener noreferrer">Translator Organization List</a>
			<a href="translatorsApprovalPage.php" class="pageList" rel="noopener noreferrer">Translator Approval</a>
			<a href="adminInboxPage.php" class="pageList" rel="noopener noreferrer">Inbox</a>
			<!--<a href="adminCRUDLogPage.php" class="pageList" rel="noopener noreferrer">CRUD Log</a>
			<a href="adminErrorLogPage.php" class="pageList" rel="noopener noreferrer">Error Log</a>-->
		</section>
		<section class="dashboardSidebarFooter">
			<div class="adminProfile">
				<img src="../<?= $result['pfp'] ?>" class='profilePic' alt="Profile Picture">
				<div class="profileContent">
					<h2 class="adminName"><a href="adminProfilePage.php"><?= htmlspecialchars($result['fullName']) ?></a></h2>
					<p class="adminEmail"><?= htmlspecialchars($result['email']) ?></p>
				</div>
			</div>
			<div class="miscPages">
				<a href="../clientTranslatorsPage.php" class="page">Main Page</a>
				<!-- <a href="adminSettingsPage.php" class="page">Settings</a> -->
				<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
					<button id="logoutBtn" class="page"  name="logout">Logout</button>
				</form>
			</div>
		</section>
	</aside>

	<!-- <div class="nomobile">
		<h1>No mobile access!</h1>
		<p>Adminsitrators are not allowed to access their accounts through mobile devices! Please switch to a Laptop or Desktop, thank you!</p>

		<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
			<button id="logoutBtn" class="page"  name="logout">Logout</button>
		</form>
	</div> -->
<script>
	const expandBtn = document.getElementById('expandBtn');
	const pageList = document.querySelector('.pagesList');

	expandBtn.addEventListener('click', e => {
		if (pageList.classList.contains('hidden')) {
			pageList.classList.remove('hidden');
			console.log('hidden');
		}
		else {
			pageList.classList.add('hidden');
			console.log('not hidden');
		}
	});
</script>
</body>
</html>