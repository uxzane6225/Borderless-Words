<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['settingsNotice'] = "You do not have the formal permission to access this processor!";
    header("Location: ../pages/profilePage.php");
    exit();
}

$targetID = $_SESSION['aid'];
$fullName = $_POST['newName'];
$email = $_POST['newEmail'];
$phone = $_POST['newPhone'];
$password = $_POST['newPass'];

if (empty($fullName) || empty($email) || empty($phone)) {
    $_SESSION['settingsNotice'] = "Fill all fields, don't leave blanks!";
    header("Location: ../pages/profilePage.php");
    exit;
}

$_SESSION['oldName'] = $fullName;
$_SESSION['oldEmail'] = $email;
$_SESSION['oldPhone'] = $phone;

try {
    if (empty($password)) {
        $stmt = $pdo->prepare("UPDATE accounts SET fullName = :fullName, email = :email, phone = :phone WHERE aid = :aid");
    }
    else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE accounts SET fullName = :fullName, email = :email, phone = :phone, password = :password WHERE aid = :aid");
        $stmt->bindParam(":password", $hashedPassword);
    }
    $stmt->bindParam(":aid", $targetID);
    $stmt->bindParam(":fullName", $fullName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();
    
    unset($_SESSION['oldName']);
    unset($_SESSION['oldEmail']);
    unset($_SESSION['oldPhone']);

    $_SESSION['settingsNotice'] = "Account Updated!";
    header("Location: ../pages/profilePage.php");
    exit();
}
catch (PDOException $e) {
    $_SESSION['settingsNotice'] = $e->getMessage();
    header("Location: ../pages/ProfilePage.php");
    exit();
}