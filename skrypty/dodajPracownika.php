<?php

session_start();
if ((isset($_SESSION['isLoggedIn'])) && ($_SESSION['isLoggedIn'] == true) && ($_SESSION['role'] == 'admin')) {
    
    if (isset($_POST['username'], $_POST['password'], $_POST['passwordRepeat'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['city'], $_POST['street'], $_POST['postalCode'], $_POST['role'])) {

        //zakładam, że walidacja powiodła się
        $isValid = true;

        // Pobieramy dane z formularza


        $emplyeeName = $_POST['firstName'];
        $employeeLastName = $_POST['lastName'];

        $emplayeeCity = $_POST['city'];
        $employeeStreet = $_POST['street'];
        $employeePostalCode = $_POST['postalCode'];
        $role = $_POST['role'];


        //sprawdzamy poprawność nazwy uży  tkownika
        $employeeUsername = $_POST['username'];
        if ((strlen($employeeUsername) < 3) || (strlen($employeeUsername) > 20)) {
            $isValid = false;
            $_SESSION['err_username'] = "Nazwa użytkownika powinna posiadać od 3 do 20 znaków!";
            header('Location: ../widoki/admin.php');
        }
        if (ctype_alnum($employeeUsername) == false) {
            $isValid = false;
            $_SESSION['err_username'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
            header('Location: ../widoki/admin.php');
        }

        //sprawdzamy poprawność maila
        $employeeEmail = $_POST['email'];
        $emailSanitized = filter_var($employeeEmail, FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailSanitized, FILTER_VALIDATE_EMAIL) == false) || ($emailSanitized != $employeeEmail)) {
            $isValid = false;
            $_SESSION['err_email'] = "Podaj poprawny adres e-mail";
            header('Location: ../widoki/admin.php');
        }

        //sparawdzamy poprawność hasła
        $employeePassword = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];

        if ((strlen($employeePassword) < 8) || (strlen($employeePassword) > 20)) {
            $isValid = false;
            $_SESSION['err_pass'] = "Hasło musi posiadać od 8 do 20 znaków";
            header('Location: ../widoki/admin.php');
        }
        if ($employeePassword != $passwordRepeat) {
            $isValid = false;
            $_SESSION['err_pass'] = "Hasła nie są identyczne";
            header('Location: ../widoki/admin.php');
        }
        $employeeHashedPassword = password_hash($employeePassword, PASSWORD_DEFAULT);

        //nawieązanie połączenia z bazą danych
        require_once "../baza.php";

        //wyciągnięcie nazwy użytkownika z bazy
        $sqlUsers = 'SELECT Count(username)
                        FROM users
                        WHERE username = :username';


        //przygotowanie zapytania i zliczenie wartości
        $stmtUsers = $pdo->prepare($sqlUsers);
        $stmtUsers->bindValue(':username', $employeeUsername, PDO::PARAM_STR);
        $stmtUsers->execute();
        $userNamesCount = $stmtUsers->fetchColumn();


        if ($userNamesCount != 0) {
            $isValid = false;
            $_SESSION['err_username'] = 'Podana nazwa ' . '<b>' . $employeeUsername . '</b>' . ' jest już zajęta. Podaj inna nazwę';
            header('Location: ../widoki/admin.php');
        }


        //wyciąganie emaili z bazy
        $sqlEmails = 'SELECT Count(email)
                        FROM customers
                        WHERE email = :email';

        //przygotowanie zapytania i zliczenie wartości
        $stmtEmails = $pdo->prepare($sqlEmails);
        $stmtEmails->bindValue(':email', $employeeEmail, PDO::PARAM_STR);
        $stmtEmails->execute();
        $userEmailsCount = $stmtEmails->fetchColumn();



        if ($userEmailsCount != 0) {
            $isValid = false;
            $_SESSION['err_email'] = 'Podany email ' . '<b>' . $employeeEmail . '</b>' . ' jest już zajęty. Podaj inny';
            header('Location: ../widoki/admin.php');
        }


        if ($isValid == true) {
            //dodanie nowego uzytkownika
            $sqlUsers = 'INSERT INTO users(username,pass,rol) VALUES (:username,:pass,:rol)';
            $sqlCustomers = 'INSERT INTO customers(first_name, last_name,email, city, street, postalCode) VALUES (:first_name, :last_name, :email, :city, :street, :postalCode)';

            //szyfrowanie hasła podanego w formularzu
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmtUsers = $pdo->prepare($sqlUsers);
            $stmtUsers->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
            $stmtUsers->bindValue(':pass', $hash, PDO::PARAM_STR);
            $stmtUsers->bindValue(':rol', $role, PDO::PARAM_STR);
            $stmtUsers->execute();

            $stmtCustomers = $pdo->prepare($sqlCustomers);
            $stmtCustomers->bindValue(':first_name', $_POST['firstName'], PDO::PARAM_STR);
            $stmtCustomers->bindValue(':last_name', $_POST['lastName'], PDO::PARAM_STR);
            $stmtCustomers->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $stmtCustomers->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
            $stmtCustomers->bindValue(':street', $_POST['street'], PDO::PARAM_STR);
            $stmtCustomers->bindValue(':postalCode', $_POST['postalCode'], PDO::PARAM_STR);

            $stmtCustomers->execute();

            $_SESSION['success'] = "Pomyślnie dodano pracownika";
            header('Location: ../widoki/admin.php');
            exit();
        }
    }
}else{
    header('Location: ../widoki/login.php');
    exit();
}

?>