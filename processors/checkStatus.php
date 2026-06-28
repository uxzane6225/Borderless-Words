<?php
if (isset($_SESSION['logged_in'])) {
	if ($_SESSION['logged_in']) {
		if ($_SESSION['role'] === 'admin') {
			header("Location: adminPages/adminProfilePage.php");
		}
		else {
			header("Location: profilePage.php");
		}
		exit;
	}
}