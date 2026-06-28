<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['notice'] = "You do not have the formal permission to access this processor!";
    header("Location: ../pages/adminPages/updateAccount.php");
    exit();
}

if (isset($_POST['cnfrmUpdate'])) {
    $targetID = $_SESSION['targetID'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    unset($_SESSION['targetID']);
    unset($_SESSION['currFN']);

    if (empty($fullName) || empty($email) || empty($phone)) {
        $_SESSION['notice'] = "Fill all fields, don't leave blanks!";
        header("Location: ../pages/adminPages/updateAccountPage.php");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        if (empty($password)) {
            $stmt = $pdo->prepare("UPDATE accounts SET fullName = :fullName, email = :email, phone = :phone WHERE aid = :aid");
        }
        else {
            $stmt = $pdo->prepare("UPDATE accounts SET fullName = :fullName, email = :email, phone = :phone, password = :password WHERE aid = :aid");
            $stmt->bindParam(":password", $hashedPassword);
        }
        $stmt->bindParam(":aid", $targetID);
        $stmt->bindParam(":fullName", $fullName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->execute();
        
        unset($_SESSION['targetID']);
        header("Location: ../pages/adminPages/adminUserStatsPage.php");
        exit();
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: ../pages/adminPages/adminUserStatsPage.php");
        exit();
    }
}

if (isset($_POST['cnfrmDelete'])) {
    $targetID = $_SESSION['targetID'];
    unset($_SESSION['targetID']);
    unset($_SESSION['currFN']);
    try {
        $stmt = $pdo->prepare("DELETE FROM accounts WHERE aid = :aid");
        $stmt->bindParam(":aid", $targetID);
        $stmt->execute();
        $_SESSION['notice'] = "Account has been deleted!";
        header("Location: ../pages/adminPages/adminUserStatsPage.php");
        exit();
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: ../pages/adminPages/adminUserStatsPage.php");
        exit();
    }
}

if (isset($_POST['cancelBtn'])) {
    header("Location: ../pages/adminPages/adminUserStatsPage.php");
    exit();
}