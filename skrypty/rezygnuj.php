<?php
session_start();
require_once('../baza.php');

if (isset($_POST['idValue'])) {


    try {
        $sql = 'UPDATE orders
        SET status = "rezygnacja"
        WHERE ID = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', intval($_POST['idValue']), PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ../widoki/profile.php');
        exit();
    } catch (Exception $e) {
        die('Błąd bazy danych: ' . $e->getMessage());
    }
} else {
    header('Location: ../index.php');
    exit();
}