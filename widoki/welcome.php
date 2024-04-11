<?php
// session_start();
// if (!isset($_SESSION["registerSuccesfull"])){
//     header("Location: ../index.php");
//     exit();
// }
// else{
//     unset($_SESSION["registerSuccesfull"]);
// }

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/fontello.css">
    <link rel="stylesheet" href="../style/style-welcome.css">
</head>
<title>Welcome</title>
</head>

<body>
    <div class="welcome-container">
        <h1>Witaj w pizzerii <span style="color: gold;">PizzaTown!</span></h1>
        <p>Dziękujemy za rejestrację. Teraz możesz cieszyć się naszymi pysznymi pizzami i korzystać z ekskluzywnych
            ofert!</p>
        <a href="login.php" class="login-button">
            Zaloguj się
            <span class="arrow arrow-left"></span>
            <span class="arrow arrow-right"></span>
        </a>
    </div>
</body>

</html>