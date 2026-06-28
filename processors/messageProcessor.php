<?php
require('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['notice'] = "No permission";
    header("Location: ../pages/messagePage.php");
    exit;
}

if (isset($_POST['cancel'])) {
    header("Location: ../pages/mailPage.php");
    exit;
}

$reply = $_POST['submit'];
$title = $_POST['title'];
$message = $_POST['message'];

if (empty([$title, $message])) {
    $_SESSION['notice'] = "All fields are required!";
    header("Location: ../pages/messagePage.php");
    exit;
}
try {

    $stmt = $pdo->prepare("INSERT INTO mail (title, message, sender, recipient) VALUES (:title, :message, :sender, :recipient)");
    $stmt->execute([
        ":title" => $title,
        ":message" => $message,
        ":sender" => $_SESSION['aid'],
        ":recipient" => $_POST['submit'],
    ]);

    $_SESSION['notice'] = "Message sent!";
    header("Location: ../pages/messagePage.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['notice'] = $e->getMessage();
    header("Location: ../pages/messagePage.php");
    exit;
}