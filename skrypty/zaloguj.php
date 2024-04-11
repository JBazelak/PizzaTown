<?php
session_start();



if ((isset($_SESSION['isLoggedIn'])) && ($_SESSION['isLoggedIn'] == true)) {
    
    if($_SESSION['role'] == 'customer'){

        header("Location: ../index.php");
    }

    elseif($_SESSION['role'] == 'admin'){
        header("Location: ../widoki/admin.php");
    }
    else{
        header("Location: ../widoki/employee.php");
    }

    exit();
}





if (empty($_POST['login']) || empty($_POST['haslo'])) {
    $_SESSION['error'] = '<span style="color: red">Nieprawidłowe dane logowania!</span>';
    header('Location: ../widoki/login.php');
    exit();
}


require_once "../baza.php";

$login = trim($_POST['login']);
$haslo = $_POST['haslo'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");

$sql_users = "SELECT * FROM users JOIN customers ON users.ID = customers.ID WHERE users.username = ?";
$stmt = $pdo->prepare($sql_users);
$stmt->execute([$login]);
$_users = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_users) {
    if (password_verify($haslo, $_users['pass'])) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $_users['username'];
        $_SESSION['role'] = $_users['rol'];
        $_SESSION['user_id'] = $_users['ID'];
        $_SESSION['first_name'] = $_users['first_name'];
        $_SESSION['last_name'] = $_users['last_name'];
        $_SESSION['email'] = $_users['email'];
        $_SESSION['city'] = $_users['city'];
        $_SESSION['street'] = $_users['street'];
        $_SESSION['postalCode'] = $_users['postalCode'];

        if ($_SESSION['role'] == 'admin') {
            header('Location: ../widoki/admin.php');
            exit();
        }
        if ($_SESSION['role'] == 'customer') {
            header('Location: ../index.php');
            exit();
        }
        if ($_SESSION['role'] == 'employee') {
            header('Location: ../widoki/employee.php');
            exit();
        }
    } else {
        header('Location:../widoki/login.php');
        $_SESSION['error'] = '<span style="color: red">Nieprawidłowe hasło!</span>';
    }
} else {
    $_SESSION['error'] = '<span style="color: red">Nieprawidłowy login!</span>';
    header('Location:../widoki/login.php');
}

exit();
?>