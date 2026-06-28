<?php
require "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['notice'] = "You do not have the formal permission to access this processor!";
    header("Location: ../pages/adminPages/adminDashboaordPage.php");
    exit;
}

if (isset($_POST['viewBtn'])) {
    $aid = $_POST['viewBtn'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE aid = :aid");
        $stmt->bindParam(":aid", $aid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            header("Location: updateAccount.php");
            exit;
        }
        
        $_SESSION['targetID'] = $result['aid'];
        $_SESSION['currFN'] = $result['fullName'];
        $_SESSION['currEmail'] = $result['email'];
        $_SESSION['currPhone'] = $result['phone'];


        header("Location: ../pages/adminPages/updateAccountPage.php");
        exit;
    }
    catch (PDOexception $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: ../pages/adminPages/adminListPage.php");
        exit;
    }
}