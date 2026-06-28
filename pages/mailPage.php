<?php 
require('../processors/config.php');
session_start();

if (!$_SESSION['logged_in']) {
    header("location: ../pages/loginPage.php");
    exit();
}

$stmt = $pdo->prepare("SELECT m.mid, m.title, m.message, m.sender AS said, m.recipient AS raid, sid.fullname AS sender, rid.fullname AS recipient, m.reply, m.sentDateTime FROM mail m INNER JOIN accounts sid ON sid.aid = m.sender LEFT JOIN accounts rid ON rid.aid = m.recipient WHERE m.sender = ? OR m.recipient = ? ORDER BY m.sentDatetime DESC");
$stmt->execute([$_SESSION['aid'], $_SESSION['aid']]);
$mails = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['reply'])) {
    $_SESSION['mid'] = $_GET['reply'];
    header("Location: replyPage.php?aid={$_SESSION['mid']}");
    exit;
}


if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM mail WHERE mid = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/main.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
    <?php include('navbar.php') ?>
    <main class="mailPageMain">
        <header class="mailPageHeader">
            <h1>Mail</h1>
            <?php if(isset($_SESSION['notice'])): ?>
                <p class="notice"><?= $_SESSION['notice'] ?></p>
                <?php unset($_SESSION['notice']); ?>
            <?php endif; ?>
        </header>
        <section class="mails">
            <?php foreach($mails as $mail): ?>
                <article class="mail">
                    <div class="mailContents">
                        <div class="mailHeader">
                            <h2 class="mailHeading"><?= $mail['title'] ?></h2>
                            <p>Sent: <?= $mail['sentDateTime'] ?></p>
                        </div>
                        <p class="mailBody"><?= $mail['message'] ?></p>
                        <div class="mailDetail">
                            <p>
                                From: 
                                <?php if($mail['said'] == $_SESSION['aid']): ?>
                                       <b><?= $mail['sender'] ?></b> 
                                    <?php else: ?>
                                        <?= $mail['sender'] ?>
                                    <?php endif; ?>
                            </p>
                            <?php if(!empty($mail['recipient'])): ?>
                                <p>
                                    To: 
                                    <?php if($mail['raid'] == $_SESSION['aid']): ?>
                                       <b><?= $mail['recipient'] ?></b> 
                                    <?php else: ?>
                                        <?= $mail['recipient'] ?>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <form class="mailControl" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
                        <?php if($mail['said'] != $_SESSION['aid']): ?> 
                            <button id="replyBtn" name="reply" class="mailBtn" value="<?= $mail['mid'] ?>">Reply</button>
                        <?php endif; ?>
                        <button id="deleteBtn" name="delete" class="mailBtn" value="<?= $mail['mid'] ?>">Delete</button>
                    </form>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>