<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['notice'] = "No permission";
    header("Location: ../pages/adminPages/adminReplyPage.php");
    exit;
}

if (isset($_POST['cancel'])) {
    header("Location: ../pages/adminPages/adminInboxPage.php");
    exit;
}

$reply = $_POST['submit'];
$title = $_POST['title'];
$message = $_POST['message'];

if (empty([$title, $message])) {
    $_SESSION['notice'] = "All fields are required!";
    header("Location: ../pages/adminPages/adminReplyPage.php");
    exit;
}
try {
    $find = $pdo->prepare("SELECT * FROM mail WHERE mid = ?");
    $find->execute([$reply]);
    $replied = $find->fetch();

    $stmt = $pdo->prepare("INSERT INTO mail (title, message, sender, recipient, reply) VALUES (:title, :message, :sender, :recipient, :reply)");
    $stmt->execute([
        ":title" => $title,
        ":message" => $message,
        ":sender" => $_SESSION['aid'],
        ":recipient" => $replied['sender'],
        ":reply" => $reply
    ]);

    $_SESSION['notice'] = "Message sent!";
    header("Location: ../pages/adminPages/adminReplyPage.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['notice'] = $e->getMessage();
    header("Location: ../pages/adminPages/adminReplyPage.php");
    exit;
}