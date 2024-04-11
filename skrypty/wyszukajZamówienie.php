<?php
require_once("../baza.php");
try {

    $sql = 'SELECT Count(status) 
    FROM orders
    WHERE (status = "nie zrealizowano" OR status = "rezygnacja")';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $ordersCount = $stmt->fetchColumn();

    $sql2 = 'SELECT *
    FROM orders
    WHERE (status = "nie zrealizowano" OR status = "rezygnacja")';
    
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $orders = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Błąd bazy danych: ' . $e->getMessage());
}
?>