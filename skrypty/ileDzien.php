<?php

require_once("../baza.php");
try {

    $sql = 'SELECT DATE(date) AS day, COUNT(*) AS pizza_count, ROUND(SUM(price), 2) AS total_value
            FROM orders o
            JOIN pizzas p ON o.pizza = p.name
            GROUP BY day';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($result as $row) {
        $total_value_formatted = number_format($row['total_value'], 2);
        echo "Dzień: {$row['day']}, Ilość sprzedanych pizz: {$row['pizza_count']}, Wartość: {$total_value_formatted} zł<br>";
    }
} catch (PDOException $e) {
    echo 'Błąd bazy danych: ' . $e->getMessage();
}
?>