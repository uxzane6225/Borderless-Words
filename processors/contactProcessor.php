<?php
require('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['notice'] = "No permission";
    header("Location: ../pages/contactPage.php");
    exit;
}

$title = $_POST['title'];
$message = $_POST['message'];

if (empty([$title, $message])) {
    $_SESSION['notice'] = "All fields are required!";
    header("Location: ../pages/contactPage.php");
    exit;
}
try {
    $stmt = $pdo->prepare("INSERT INTO mail (title, message, sender) VALUES (:title, :message, :sender)");
    $stmt->execute([
        ":title" => $title,
        ":message" => $message,
        ":sender" => $_SESSION['aid']
    ]);

    $_SESSION['notice'] = "Message sent!";
    header("Location: ../pages/contactPage.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['notice'] = $e->getMessage();
    header("Location: ../pages/contactPage.php");
    exit;
}