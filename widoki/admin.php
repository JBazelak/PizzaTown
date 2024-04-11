<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/fontello.css">
    <link rel="stylesheet" href="../style/style-profile.css">
    <title>Administrator</title>
</head>

<body>
    <header>
        <h1>Witaj <span class="name">
                <?= $_SESSION['first_name'] ?>
            </span>!</h1>

        <nav>
            <a href="../skrypty/logout.php">Wyloguj</a>
            <button class="nav-button" onclick="showContent('user-data')">Dane konta</button>
            <button class="nav-button" onclick="showContent('add-employee')">Dodaj pracownika</button>
            <button class="nav-button" onclick="showContent('add-pizza')">Dodaj pizzę</button>
            <button class="nav-button" onclick="showContent('stats')">Statystyki sprzedarzy</button>
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

    <article id="add-employee" class="content">
        <form method="post" action="../skrypty/dodajPracownika.php">
            <section class="separator">
                <h3><span class="name">Dane pracownika</span></h3>
                <input type="text" name="firstName" placeholder="Imię">
                <input type="text" name="lastName" placeholder="Nazwisko">
                <input type="text" name="username" placeholder="Login">
                <input type="password" name="password" placeholder="Hasło">
                <input type="password" name="passwordRepeat" placeholder="Powtórz hasło">
            </section>

            <section class="separator">
                <h3><span class="name">Dane adresowe</span></h3>
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="street" placeholder="Ulica">
                <input type="text" name="postalCode" placeholder="Kod pocztowy">
                <input type="text" name="city" placeholder="Miasto">
            </section>

            <section class="separator">
                <h3><span class="name">Rola: </span></h3>
                <div>
                    <input type="radio" name="role" id="employeeRadio" value="employee" checked>
                    <label for="employeeRadio">Pracownik</label>
                </div>
                <div>
                    <input type="radio" name="role" id="adminRadio" value="admin">
                    <label for="adminRadio">Administrator</label>
                </div>
            </section>

            <section class="separator">
                <button class="button-active">Dodaj Pracownika</button>
            </section>

        </form>
    </article>

    <article id="add-pizza" class="content">
        <form action="../skrypty/dodajPizze.php" method="post">
            <input type="text" name="nazwa" placeholder="Nazwa">
            <input type="text" name="cena" placeholder="Cena">
            <textarea name="sklad" placeholder="Składniki"></textarea>
            <select name="rozmiar">
                <option selected>Rozmiar pizzy</option>
                <option value="1">Mała</option>
                <option value="2">Duża</option>
            </select>
            <button class="button-active" style="margin-top: 20px; margin-left: 10px;">Dodaj Pizzę</button>
        </form>
    </article>

    <article id="stats" class="content">

        <section class="separator">

            <form method="post" action="">
                <label for="search_day">Wyszukaj dzień:</label>
                <input type="date" id="search_day" name="search_day">
                <button type="submit" class="button-active-sm">
                    <?= empty($_POST['search_day']) ? "Wyszukaj" : "Resetuj" ?>
                </button>
            </form>

            <?php
            require_once("../skrypty/wyszukajDzien.php")
                ?>
        </section>

        <section class="separator">

            <form method="post" action="">

                <label for="search_month">Wyszukaj miesiąc (RRRR-MM):</label>
                <input type="text" id="search_month" name="search_month" pattern="\d{4}-\d{2}"
                    title="Proszę wprowadzić datę w formacie RRRR-MM">

                <button type="submit" class="button-active-sm">
                    <?= empty($_POST['search_month']) ? "Wyszukaj" : "Resetuj" ?>
                </button>

            </form>

            <?php
            require_once("../skrypty/wyszukajMiesiac.php")
                ?>


        </section>

        <section class="separator">

            <span class="name">Najczęściej sprzedawana pizza w miesiącu
                <span style="color: black;">
                    <?php require_once("../skrypty/rodzaj.php") ?>
                </span>
            </span>

        </section>
    </article>

    <script>

        function showContent(contentId) {
            let allContents = document.querySelectorAll('.content');
            allContents.forEach(function (content) {
                content.style.display = 'none';
            });

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