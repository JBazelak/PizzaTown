<?php

require_once __DIR__ . "/../baza.php";
try {
    $sql = 'SELECT * FROM pizzas';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Błąd bazy danych: ' . $e->getMessage());
}
