<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['notice'] = "You do not have the formal permission to access this processor!";
    header("Location: ../pages/adminPages/createAdminPage.php");
    exit;
}

if (isset($_POST['confirmBtn'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = 'admin';

    if (empty($fullName) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['notice'] = "Fill all fields, don't leave blanks!";
        header("Location: ../pages/adminPages/createAdminPage.php");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO accounts (fullname, email, phone, password, role) VALUES (:fullname, :email, :phone, :password, :role)");
        $stmt->bindParam(":fullName", $fullName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);
        $stmt->execute();

        $_SESSION['notice'] = "Admin has been created!";
        header("Location: ../pages/adminPages/createAdminPage.php");
        exit;
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: ../pages/adminPages/createAdminPage.php");
        exit;
    }
}

if (isset($_POST['cancelBtn'])) {
    header("Location: ../pages/adminPages/adminDashboardPage.php");
    exit;
}