<?php
require("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "uh oh";
    $_SESSI0N['notice'] = "No permission.";
    header("Location: ../pages/clientPages/hiringPage.php");
    exit();
}

if (isset($_POST['hire'])) {
    $taid = $_SESSION['taid'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startDate = date("Y-m-d", strtotime($_POST['startDate']));
    $endDate = date("Y-m-d", strtotime($_POST['endDate']));
    $paymentMethod = $_POST['paymentMethod'];
    $pin = $_POST['pin']; // same goes here.

    if (empty($title) || empty($description) || empty($startDate) || empty($endDate) || empty($paymentMethod) || empty($pin)) {
        echo"empty";
        $_SESSION['notice'] = "Complete all fields!";
        header("Location: ../pages/clientPages/hiringPage.php");
        exit();
    }
    try {
        $stmt = $pdo->prepare("INSERT INTO job (title, description, pay_method, startDate, endDate, ciid, tiid) VALUES (:title, :description, :pay_method, :startDate, :endDate, :ciid, :tiid)");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":pay_method", $paymentMethod);
        $stmt->bindParam(":startDate", $startDate);
        $stmt->bindParam(":endDate", $endDate);
        $stmt->bindParam(":ciid", $_SESSION['aid']);
        $stmt->bindParam(":tiid", $taid);
        $stmt->execute();
        header("Location: ../pages/clientPages/hiredPage.php");
        exit();
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Locatin: ../pages/viewTranslatorPage.php");
    }
}

if (isset($_POST['cancel'])) {
    header("Location: ../pages/viewTranslatorPage.php");
    exit;
}