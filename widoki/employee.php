<?php
session_start()
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
    <link rel="stylesheet" href="../style/style-profile.css">
    <title>Pracownik</title>
</head>

<body>
    <header>
        <h1>Witaj <span class="name">
                <?= $_SESSION['first_name'] ?>
            </span>!</h1>

        <nav>
            <a href="../skrypty/logout.php">Wyloguj</a>
            <button class="nav-button" onclick="showContent('user-data')">Dane konta</button>
            <button class="nav-button" onclick="showContent('orders-container')">Zamówienia</button>
        </nav>
    </header>

    <article id="user-data" class="content">

        <h2>Użytkownik</h2>
        <p>
            Imię:
            <span class="name">
                <?= $_SESSION['first_name'] ?>
            </span>
        </p>

        <p>
            Nazwisko:
            <span class="name">
                <?= $_SESSION['last_name'] ?>
            </span>

        </p>

        <p>
            Nazwa użytkownika:
            <span class="name">
                <?= $_SESSION['username'] ?>
            </span>

        </p>

        <p>
            Adres e-mail:
            <span class="name">
                <?= $_SESSION['email'] ?>
            </span>

        </p>
    </article>

    <article id="orders-container" class="content">
        <?php

        if (isset($_POST['searchButton'])) {

            require_once('../skrypty/wyszukajPoNazwie.php');

            //######    WORKS WHEN SERACHBAR WAS USED    ###### 
        
            if (!empty($orders)) {

                foreach ($orders as $order) {
                    ?>
                    <section class="order">
                        <h1>Zamówienie
                            <?= $order['firstname']; ?>
                            <?= $order['lastname']; ?>
                        </h1>

                        <ul>
                            <li>
                                <?= $order['pizza'] ?>
                            </li>

                            <li>
                                <?= $order['size'] ?>
                            </li>

                            <li>
                                <?= $order['date'] ?>
                            </li>

                            <li>
                                <?= $order['notes'] ?>
                                <?= $order['notes'] == 'dowoz' ? '<li>' . $order['address'] . '</li>' : "" ?>;
                            </li>

                            <li>
                                <?= $order['status'] ?>
                            </li>

                            <form action="../skrypty/dodajZamowienie.php">
                                <li>
                                    <button>Przyjmij zamówienie</button>
                                </li>

                            </form>
                        </ul>
                    </section>
                <?php } ?>


                <?php
            } else {
                echo "Nic nie znaleziono";
            }


            //######    WORKS WHEN SERACHBAR WASN'T USED    ######    
        

        } else {

            require_once('../skrypty/wyszukajZamówienie.php');

            if (!empty($orders)) {

                foreach ($orders as $order) {
                    ?>

                    <section class="order">

                        <h1>Zamówienie
                            <span class="name"><?= $order['firstname']; ?>
                            <?= $order['lastname']; ?></span>
                        </h1>

                        <ul>
                            <li>
                                <?= $order['pizza']." ".$order['size'] ?>
                            </li>

                            <li>
                                <?= $order['notes'] == 'delivery' ? "dostawa na adres" . '<li>' . $order['address'] . '</li>' : " Odbiór osobisty" ?>
                            </li>

                            <li>
                                <?= $order['status'] ?>
                            </li>
                            <?= $order['notes'] == 'selfpick' ? '<div style="height: 40px";">' . " " . '</div>' : "" ?>
                            <form action="../skrypty/dodajZamowienie.php" method="post">
                                <li>
                                    <?php if ($order['status'] != 'rezygnacja'): ?>
                                        <input type="text" name="idValue" value="<?= $order['ID'] ?>" hidden>
                                        <button class="button-active">Przyjmij zamówienie</button>
                                    <?php else: ?>
                                        <button class="button-disabled" disabled>Przyjmij zamówienie</button>
                                    <?php endif ?>
                                </li>
                            </form>

                            <form action="../skrypty/usun.php" method="post">
                                <li>
                                    <?php if ($order['status'] != 'rezygnacja'): ?>
                                        <button class="button-warn-disabled" disabled>Usuń</button>
                                    <?php else: ?>
                                        <input type="text" name="idValue" value="<?= $order['ID'] ?>" hidden>
                                        <button class="button-warn-active">Usuń</button>
                                    <?php endif ?>
                                </li>
                            </form>

                            <li class="date-time">
                                <?= $order['date'] ?>
                            </li>
                        </ul>

                    </section>

                    <?php
                }

            } else {
                echo "Aktualnie nie ma zamówień";
            }
        }
        ?>

    </article>
    <script>
        function showContent(contentId) {
            // Ukryj wszystkie sekcje
            let allContents = document.querySelectorAll('.content');
            allContents.forEach(function (content) {
                content.style.display = 'none';
            });

            // Pokaż wybraną sekcję
            let selectedContent = document.getElementById(contentId);
            if (contentId === "user-data") {
                selectedContent.style.display = 'block';
            }
            else {
                selectedContent.style.display = 'flex';
            }
        }
    </script>
</body>

</html>