<?php
session_start();
require_once "../baza.php";

$id = $_SESSION['user_id'];


//Edycja danych

try {

    $pdo->beginTransaction();

    //Edycja Imienia

    if (isset ($_POST['newFirstName']) && !empty($_POST['newFirstName'])) {

        $_SESSION['first_name'] = $_POST['newFirstName'];

        $query = "UPDATE customers
        SET first_name= :new_name
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_name', $_POST['newFirstName'], PDO::PARAM_STR);
        $stmt->execute();

        $query = "UPDATE orders 
          SET firstname = :newFirstName 
          WHERE userID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newFirstName', $_POST['newFirstName']);
        $stmt->execute();
    }

    //Edycja Nazwiska

    if (isset ($_POST['newLastName'])  && !empty($_POST['newLastName'])) {

        $_SESSION['last_name'] = $_POST['newLastName'];

        $query = "UPDATE customers
        SET last_name= :new_last_name
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_last_name', $_POST['newLastName'], PDO::PARAM_STR);
        $stmt->execute();

        $query = "UPDATE orders 
        SET lastname = :newLastName 
        WHERE userID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newLastName', $_POST['newLastName']);
        $stmt->execute();
    }

    //Edycja maila

    if (isset ($_POST['newMail'])  && !empty($_POST['newMail'])) {

        $_SESSION['email'] = $_POST['newMail'];

        $query = "UPDATE customers
        SET email= :new_mail
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_mail', $_POST['newMail'], PDO::PARAM_STR);
        $stmt->execute();
    }

    //Edycja ulicy

    if (isset ($_POST['newStreet'])  && !empty($_POST['newStreet'])) {

        $_SESSION['street'] = $_POST['newStreet'];

        $query = "UPDATE customers
        SET street= :new_street
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_street', $_POST['newStreet'], PDO::PARAM_STR);
        $stmt->execute();
    }

    //Edycja kody pocztowego

    if (isset ($_POST['newCode'])  && !empty($_POST['newCode'])) {

        $_SESSION['postalCode'] = $_POST['newCode'];

        $query = "UPDATE customers
        SET postalCode= :new_code
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_code', $_POST['newCode'], PDO::PARAM_STR);
        $stmt->execute();
    }

    //edycja miasta

    if (isset ($_POST['newCity'])  && !empty($_POST['newCity'])) {

        $_SESSION['city'] = $_POST['newCity'];

        $query = "UPDATE customers
        SET city= :new_city
        WHERE ID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':new_city', $_POST['newCity'], PDO::PARAM_STR);
        $stmt->execute();
    }

    //edycja adresu

    if ((isset ($_POST['newStreet'])  && !empty($_POST['newStreet'])) || 
        (isset ($_POST['newCode'])  && !empty($_POST['newCode'])) || 
        (isset ($_POST['newCity'])  && !empty($_POST['newCity']))) {

        $_SESSION['address'] = 'ul.' . $_SESSION['street'] . ' | ' . $_SESSION['postalCode'] . ' | ' . $_SESSION['city'];


        $query = "UPDATE orders
        SET address= :newAddress
        WHERE userID = $id";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':newAddress', $_SESSION['address'], PDO::PARAM_STR);
        $stmt->execute();
    }



    $pdo->commit();
    header('Location: ../widoki/profile.php');




} catch (Exception $e) {
    $pdo->rollback();
    die ('Błąd bazy danych: ' . $e->getMessage());
}







