<?php
session_start();


// Sprawdzamy, czy dane POST zostały przesłane
if (isset($_POST['username'], $_POST['password'], $_POST['passwordRepeat'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['city'], $_POST['street'], $_POST['postalCode'])) {

    //zakładam, że walidacja powiodła się
    $isValid = true;

    // Pobieramy dane z formularza


    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $city = $_POST['city'];
    $street = $_POST['street'];
    $postalCode = $_POST['postalCode'];

    //sprawdzamy poprawność nazwy uży  tkownika
    $username = $_POST['username'];
    if ((strlen($username) < 3) || (strlen($username) > 20)) {
        $isValid = false;
        $_SESSION['err_username'] = "Nazwa użytkownika powinna posiadać od 3 do 20 znaków!";
    }
    if (ctype_alnum($username) == false) {
        $isValid = false;
        $_SESSION['err_username'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
    }

    //sprawdzamy poprawność maila
    $email = $_POST['email'];
    $emailSanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
    if ((filter_var($emailSanitized, FILTER_VALIDATE_EMAIL) == false) || ($emailSanitized != $email)) {
        $isValid = false;
        $_SESSION['err_email'] = "Podaj poprawny adres e-mail";
    }

    //sparawdzamy poprawność hasła
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

    if ((strlen($password) < 8) || (strlen($password) > 20)) {
        $isValid = false;
        $_SESSION['err_pass'] = "Hasło musi posiadać od 8 do 20 znaków";
    }
    if ($password != $passwordRepeat) {
        $isValid = false;
        $_SESSION['err_pass'] = "Hasła nie są identyczne";
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //bot or not
    $secret = ""; // <-- your secret token goes here
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $response = json_decode($check);
    if ($response->success == false) {
        $isValid = false;
        $_SESSION['err_bot'] = 'Potwierdź, że nie jsetseś robotem!';
    }


    //nawieązanie połączenia z bazą danych
    require_once "../baza.php";

    //wyciągnięcie nazwy użytkownika z bazy
    $sqlUsers = 'SELECT Count(username)
				FROM users
				WHERE username = :username';


    //przygotowanie zapytania i zliczenie wartości
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->bindValue(':username', $username, PDO::PARAM_STR);
    $stmtUsers->execute();
    $userNamesCount = $stmtUsers->fetchColumn();


    if ($userNamesCount != 0) {
        $isValid = false;
        $_SESSION['err_username'] = 'Podana nazwa ' . '<b>' . $username . '</b>' . ' jest już zajęta. Podaj inna nazwę';
    }


    //wyciąganie emaili z bazy
    $sqlEmails = 'SELECT Count(email)
                FROM customers
                WHERE email = :email';

    //przygotowanie zapytania i zliczenie wartości
    $stmtEmails = $pdo->prepare($sqlEmails);
    $stmtEmails->bindValue(':email', $email, PDO::PARAM_STR);
    $stmtEmails->execute();
    $userEmailsCount = $stmtEmails->fetchColumn();



    if ($userEmailsCount != 0) {
        $isValid = false;
        $_SESSION['err_email'] = 'Podany email ' . '<b>' . $email . '</b>' . ' jest już zajęty. Podaj inny';
    }


    if ($isValid == true) {
        //dodanie nowego uzytkownika
        $sqlUsers = 'INSERT INTO users(username,pass) VALUES (:username,:pass)';
        $sqlCustomers = 'INSERT INTO customers(first_name, last_name,email, city, street, postalCode) VALUES (:first_name, :last_name, :email, :city, :street, :postalCode)';

        //szyfrowanie hasła podanego w formularzu
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmtUsers = $pdo->prepare($sqlUsers);
        $stmtUsers->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
        $stmtUsers->bindValue(':pass', $hash, PDO::PARAM_STR);
        $stmtUsers->execute();

        $stmtCustomers = $pdo->prepare($sqlCustomers);
        $stmtCustomers->bindValue(':first_name', $_POST['firstName'], PDO::PARAM_STR);
        $stmtCustomers->bindValue(':last_name', $_POST['lastName'], PDO::PARAM_STR);
        $stmtCustomers->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmtCustomers->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
        $stmtCustomers->bindValue(':street', $_POST['street'], PDO::PARAM_STR);
        $stmtCustomers->bindValue(':postalCode', $_POST['postalCode'], PDO::PARAM_STR);
        $stmtCustomers->execute();

        $_SESSION['registerSuccesfull'] = true;
        header('Location: ../widoki/welcome.php');
        exit();
    }
} else {
    if (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] == true)) { {
            if ($_SESSION['role'] == 'admin') {
                header('Location: ../widoki/adminView.php');
                exit();
            }
            if ($_SESSION['role'] == 'owner') {
                header('Location: ../widoki/ownerView.php');
                exit();
            }
            if ($_SESSION['role'] == 'employee') {
                header('Location: ../widoki/employeeView.php');
                exit();
            }
            if ($_SESSION['role'] == 'customer') {
                header('Location: ../widoki/userView.php');
                exit();
            }
        }
    }
}

?>
<html>
<!DOCTYPE html>
<html lang="pl">


<head>

    <link rel="stylesheet" href="../style/style-register.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/fontello.css">
    <title>Rejestracja</title>
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>


</head>

<body>

    <main>
        <article id="reg-panel">

            <aside id="img-container">
                <a href="../index.php" style="position: absolute; margin: 20px;">&#8592; Strona Główna</a>
                <img src="../grafika/pizzerman2.png" alt="pizzerman2">
            </aside>


            <div id="wrapper">
                <section id="error">
                    <?php

                    if (isset($_SESSION['err_username'])) {
                        echo '<div class="error">' . $_SESSION['err_username'] . '</div>';
                        unset($_SESSION['err_username']);
                    }
                    if (isset($_SESSION['err_email'])) {
                        echo '<div class="error">' . $_SESSION['err_email'] . '</div>';
                        unset($_SESSION['err_email']);
                    }
                    if (isset($_SESSION['err_pass'])) {
                        echo '<div class="error">' . $_SESSION['err_pass'] . '</div>';
                        unset($_SESSION['err_pass']);
                    }
                    if (isset($_SESSION['err_bot'])) {
                        echo '<div class="error">' . $_SESSION['err_bot'] . '</div>';
                        unset($_SESSION['err_bot']);
                    }
                    ?>
                </section>

                <section id="form-container">

                    <form method="post">
                        <input type="text" name="firstName" placeholder="Imię">
                        <input type="text" name="lastName" placeholder="Nazwisko">
                        <input type="text" name="username" placeholder="Login">
                        <input type="password" name="password" placeholder="Hasło">
                        <input type="password" name="passwordRepeat" placeholder="Powtórz hasło">
                        <input type="email" name="email" placeholder="Email">
                        <input type="text" name="street" placeholder="Ulica">
                        <input type="text" name="postalCode" placeholder="Kod pocztowy">
                        <input type="text" name="city" placeholder="Miasto">
                        
                        <div class="g-recaptcha" data-sitekey="YOUR PUBLIC TOKEN GOES HERE!" 
                            data-action="SIGNUP">
                        
                        </div>
                        <button>Zarejestruj się</button>
                        <a href="../index.php" style="position: absolute; margin: 20px;">&#8592; Strona Główna</a>
                    </form>

                </section>
            </div>

        </article>

    </main>
</body>

</html>