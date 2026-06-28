<?php
require('processors/config.php');
if ($pdo) {
	header("location: pages/loginPage.php");
}
else {
	header("location: pages/errorPage.php");
}