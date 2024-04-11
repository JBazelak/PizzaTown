<?php
require_once("../baza.php");
try {

$sql = 'SELECT Count(status) 
FROM orders
WHERE firstname = :firstname 
AND status = "nie zrealizowano"';
   
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':firstname', $_SESSION['first_name'], PDO::PARAM_STR);
$stmt->execute();
$ordersCount = $stmt->fetchColumn();


$sql2 = 'SELECT * 
FROM orders
WHERE firstname = :firstname 
AND status = "nie zrealizowano"';
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':firstname', $_SESSION['first_name'], PDO::PARAM_STR);
$stmt2->execute();
$orders = $stmt2->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOException $e) {
    die('Błąd bazy danych: ' . $e->getMessage());
}
?>