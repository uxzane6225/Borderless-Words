<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    $_SESSION['notice'] = "You do not have the formal permission to execute this processor!";
    header("Location: ../pages/clientTranslatorsPage.php");
    exit();
}

if (isset($_GET['visitProfile'])) {
    $aid = $_GET['visitProfile'];

    try {
        if (empty($_GET['visitProfile'])) {
            header("Location: ../pages/clientTranslatorsPage.php");
            exit();
        }

        $stmt = $pdo->prepare("SELECT p.displayName AS 'display', p.description AS 'description', p.pfp AS 'path', fl.language AS 'flang', sl.language AS 'slang' FROM profile p INNER JOIN translatorsFirstLanguage tfl ON p.aid = tfl.aid INNER JOIN translatorsSecondLanguage tsl ON p.aid = tsl.aid INNER JOIN languages fl ON fl.lid = tfl.lid INNER JOIN languages sl ON sl.lid = tsl.lid WHERE p.aid = :aid");
        $stmt->bindParam(":aid", $aid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['taid'] = $aid;
        $_SESSION['tdisplayName'] = $result['display'];
        $_SESSION['tdescription'] = $result['description'];
        $_SESSION['path'] = $result['path'];
        $_SESSION['flang'] = $result['flang'];
        $_SESSION['slang'] = $result['slang'];

        header("Location: ../pages/viewTranslatorPage.php");
        exit();
    }
    catch (PDOException $e) {
        $_SESSION['notice'] = $e->getMessage();
        header("Location: ../pages/clientTranslatorsPage.php");
        exit();
    }
}