<?php

require_once("../baza.php"); 

try {
        $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS month, COUNT(*) AS pizza_count, SUM(price) AS total_value
            FROM orders o
            JOIN pizzas p ON o.pizza = p.name
            GROUP BY month';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        echo "Miesiąc: {$row['month']}, Ilość sprzedanych pizz: {$row['pizza_count']}, Wartość: {$row['total_value']} zł<br>";
    }
} catch (PDOException $e) {
    echo 'Błąd bazy danych: ' . $e->getMessage();
}

