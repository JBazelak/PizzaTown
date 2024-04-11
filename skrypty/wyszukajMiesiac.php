<?php

echo '<h3><span class="name">' . "Wartość i ilość pizzy sprzedanej w miesiącu" . '</span></h3>';
require_once("../baza.php");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['search_month'])) {
            $search_month = htmlspecialchars($_POST['search_month']);
            // Zapytanie SQL z warunkiem wyszukiwania konkretnego miesiąca
            $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS month, COUNT(*) AS pizza_count, SUM(price) AS total_value
                    FROM orders o
                    JOIN pizzas p ON o.pizza = p.name
                    WHERE DATE_FORMAT(date, "%Y-%m") = :search_month
                    GROUP BY month';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search_month', $search_month, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Jeśli nie podano daty, zapytanie będzie zwracać wszystkie miesiące
            $sql = 'SELECT DATE_FORMAT(date, "%Y-%m") AS month, COUNT(*) AS pizza_count, SUM(price) AS total_value
                    FROM orders o
                    JOIN pizzas p ON o.pizza = p.name
                    GROUP BY month';

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($result)) {
            echo "Nic nie sprzedano :c";
        } else {
            foreach ($result as $row) {
                $total_value_formatted = number_format($row['total_value'], 2);
                echo "Miesiąc: {$row['month']}, Ilość sprzedanych pizz: {$row['pizza_count']}, Wartość: {$total_value_formatted} zł<br>";
            }
        }
    } else {
        require_once('../skrypty/ileMsc.php');
    }
} catch (PDOException $e) {
    echo 'Błąd bazy danych: ' . $e->getMessage();
}
