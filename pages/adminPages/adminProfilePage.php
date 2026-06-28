<?php
require('../../processors/config.php');
session_start();

if (empty($_SESSION['aid'])) {
	header("location: ../loginPage.php");
	exit();
}

require('adminAuthorized.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Profile Page | Borderlesswords</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
	<?php include("adminNavbar.php"); ?>
	<main id="profilePageContainer" class="dashboardMain">
		<section class="profileContainer">
			<header class="profileContainerHeader">
				<img id="profilePic" src="../<?= $result['pfp'] ?>" alt="Profile Picture">
				<div class="profileHeaderContent">
					<h2><?= $result['displayName'] ?></h2>
					<p><?= $result['email'] ?></p>
					<p><?= $result['description'] ?></p>
				</div>
			</header>
			<div id="editProfileContainer" class="profileContainerContent">
				<h2 id="editProfileHeader">Edit Profile</h2>
				<form id="editProfileContent" action="../../processors/editProfileProcessor.php" method="POST" enctype="multipart/form-data">
					<input type="file" id="newPfp" name="newPfp" class="editInput">
					<div class="editDiv">
						<label for="newName">Display Name</label>
						<input type="text" id="newName" name="newName" class="editInput" placeholder="Example: Admin" autocomplete="off">
					</div>
					<div class="editDiv">
						<label for="newAddress">Address</label>
						<input type="text" id="newAddress" name="newAddress" class="editInput" placeholder="Example: 123 Fake St." autocomplete="off">
					</div>
					<div class="editDiv">
						<label for="newDescription">Description</label>
						<textarea type="text" id="newDescription" name="newDescription" class="editInput" placeholder="Example: something interesting" autocomplete="off"></textarea>
					</div>
					<button id="updatePfbtn" name="updateBtn" class="selectedContentBtn" type="submit">Update</button>
					<?php if(isset($_SESSION['notice'])):  ?>
						<p><?= $_SESSION['notice'] ?></p>
						<?php unset($_SESSION['notice']) ?>
					<?php endif; ?>
				</form>
			</div>
		</section>
	</main>
</body>
</html>