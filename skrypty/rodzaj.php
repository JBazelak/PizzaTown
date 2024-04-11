<?php

require_once("../baza.php");

try {
    $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS month, pizza, COUNT(*) AS pizza_count
            FROM orders
            GROUP BY month, pizza
            ORDER BY pizza_count DESC
            LIMIT 1';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    echo $result["month"] . ' : ' . $result["pizza"] . ' (ilość:' . $result["pizza_count"] . ')';


} catch (PDOException $e) {
    echo 'Błąd bazy danych: ' . $e->getMessage();
}
?>