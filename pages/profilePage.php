<?php
require('../processors/config.php');
session_start();

if (!$_SESSION['logged_in']) {
	header("location: ../pages/loginPage.php");
	exit();
}

$stmt = $pdo->prepare("SELECT * FROM accounts a INNER JOIN profile p ON a.aid = p.aid WHERE a.aid = :aid");
$stmt->bindParam(":aid", $_SESSION['aid']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
	header("location: makeProfilePage.php");
	exit();
}

if (isset($_POST['logout'])) {
	session_unset();
	session_destroy();
	header("location: loginPage.php");
	exit();
}

$_SESSION['role'] = $row['role'];
$_SESSION['oldPfp'] = $row['pfp'];
$_SESSION['oldAddress'] = $row['address'];
$_SESSION['oldName'] = $row['displayName'];
$_SESSION['oldDescription'] = $row['description'];

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
	<main class="mainPagesBody">
		<div class="profileCard">
			<img id="profilePic" src="<?= $row["pfp"] ?>" alt="Profile Picture">
			<div class="profileContent">
				<h1><?= htmlspecialchars($row['displayName']) ?></h1>
				<p><?= isset($row['description']) ? htmlspecialchars($row['description']) : "No description yet.." ?></p>
			</div>
		</div>

		<div class="bottomContent">
			<aside class="menu" id="menu">
				<h2>Menu</h2>
				<div class="menuContent">
					<button id="editProfileBtn" class="menuBtn" data-page="editProfile">Edit Profile</button>
					<button id="settingsBtn" class="menuBtn" data-page="settings">Settings</button>
					<?php if($row['role'] === "client" || $row['role'] === "admin"): ?>
						<button id="hiresBtn" class="menuBtn" data-page="hires">Hires</button>
					<?php elseif($row['role'] === "translator"): ?>
						<button id="jobBtn" class="menuBtn" data-page="jobs">Jobs</button>
						<button id="hireReqBtn" class="menuBtn" data-page="hireReq">Hire Requests</button>
					<?php endif; ?>
					<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
						<button id="logoutBtn" name="logout" class="menuBtn">Logout</button>
					</form>
				</div>
			</aside>

			<form id="editProfileContent" class="selectedContent"  action="../processors/editProfileProcessor.php" method="POST" enctype="multipart/form-data">
				<header class="selectedContentHeader">
					<h2 id="editHeader">Edit Profile</h2>
				</header>
				<div class="selectedContentMain">
					<input type="file" id="newPfp" name="newPfp" class="formInput" aria-label="Upload new profile picture">
					<input type="text" id="newName" name="newName" class="formInput" placeholder="New Display / Company Name" autocomplete="off" aria-label="New display name">
					<input type="text" id="newAddress" name="newAddress" class="formInput" placeholder="New Address" autocomplete="off" aria-label="New Address">
					<input type="text" id="newDescription" name="newDescription" class="formInput" placeholder="New Description" autocomplete="off" aria-label="New Description">
				</div>
				<button id="updatebtn" name="updateBtn" class="selectedContentBtn" type="submit">Update</button>
				<?php if (isset($_SESSION['notice'])): ?>
					<p><?= $_SESSION['notice'] ?></p>
					<?php unset($_SESSION['notice']); ?>
				<?php endif; ?>
			</form>
			
			<form action="../processors/profileSettingsProcessor.php" method="POST" id="settingContent" class="selectedContent hidden">
				<header class="selectedContentHeader">
					<h2 id="seetingsHeader">Settings</h2>
				</header>
				<div class="selectedContentMain">
					<input type="text" id="newName" name="newName" class="formInput" value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : $row['fullname'] ?>" placeholder="New Full Name" autocomplete="off" aria-label="New Full Name">
					<input type="text" id="newEmail" name="newEmail" class="formInput" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : $row['email'] ?>" placeholder="New Email" autocomplete="off" aria-label="New Email">
					<input type="text" id="newPhone" name="newPhone" class="formInput"value="<?= isset($_SESSION['oldPhone']) ? $_SESSION['oldPhone'] : $row['phone'] ?>"  placeholder="New Phone" autocomplete="off" aria-label="New PHone">
					<input type="password" id="newPass" name="newPass" class="formInput" placeholder="New Password" autocomplete="off" aria-label="New Password">
				</div>
				<button id="updatebtn" name="updateBtn" class="selectedContentBtn" type="submit">Update</button>
				<?php if (isset($_SESSION['settingsNotice'])): ?>
					<p><?= $_SESSION['settingsNotice'] ?></p>
					<?php unset($_SESSION['settingsNotice']); ?>
				<?php endif; ?>
				</form>
			
			<div id="hiresContent" class="selectedContent hidden">
				<header class="selectedContentHeader">
					<h2 id="editHeader">Hires</h2>
				</header>
				<div class="selectedContentMain jobTableDiv">
					<table class="jobTable">
						<thead class="jobHead">
							<tr class="jobRow">
								<th class="jobHeader">Title</th>
								<th class="jobHeader">Description</th>
								<th class="jobHeader">Start Date</th>
								<th class="jobHeader">End Date</th>
								<th class="jobHeader">Client</th>
								<th class="jobHeader">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$job = $pdo->prepare("SELECT * FROM job j INNER JOIN accounts a ON a.aid = j.tiid WHERE ciid = ?");
								$job->execute([$_SESSION['aid']]); 
								$yourJobs = $job->fetchAll(PDO::FETCH_ASSOC);
							?>
							<?php foreach($yourJobs as $yourJob): ?>
								<tr class="jobRow">
									<td class="jobContent"><?= htmlspecialchars($yourJob['title']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['description']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['startDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['endDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['fullName']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['request']) ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div id="jobsContent" class="selectedContent hidden">
				<header class="selectedContentHeader">
					<h2 id="editHeader">Jobs</h2>
				</header>
				<div class="selectedContentMain jobTableDiv">
					<table class="jobTable">
						<thead class="jobHead">
							<tr class="jobRow">
								<th class="jobHeader">Title</th>
								<th class="jobHeader">Description</th>
								<th class="jobHeader">Start Date</th>
								<th class="jobHeader">End Date</th>
								<th class="jobHeader">Client</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$job = $pdo->prepare("SELECT * FROM job j INNER JOIN accounts a ON a.aid = j.ciid WHERE tiid = ? AND request = 'accepted'");
								$job->execute([$_SESSION['aid']]); 
								$yourJobs = $job->fetchAll(PDO::FETCH_ASSOC);
							?>
							<?php foreach($yourJobs as $yourJob): ?>
								<tr class="jobRow">
									<td class="jobContent"><?= htmlspecialchars($yourJob['title']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['description']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['startDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['endDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['fullName']) ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

			<div id="requestContent" class="selectedContent hidden">
				<header class="selectedContentHeader">
					<h2 id="editHeader">Hire Requests</h2>
				</header>
				<div class="selectedContentMain jobTableDiv">
					<table class="jobTable">
						<thead class="jobHead">
							<tr class="jobRow">
								<th class="jobHeader">Title</th>
								<th class="jobHeader">Description</th>
								<th class="jobHeader">Start Date</th>
								<th class="jobHeader">End Date</th>
								<th class="jobHeader">Client</th>
								<th class="jobHeader">Reponse</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$job = $pdo->prepare("SELECT * FROM job j INNER JOIN accounts a ON a.aid = j.ciid WHERE tiid = ? AND request = 'pending'");
								$job->execute([$_SESSION['aid']]); 
								$yourJobs = $job->fetchAll(PDO::FETCH_ASSOC);
							?>
							<?php foreach($yourJobs as $yourJob): ?>
								<tr class="jobRow">
									<td class="jobContent"><?= htmlspecialchars($yourJob['title']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['description']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['startDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['endDate']) ?></td>
									<td class="jobContent"><?= htmlspecialchars($yourJob['fullName']) ?></td>
									<td class="jobContent">
										<form action="../processors/hireResponseProcessor.php" method="POST">
											<button id="acceptBtn" name="accept" class="responseBtn" value="<?= $yourJob['jid'] ?>">Accept</button>
											<button id="rejectBtn" name="reject" class="responseBtn" value="<?= $yourJob['jid'] ?>">Reject</button>
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
	<script src="../scripts/mainPageScript.js"></script>
</body>
</html>