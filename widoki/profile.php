<?php
session_start();
if ((isset ($_SESSION['isLoggedIn'])) && ($_SESSION['isLoggedIn'] == true)) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin.php");
    }
} else {
    header("Location: login.php");
}
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
    <title>Profil</title>

    <script src="../skrypty/notifications.js"></script>

</head>

<body>
    <header>
        <h1>Witaj <span class="name">
                <?= $_SESSION['first_name'] ?>
            </span>!</h1>

        <nav>
            <a href="../index.php">Strona główna</a>
            <button class="nav-button" onclick="showContent('user')">Dane konta</button>
            <button class="nav-button" onclick="showContent('orders-container')">Zamówienia</button>
        </nav>
    </header>
    <div id="notification"></div>
    <div id="alert"></div>
    <main>
        <article id="user" class="content">
            <section id="user-data">
                <form action="../skrypty/edytuj.php" method="POST" id="EDIT">
                    <h2>Użytkownik</h2>
                    <p>
                        Imię:
                        <span class="name">
                            <?= $_SESSION['first_name'] ?>
                        </span>
                        <a href="#" class="edit" onclick="toggleEditForm('edit-form1')">Edytuj</a>
                    </p>

                    <div id="edit-form1" class="edit-form">
                        <p>Nowe imię: <input type="text" name="newFirstName" id="newFirstName" class="edit-input"></p>
                    </div>


                    <p>
                        Nazwisko:
                        <span class="name">
                            <?= $_SESSION['last_name'] ?>
                        </span>
                        <a href="#" class="edit" onclick="toggleEditForm('edit-form2')">Edytuj</a>
                    </p>

                    <div id="edit-form2" class="edit-form">
                        <p>Nowe nazwisko: <input type="text" name="newLastName" id="newLastName" class="edit-input"></p>
                    </div>


                    <p>
                        Nazwa użytkownika:
                        <span class="name">
                            <?= $_SESSION['username'] ?>
                        </span>
                    </p>

                    <div id="edit-form3" class="edit-form"></div>

                    <p>
                        Adres e-mail:
                        <span class="name">
                            <?= $_SESSION['email'] ?>
                        </span>
                        <a href="#" class="edit" onclick="toggleEditForm('edit-form4')">Edytuj</span></a>
                    </p>

                    <div id="edit-form4" class="edit-form">
                        <p>Nowy adres email: <input type="text" name="newMail" id="newEmail" class="edit-input"></p>
                    </div>
                    <button id="submiter" class="button-disabled">Zapisz</button>
                </form>
            </section>

            <section id="user-address">
                <h2>Adres</h2>
                <p>
                    Ulica:
                    <span class="name">
                        <?= $_SESSION['street'] ?>
                    </span>
                    <a href="#" class="edit" onclick="toggleEditForm('edit-form5')">Edytuj</a>
                </p>

                <div action="../skrypty/edytuj.php" method="post" id="edit-form5" class="edit-form">
                    <p>Nowa Ulica: <input type="text" name="newStreet" id="newStreet" class="edit-input"></p>

                </div>


                <p>
                    Kod pocztowy:
                    <span class="name">
                        <?= $_SESSION['postalCode'] ?>
                    </span>
                    <a href="#" class="edit" onclick="toggleEditForm('edit-form6')">Edytuj</a>
                </p>

                <div action="../skrypty/edytuj.php" method="post" id="edit-form6" class="edit-form">
                    <p>Nowy kod pocztowy: <input type="text" name="newCode" id="newPostaCode" class="edit-input"></p>

                </div>


                <p>
                    Miasto:
                    <span class="name">
                        <?= $_SESSION['city'] ?>
                    </span>
                    <a href="#" class="edit" onclick="toggleEditForm('edit-form7')">Edytuj</a>
                </p>

                <div action="../skrypty/edytuj.php" method="post" id="edit-form7" class="edit-form">
                    <p>Nowe Miasto: <input type="text" name="newCity" id="newCity" class="edit-input"></p>

                </div>
            </section>
        </article>

        <article id="orders-container" class="content">

            <h1 style="width: 100%; text-align: center; font-size: 3em;"><span class="name">Twoje zamówienia</span></h1>

            <?php

            require_once ('../skrypty/wyszukajZamówienieUzytkownika.php');

            if ($ordersCount != 0) {
                foreach ($orders as $order) {
                    ?>

                    <section class="order">
                        <ul>
                            <li>
                                <?= $order['pizza'] . " " . $order['size'] ?>
                            </li>
                            <li>
                                <?= $order['notes'] == 'delivery' ? "dostawa na adres" . '<li>' . $order['address'] . '</li>' : " Odbiór osobisty" ?>
                            </li>
                            <li>
                                <?= $order['status'] ?>
                            </li>
                            <?= $order['notes'] == 'selfpick' ? '<div style="height: 40px";">' . " " . '</div>' : "" ?>
                            <form action="../skrypty/rezygnuj.php" method="post">
                                <li>
                                    <input type="text" name="idValue" value="<?= $order['ID'] ?>" hidden>
                                    <button id="resign" class="button-warn-active">Rezygnuj</button>
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
                echo '<span style="font-size: 2em;">Aktualnie nie masz zamówień</span>';
            }

            ?>

        </article>
    </main>
    <script src="../jquery-3.7.1.min.js"></script>

    <script>
        function showContent(contentId) {
            let allContents = document.querySelectorAll('.content');
            allContents.forEach(function (content) {
                content.style.display = 'none';
            });

            let selectedContent = document.getElementById(contentId);
            if (contentId === "user") {
                selectedContent.style.display = 'block';
            }
            else {
                selectedContent.style.display = 'flex';
            }
        }
    </script>
    <script>


        function toggleEditForm(formId) {
            let editForm = document.getElementById(formId);
            editForm.style.maxHeight = (editForm.style.maxHeight === "0px" || !editForm.style.maxHeight) ? editForm.scrollHeight + "px" : "0px";
        }

        document.querySelectorAll('.edit').forEach(function (editLink) {
            editLink.addEventListener('click', function (event) {
                event.preventDefault(); // Uniemożliwienie domyślnej akcji odnośnika
                let formId = this.getAttribute('data-form'); // Dodane pobieranie identyfikatora formularza z atrybutu data
                toggleEditForm(formId);
            });
        });


    </script>

    <script>

        $(document).ready(function () {
            $('#EDIT').submit(function (event) {
                console.log(event);
                event.preventDefault();
                var formData = $(this).serialize();
                console.log(formData)
                $.ajax({
                    type: 'POST',
                    url: '../skrypty/edytuj.php',
                    data: formData,
                    success: function (response) {
                        displayNotification('Pomyślnie zmieniono dane')
                        setTimeout(function () {
                            location.reload();
                            console.log(response);

                        }, 1000);
                    },
                    error: function (xhr, status, error) {
                        displayAlert("Błąd");
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $(".edit-input").on("input", function () {
                var anyInputFilled = false;
                $(".edit-input").each(function () {
                    if ($(this).val().trim() !== "") {
                        anyInputFilled = true;
                        return false; // przerywamy pętlę each, jeśli jakiekolwiek pole jest wypełnione
                    }
                });

                var button = $("#submiter");

                if (anyInputFilled) {
                    button.removeClass("button-disabled").addClass("button-active");
                } else {
                    button.removeClass("button-active").addClass("button-disabled");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function (){
            $("#resign").click(function(){
                displayAlert("Rezygnacja z zamówienia")
            })
        })
    </script>

</body>

</html>