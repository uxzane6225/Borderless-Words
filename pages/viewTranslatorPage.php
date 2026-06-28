<?php
require("../processors/config.php");
session_start();

if (!$_SESSION['logged_in']) {
    header("Location: loginPage.php");
    exit;
}

if (isset($_POST["hireBtn"])) {
    header("Location: clientPages/hiringPage.php");
    exit;
}

if (isset($_POST['msgBtn'])) {
    $_SESSION['taid'] = $_POST['msgBtn'];
    header("Location: messagePage.php");
    exit;
}

$job = $pdo->prepare("SELECT * FROM job j INNER JOIN accounts a ON a.aid = j.ciid WHERE tiid = ?");
$job->execute([$_SESSION['taid']]); 
$dajobs = $job->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewing <?= htmlspecialchars($_SESSION['tdisplayName']) ?>'s Profile | Borderless Words</title>
    <link rel="stylesheet" href="../../resources/styles/main.css">
    <link rel="icon" href="../../resources/images/logo.png">
</head>
<body style="height: 100vh;">
    <?php include("navbar.php"); ?>
    <main id="viewProfilePage"  class="mainPagesBody" style="height: 90%">
		<div class="profileCard">
			<?php echo"<img src='../{$_SESSION['path']}' id='profilePic'>"?>
			<div class="profileContent">
				<h1><?= htmlspecialchars($_SESSION['tdisplayName']) ?></h1>
				<p><?= isset($_SESSION['tdescription']) ? htmlspecialchars($_SESSION['tdescription']) : "No description yet.." ?></p>
                <div class="viewControls">
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                        <button id="hireBtn" name="hireBtn" class="hireBtn" value="<?= $_SESSION['taid'] ?>">Hire</button>
                        <button id="msgBtn" href="messagePage.php" name="msgBtn" value="<?= $_SESSION['taid'] ?>">Mail</button>
                    </form>
                </div>
                
			</div>
		</div>
        <div class="history">
            <h2>History</h2>
            <div class="historyContent">
                <?php foreach($dajobs as $dajob): ?>
                    <p><?= $dajob['title'] . " - " . $dajob['description'] ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>