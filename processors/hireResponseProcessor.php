<?php
require('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['notice'] = "No permission";
    header('Location: ../pages/profilePage.php');
    exit;
}

if (isset($_POST['accept'])) {
    try {
        $stmt = $pdo->prepare("UPDATE job SET request = 'accepted' WHERE jid = ?");
        $stmt->execute([$_POST['accept']]);
        header('Location: ../pages/profilePage.php');
    }
    catch (PDOException $e) {
        $_SESION['notice'] = $e->getMessage();
        header('Location: ../pages/profilePage.php');
        exit;
    }
}

if (isset($_POST['reject'])) {
    try {
        $stmt = $pdo->prepare("UPDATE job SET request = 'rejected' WHERE jid = ?");
        $stmt->execute([$_POST['reject']]);
        header('Location: ../pages/profilePage.php');
    }
    catch (PDOException $e) {
        $_SESION['notice'] = $e->getMessage();
        header('Location: ../pages/profilePage.php');
        exit;
    }
}
