<?php
function goBack($location, $notice) {
	$_SESSION['notice'] = $notice;
	header("Location: " . $location);
	exit();
}