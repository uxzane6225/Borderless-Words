<?php
require('../processors/config.php');
session_start();

if (($_SESSION['role'] !== 'client' && $_SESSION['role'] !== 'admin') || !$_SESSION['logged_in']) {
	header('Location: makeProfilePage.php');
	exit;
}

$showLang = $pdo->query("SELECT * FROM languages ORDER BY language ASC");
$showLang->execute();
$results = $showLang->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT a.aid AS 'ID', a.fullName AS 'Full Name', a.email AS 'Email', a.phone AS 'Phone', a.role AS 'Role', p.pfp 'Profile', p.displayName AS 'Display', p.address AS 'Address', p.description AS 'Description', lf.language AS 'FirstLang', ls.language AS 'SecondLang' FROM accounts a INNER JOIN profile p ON p.aid = a.aid INNER JOIN translatorsFirstLanguage tfl ON tfl.aid = a.aid INNER JOIN translatorsSecondLanguage tsl ON tsl.aid = a.aid INNER JOIN languages lf ON tfl.lid = lf.lid INNER JOIN languages ls ON tsl.lid = ls.lid WHERE role = 'translator'";
if (isset($_GET['filterBtn'])) {
	if (isset($_GET['firstLanguage'])) {
		foreach ($results as $result) {
			$select = $_GET["firstLanguage"];
			if ($_GET['firstLanguage'] === $select) {	
				$query .= " AND lf.lid = '{$select}'";
				break;
			}
		}
	}
	if (isset($_GET['secondLanguage'])) {
		foreach ($results as $result) {
			$select = $_GET["secondLanguage"];
			if ($_GET['secondLanguage'] === $select) {	
				$query .= " AND ls.lid = '{$select}'";
				break;
			}
		}
	}
}

if (isset($_GET['clearBtn'])) {
	header("Location: clientTranslatorsPage.php");
}

$stmt = $pdo->query($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Translators | Borderless Words</title>
	<link rel="stylesheet" href="../resources/styles/main.css">
	<link rel="icon" href="../resources/images/logo.png">
</head>
<body>
	<?php include("navbar.php") ?>
	<main id="translatorsPage" class="mainPagesBody">
		<form class="filters" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
			<h2>Filters</h2>
			<div class="filterBtns">
				<button class="fltrBtn" name="filterBtn">Apply Filter</button>
				<button class="fltrBtn" name="clearBtn">Clear Filter</button>
			</div>
			
			<div id="languages" class="categories">
				<h3>First Languages</h3>
				<?php foreach($results as $result): ?>
					<label><input type="radio" class="checkBox" name="firstLanguage" value="<?= $result['lid'] ?>"><?= htmlspecialchars($result['language']) ?></label>
				<?php endforeach; ?>
			</div>
			<div id="languages" class="categories">
				<h3>Second Languages</h3>
				<?php foreach($results as $result): ?>
					<label><input type="radio" class="checkBox" name="secondLanguage" value="<?= $result['lid'] ?>"><?= htmlspecialchars($result['language']) ?></label>
				<?php endforeach; ?>
			</div>
			<!-- <div id="work" class="categories">
				<h3>Work Style</h3>
				<label><input type="checkbox" class="checkBox"> On-site</label>
				<label><input type="checkbox" class="checkBox"> Remote</label>
				<label><input type="checkbox" class="checkBox"> Hybrid</label>
			</div> -->
		</form>
		<section id="translatorsList">
			<?php if(isset($rows)):?>
                <?php foreach($rows as $row): ?>
                    <article class="translatorArticle">
						<img src='<?= isset($row['Profile']) ? $row['Profile'] : "blankPfp.jpg"?>' id='profilePic'>
                        <div class="translatorContent">
                            <div class="translatorDescription">
                                <form class="translatorButton" action="../processors/visitProfileProcessor.php" method="GET">
                                    <button name="visitProfile" class="translatorBtn" value="<?= $row['ID'] ?>"><h2><?= $row['Display'] ?></h2></button>
                                </form>
                                <p><?= $row['Description'] ?></p>
                            </div>
                            <div class="translatorBottom">
                                <!-- <p>Rating 5.0</p> -->
                                <div class="languages">
                                    <p class="language"><?= $row['FirstLang'] ?></p>
                                    <p class="language"><?= $row['SecondLang'] ?></p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
		</section>
	</main>
</body>
</html>