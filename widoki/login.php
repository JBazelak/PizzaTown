<?php
session_start();
if ((isset($_SESSION['isLoggedIn'])) && ($_SESSION['isLoggedIn'] == true)) {
    
    if($_SESSION['role'] == 'customer'){
        header("Location: ../index.php");
    }
    if($_SESSION['role'] == 'admin'){
        header("Location: admin.php");
    }
    else{
        header("Location: profile.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../style/style-login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/fontello.css">
</head>

<body>

    <div id="wrapper">

        <div id="w-right">
            <form action="../skrypty/zaloguj.php" method="post">

                <input type="text" name="login" placeholder="Login">
                <input type="password" name="haslo" placeholder="Hasło">
                <button>Zaloguj się</button>

            </form>

            <a href="../index.php">Wróć</a>

            <div id="error">

                <?php
                if (isset($_SESSION['error']))
                    echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>

        </div>

        <div id="w-left"></div>



    </div>

</body>

</html>