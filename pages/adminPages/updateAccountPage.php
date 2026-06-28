<?php
require("../../processors/config.php");
session_start();
require('adminAuthorized.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User | Borderless Words</title>
    <link rel="stylesheet" href="../../resources/styles/crud.css">
    <link rel="icon" href="../../resources/images/logo.png">
</head>
<body class="crudBody">
    <header class="crudHeader">
        <h1>Viewing <?= $_SESSION['currFN']; ?></h1>
        <?php if(isset($_SESSION['notice'])):?>
            <p><?= $_SESSION['notice'] ?></p>
            <?php unset($_SESSION['notice']) ?>
        <?php endif; ?>
    </header>
    <main class="crudMain">
        <div class="crudForm" >
            <div class="crudDiv">
                <label for="fullName" class="labelCrud">Full Name</label>
                <input type="text" id="fullName" name="fullName" class="inputCrud" value="<?= htmlspecialchars($_SESSION['currFN']) ?>" placeholder="Example: John Doe" form="confirmForm" autocomplete="off">
            </div>
            <div class="crudDiv">
                <label for="email" class="labelCrud">Email</label>
                <input type="email" id="email" name="email" class="inputCrud" value="<?= htmlspecialchars($_SESSION['currEmail']) ?>" placeholder="Example: johndoe@example.com" form="confirmForm" autocomplete="off">
            </div>
            <div class="crudDiv">
                <label for="phone" class="labelCrud">Phone</label>
                <input type="text" id="phone" name="phone" class="inputCrud" value="<?= htmlspecialchars($_SESSION['currPhone']) ?>" placeholder="Example: 1234567890" form="confirmForm" autocomplete="off">
            </div>
            <div class="crudDiv">
                <label for="password" class="labelCrud">Password</label>
                <input type="password" id="password" name="password" class="inputCrud" placeholder="Example: n07505u5p!c!0us" form="confirmForm" autocomplete="on">
            </div>
            <div id="crudBtnsDiv" class="crudDiv">
                <button id="updateBtn" name="updateBtn" class="crudBtn">Update</button>
                <button id="deleteBtn" name="deleteBtn" class="crudBtn">Delete</button>
                <a href="adminUserStatsPage.php" id="cancelBtn" name="cancelBtn" class="crudBtn">Cancel</a>
            </div>
        </div>
    </main>
    <form id="confirmForm" class="popup" action="../../processors/updateProcessor.php" method="POST">
        <div id="updateConfirm" class="popupcontent">
            <h2 class="popupHeader">Update User?</h2>
            <div class="popupbuttons">
                <button id="cnfrmUpdate" name="cnfrmUpdate" class="crudBtn">Update</button>
                <button id="closeBtn" name="crudBtn" class="crudBtn">Close</button>
            </div>
        </div>
        <div id="deleteConfirm" class="popupcontent">
            <h2 class="popupHeader">Delete User?</h2>
            <div class="popupbuttons">
                <button id="cnfrmDelete" name="cnfrmDelete" class="crudBtn">Delete</button>
                <button id="closeBtn" name="crudBtn" class="crudBtn">Close</button>
            </div>
        </div>
    </form>
    <footer class="crudFooter">
        <p>&copy; Borderless Words. Rights Reserved 2026.</p>
    </footer>
    <script src="../../scripts/updateAccountScript.js"></script>
</body>
</html>