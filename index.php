<?php
session_start();
$index = 0;
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Najlepsza pizzeria w mieście! Oferujemy pyszne i świeże pizze z wysokiej jakości składników. Zamów online lub odwiedź naszą restaurację już dziś.">
    <meta name="keywords" content="pizza, restauracja, zamówienie online, pyszna pizza, dania włoskie, dostawa pizzy">
    <meta name="author" content="Nazwa Pizzerii">
    <meta http-equiv="Content-Language" content="pl">
    <meta name="og:title" content="PizzaTown - Najlepsza Pizza w Mieście">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="PizzaTown">
    <meta property="og:description"
        content="Zamów pyszną pizzę online z PizzaTown. Szybka dostawa i najwyższa jakość składników.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style\style-index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fontello.css">
    <title>PizzaTown</title>
    <script>
        <?= isset ($_SESSION["isLoggedIn"]) ? 'window.onload = function() {
                document.getElementById("nav-bar").scrollIntoView();
            };' : "" ?>
    </script>
</head>

<body>
    <div id="notification"></div>
    <div id="alert"></div>
    <header>
        <a href="#" onclick="smoothScroll('nav-bar', event)" class="teleport"></a>
        <img src="grafika/Zapraszamy.svg" alt="header-pic">
    </header>

    <nav id="nav-bar">
        <img src="grafika/pizzalogo.avif" alt="PizzaTown-logo">

        <a href="widoki/about.php" class="nav-element">
            <div>
                O nas
                <i class="icon-home"></i>
            </div>
        </a>

        <a href="#" onclick="smoothScroll('contact', event)" class="nav-element">
            <div>
                Menu
                <i class="icon-restaurant"></i>
            </div>
        </a>
        <?php
        echo isset ($_SESSION["isLoggedIn"]) ? '<a href="skrypty/logout.php" class="nav-element">' . "Wyloguj" . '</a>' : '<a href="widoki/register.php" class="nav-element">' . "Rejestracja" . '<i class="icon-user-plus">' . '</i>' . '</a>';
        echo isset ($_SESSION["isLoggedIn"]) ? '<div class="nav-element">' . "Zalogowano: " . $_SESSION["username"] . '</div>' : '<a href="widoki/login.php" class="nav-element">' . "Zaloguj" . '<i class="icon-login"></i>' . '</a>';
        echo isset ($_SESSION["isLoggedIn"]) ? '<a href="widoki/profile.php" class="nav-element">' . "Konto" . '</a>' : "";
        ?>
    </nav>

    <div id="show">
        <nav id="dropdown">
            <ul class="nav-list">
                <li class="nav-item">
                    <img src="grafika/pizzalogo.avif" alt="logo">
                </li>

                <li class="nav-item">
                    <a href="#" id="toggle-button"><i class="icon-menu"></i></a>
                    <section class="dropdown-content">
                        <a href="widoki/about.php" class="dropdown-item">O nas</a>
                        <a href="#" class="dropdown-item" onclick="smoothScrollD('contact', event)">Menu</a>
                        <?php
                        echo isset ($_SESSION["isLoggedIn"]) ? '<a href="skrypty/logout.php" class="dropdown-item">' . "Wyloguj" . '</a>' : '<a href="widoki/register.php" class="dropdown-item">' . "Rejestracja" . '</a>';
                        echo isset ($_SESSION["isLoggedIn"]) ? '<div class="dropdown-item">' . "Zalogowano: " . $_SESSION["username"] . '</div>' : '<a href="widoki/logowanie.php" class="dropdown-item">' . "Zaloguj" . '</a>';
                        echo isset ($_SESSION["isLoggedIn"]) ? '<a href="widoki/profil.php" class="dropdown-item">' . "Konto" . '</a>' : "";
                        ?>
                    </section>
                </li>
            </ul>
        </nav>
    </div>
    <div id="barrier"></div>

    <article id="description">
        <section id="description-l">

            <img src="grafika/czapka.jpg" alt="">
            <h1>Tradycyjna włoska receptura</h1>
            <hr style="width: 70%; text-align: center;">
            <p>Odkryj prawdziwy smak Włoch w każdym kęsie! Nasza tradycyjna włoska pizza to harmonia swieżych
                składników

                i autentycznego smaku, ktory przeniesie Cię prosto do serca włoskiej kuchni.</p>
        </section>

        <section id="description-r">
            <img src="grafika/pizzerman.png" alt="pizzerman">
        </section>
    </article>

    <article id="contact">Zamów teraz! 123 456 789</article>

    <main>
        <article id="menu">

            <?php
            require_once "skrypty/wyszukajPizze.php";
            foreach ($pizzas as $pizza) {
                $index++;
                ?>

                <section class="pizza">
                    <h1>
                        <?= htmlspecialchars($pizza['name']); ?>
                    </h1>

                    <p>
                        Rozmiar:
                        <?= htmlspecialchars($pizza['size']); ?>
                    </p>

                    <p>
                        Cena:
                        <?= htmlspecialchars($pizza['price']); ?> zł
                    </p>

                    <p>
                        Składniki:
                        <?= htmlspecialchars($pizza['ingredients']); ?>
                    </p>

                    <form id="orderForm<?= $index ?>" action="skrypty/dodajZamówienie.php" method="post">

                        <input type="hidden" name="nazwa" value="<?= htmlspecialchars($pizza['name']); ?>">
                        <input type="hidden" name="rozmiar" value="<?= htmlspecialchars($pizza['size']); ?>">
                        <input type="hidden" name="cena" value="<?= htmlspecialchars($pizza['price']); ?>">
                        <input type="hidden" name="skladniki" value="<?= htmlspecialchars($pizza['ingredients']); ?>">
                        <label for="odbior">Sposób dostawy: </label>

                        <select name="odbior" id="odbior">
                            <option value="delivery">Dowóz</option>
                            <option value="selfpick">Odbiór osobisty</option>
                        </select>
                        <button type="button" class="submitOrderButton" data-index="<?= $index ?>">Zamów</button>
                    </form>
                </section>

            <?php } ?>

        </article>
    </main>

    <footer>

        <section id="social">
            <img src="grafika/LOGO2.jpg" alt="logo2">
            <div id="socials">
                <div id="fb"><i class="icon-facebook"></i></div>
                <div id="yt"><i class="icon-youtube-play"></i></div>
                <div id="tw"><i class="icon-twitter"></i></div>
                <div id="v"><i class="icon-vimeo"></i></div>
            </div>
            Lipsum dolor sit amet consectetur adipisicing elit. Unde quia sunt beatae alias dolore atque voluptates
            maiores iure quis nostrum debitis natus ducimus exercitationem vel quaerat, eum, quam, repellat veniam!
            Possimus illo voluptate, architecto eos recusandae inventore minima enim laboriosam sit. Quidem vero
            repellat error optio aut voluptatum inventore, id, quaerat laudantium dolores ratione voluptate
            cupiditate
            ad architecto! Laborum, incidunt!
            Vero, porro! Non fugiat error molestiae esse alias molestias nobis rerum, neque iure aut dolore amet qui
            pariatur nemo facere commodi debitis? Alias voluptas illum architecto, unde eos nam ea.
        </section>

        <section class="end">
            2010-2023 pizzeria. Wszystkie prawa zastrzeżone &copy
        </section>
    </footer>
    <script src="skrypty/scroll.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <script src="skrypty/notifications.js"></script>
    <script>

        let isLogged = <?= isset ($_SESSION['isLoggedIn']) ?>

        $(document).ready(function () {
            let navbar = $("#nav-bar");
            let dropdown = $('#dropdown')
            let sticky = navbar.offset().top;
            let stickyD = dropdown.offset().top;
            let barrier = $("#barrier")
            $(window).scroll(function () {
                if (window.pageYOffset >= sticky - 9) {
                    navbar.css({ "position": "fixed", "top": "0", "margin": "0", "z-index": "9999" });
                    dropdown.css({ "position": "fixed", "top": "0", "margin": "0", "z-index": "9999" });
                    barrier.css({ "display": "block" });
                } else {
                    navbar.css({ "position": "relative", "top": "0", "margin": "0", "z-index": "9999" });
                    dropdown.css({ "position": "relative", "top": "0", "margin": "0", "z-index": "9999" });
                    barrier.css({ "display": "none" });
                }
            });

            $(".submitOrderButton").click(function () {
                let index = $(this).data("index");
                let formData = $("#orderForm" + index).serialize();

                $.ajax({
                    type: "POST",
                    url: "skrypty/dodajZamowienie.php",
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (isLogged == true)
                            displayNotification("Zamówienie zostało pomyślnie złożone. Dziękujemy!");
                        else
                            displayAlert("Aby złożyć zamówienie, musisz się najpierw zalogować.");
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>

</html>