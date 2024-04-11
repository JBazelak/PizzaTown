<?php




echo '<h3><span class="name">' . "Wartość i ilość pizzy sprzedanej w dniu" . '</span></h3>';

require_once("../baza.php");

try {

    if (isset($_POST['search_day']) && !empty($_POST['search_day'])) {
        $search_day = htmlspecialchars($_POST['search_day']);
        $sql = 'SELECT DATE(date) AS day, COUNT(*) AS pizza_count, ROUND(SUM(price), 2) AS total_value
                    FROM orders o
                    JOIN pizzas p ON o.pizza = p.name
                    WHERE DATE(date) = :search_day
                    GROUP BY day';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':search_day', $search_day, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            echo "Nic nie sprzedano :c";
        } else {
            foreach ($result as $row) {
                $total_value_formatted = number_format($row['total_value'], 2);
                echo "Dzień: {$row['day']}, Ilość sprzedanych pizz: {$row['pizza_count']}, Wartość: {$total_value_formatted} zł<br>";
            }
        }
    } else {
        require_once('../skrypty/ileDzien.php');
    }

} catch (PDOException $e) {
    echo 'Błąd bazy danych: ' . $e->getMessage();
}