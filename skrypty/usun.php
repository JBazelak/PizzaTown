<?php
    require_once("../baza.php");

    $sql = 'DELETE 
    FROM orders
    WHERE (ID like :id)';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', intval($_POST['idValue']), PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../widoki/employee.php');