<?php
require_once('../baza.php');
session_start();
if (isset($_SESSION['isLoggedIn'])) {
    if (isset($_POST["nazwa"]) && isset($_POST['rozmiar']) && isset($_POST['cena']) && isset($_POST['odbior'])) {

        $_SESSION['nazwaPizzy'] = $_POST['nazwa'];
        $_SESSION['rozmiarPizzy'] = $_POST['rozmiar'];
        $_SESSION['odbior'] = $_POST['odbior'];
        $_SESSION['data'] = date('Y-m-d H:i:s');
        $_SESSION['address'] = 'ul.' . $_SESSION['street'] . ' | ' . $_SESSION['postalCode'] . ' | ' . $_SESSION['city'];

        $sqlOrders = 'INSERT INTO orders(userID,pizza,size,firstname,lastname,date,address,notes) VALUES (:userID,:pizza,:size,:firstname,:lastname,:date,:address,:notes)';

        $stmt = $pdo->prepare($sqlOrders);
        $stmt->bindValue(':userID', $_SESSION['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':pizza', $_SESSION['nazwaPizzy'], PDO::PARAM_STR);
        $stmt->bindValue(':size', $_SESSION['rozmiarPizzy'], PDO::PARAM_STR);
        $stmt->bindValue(':firstname', $_SESSION['first_name'], PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $_SESSION['last_name'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $_SESSION['data'], PDO::PARAM_STR);
        $stmt->bindValue(':address', $_SESSION['address'], PDO::PARAM_STR);
        $stmt->bindValue(':notes', $_SESSION['odbior'], PDO::PARAM_STR);

        $stmt->execute();
        if($_SESSION['role']== 'employee'){
            header("Location: ../widoki/employee.php");
        }
        else{

            header("Location: ../index.php");
        }

        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
} else {
    header('Location: ../widoki/login.php');
}