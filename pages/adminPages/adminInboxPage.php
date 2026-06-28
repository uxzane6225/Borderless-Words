<?php
require('../../processors/config.php');
session_start();
require('adminAuthorized.php');

$stmt = $pdo->query("SELECT m.mid, m.title, m.message, said.fullname AS sender, raid.fullname AS recipient, m.sender AS sid, m.recipient AS rid, m.reply AS reply FROM mail m INNER JOIN accounts said ON said.aid = m.sender LEFT JOIN accounts raid ON raid.aid = m.recipient LEFT JOIN mail r ON r.reply = m.reply WHERE raid.role = 'admin' OR said.role = 'admin' OR m.recipient IS NULL ORDER BY m.sentDateTime DESC");
$stmt->execute();
$mails = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['reply'])) {
    $_SESSION['mid'] = $_GET['reply'];
    header("Location: adminReplyPage.php?id={$_GET['reply']}");
    exit;
}

if (isset($_GET['delete'])) {
    try {
        $delete = $pdo->prepare("DELETE FROM mail WHERE mid = ?");
        $delete->execute([$_GET['delete']]);

        $_SESSION['notice'] = "Mail deleted";
        header("Location: adminInboxPage.php");
        exit;
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: adminInboxPage.php");
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox | Borderless Words</title>
	<link rel="stylesheet" href="../../resources/styles/admin.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
    <?php include("adminNavbar.php") ?>
    <main class="inboxMain">
        <header class="inboxHeader">
            <h2 class="headerTitle">Inbox</h2>
            <?php if(isset($_SESSION['notice'])): ?>
                <p class="notice"><?= $_SESSION['notice'] ?></p>
                <?php unset($_SESSION['notice']) ?>
            <?php endif; ?>
        </header>
        <div class="mailContents">
            <?php foreach($mails as $mail): ?>
                <article class="mail">
                    <div class="mailContent">
                        <h3 class="mailtitle"><?= htmlspecialchars($mail['title']); ?></h3>
                        <p class="mailMessage"><?= htmlspecialchars($mail['message']); ?></p>
                        <div class="mailInvolved">
                            <p class="senderName">
                                From:
                                <?php if($mail['sid'] == $_SESSION['aid']): ?> 
                                    <b><?= htmlspecialchars($mail['sender']); ?></b>
                                <?php else: ?>
                                    <?= htmlspecialchars($mail['sender']); ?>
                                <?php endif; ?>
                            </p>
                            <?php if(isset($mail['recipient'])): ?>
                                <p class="recipientName">
                                    To: 
                                     <?php if($mail['rid'] == $_SESSION['aid']): ?> 
                                    <b><?= htmlspecialchars($mail['recipient']); ?></b>
                                    <?php else: ?>
                                        <?= htmlspecialchars($mail['recipient']); ?>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="mailCrud">
                        <?php if($mail['sid'] != $_SESSION['aid']): ?>
                            <button id="reply" name="reply" class="mailBtn" value="<?= $mail['mid'] ?>">Reply</button>
                        
                        <?php endif; ?>
                        <button id="delete" name="delete" class="mailBtn" value="<?= $mail['mid'] ?>">Delete</button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>