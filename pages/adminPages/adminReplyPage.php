<?php
session_start();

if (!$_SESSION['logged_in']) {
	header("location: ../pages/loginPage.php");
	exit();
}
require('adminAuthorized.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Borderless Words</title>
    <link rel="stylesheet" href="../../resources/styles/main.css">
	<link rel="icon" href="../../resources/images/logo.png">
</head>
<body>
    <main id="contactPage" class="mainPagesBody">
        <div class="contactContent">
            <h1>Reply</h1>
            <form action="../../processors/adminReplyProcessor.php" method="POST" class="contactForm">
                <div class="contactInputs">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Title">
                </div>
                <div class="contactInputs">
                    <label for="message">Message</label>
                    <textarea type="text" id="message" name="message" placeholder="Message"></textarea>
                </div>
                <button name="submit" id="submitContact" value="<?= $_SESSION['mid'] ?>">Submit</button>
                <button name="cancel" id="cancelContact">Cancel</button>

                <?php if(isset($_SESSION['notice'])): ?>
                    <p class="notice"><?= $_SESSION['notice']; ?></p>
                    <?php unset($_SESSION['notice']); ?>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>
</html>