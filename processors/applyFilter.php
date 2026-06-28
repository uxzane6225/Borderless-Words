<?php
include("config.php");
session_start();

$showLang = $pdo->query("SELECT * FROM languages");
$showLang->execute();
$results = $showLang->fetchAll(PDO::FETCH_ASSOC);

$lang = "Danish";

$query = "SELECT a.aid AS 'ID', a.fullName AS 'Full Name', a.email AS 'Email', a.phone AS 'Phone', a.role AS 'Role', p.pfp 'Profile', p.displayName AS 'Display', p.address AS 'Address', p.description AS 'Description', lf.language AS 'FirstLang', ls.language AS 'SecondLang' FROM accounts a INNER JOIN profile p ON p.aid = a.aid INNER JOIN translatorsFirstlanguage tfl ON tfl.aid = a.aid INNER JOIN translatorsSecondlanguage tsl ON tsl.aid = a.aid INNER JOIN languages lf ON tfl.lid = lf.lid INNER JOIN languages ls ON tsl.lid = ls.lid WHERE role = 'translator'";

if (isset($lang)) {
	foreach ($results as $result) {
		if (isset($_GET["{$result['language']}"])) {
            $select = $_GET["{$result['language']}"];
			$query += " AND lf.language = '{$select}'";
			echo $query;
		}
	}
}


$stmt = $pdo->query($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);