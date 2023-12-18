<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: /index.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] !== "doctor") {
    header('Location: ../userSite/noPermission.php');
    session_destroy();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Konto lekarza</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="/images/medease_doctor.png">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="/images/medease.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/index.php">Strona główna</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorAccount.php">Godziny pracy</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorVisitCount.php">Wizyty</a>
                </li>
                <li>
                    <a href="/userSite/contact.php">Kontakt</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorFirstSite.php" class="active2">Moje konto</a>
                </li>
                <li>
                    <a href="/Logowanie/logout.php" class="active">Wyloguj się</a>

                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>

    <div class="account">

        <h1>Witamy w panelu obsługi lekarza!</h1>

        <div class="count">
            <p>Liczba wizyt dzisiaj:</p>
            <?php

            require '../Logowanie/config.php';

            $today = date("Y-m-d");

            $query = "SELECT * FROM wizyty WHERE data_wizyty = '$today'";
            $result = $conn->query($query);

            if (!$result) {
                die("Błąd zapytania: " . $conn->error);
            }

            $today_visits = 0;

            while ($row = $result->fetch_assoc()) {
                if ($row["data_wizyty"] == $today) {
                    $today_visits++;
                }
            }

            ?>
            <div class="wynik">
                <span class="rotating-number">
                    <?php
                    echo $today_visits;
                    ?>
                </span>
            </div>
        </div>
        <div class="admin-panel">
            <a href="/doctorSite/doctorAccount.php">Dodaj godziny pracy</a>
            <a href="/doctorSite/doctorVisitCount.php">Podgląd wizyt</a>
        </div>
    </div>

    <footer>
        <div class="foo">
            <div class="col-1">
                <h1>O nas</h1>

                <p class="footer-text">Witamy w Medease! Nasza firma zajmuje się tworzeniem oprogramowania dla przychodni. W naszej aplikacji pacjent może wybrać odpowiedniego dla siebie lekarza, umówić wizytę, skonsultować
                    swój stan zdrowia i wiele więcej. Ponadto może ocenić swoją wizytę, a to wszystko w jednym miejscu.</p>
            </div>

            <div class="col-1">
                <h1>Biuro</h1>
                <p class="footer-text">ul. Sezamkowa 15</p>
                <p>43-600 XYZ, Polska</p>
                <p class="email-id"><b>E-mail:</b> <br> kontakt@medease.pl</p>
                <p><b>Numer telefonu: </b> <br> 123-456-789</p>
            </div>

            <div class="col-1">
                <h1>Przydatne linki</h1>
                <ul>
                    <li><a href="/doctorSite/doctorAccount.php">Wizyty</a></li>
                    <li><a href="/userSite/blog.php">Blog</a></li>
                    <li><a href="/userSite/lekarze.php">Lekarze</a></li>
                </ul>
            </div>
            <div class="col-1">
                <h1>Skontaktuj się!</h1>
                <div class="sociale">
                    <a href="https://www.facebook.com/">
                        <div class="circle"><i class="fa-brands fa-facebook-f"></i></div>
                    </a>
                    <a href="https://twitter.com/">
                        <div class="circle"><i class="fa-brands fa-x-twitter"></i></div>
                    </a>
                    <a href="https://instagram.com/">
                        <div class="circle"><i class="fa-brands fa-instagram"></i></div>
                    </a>
                    <a href="https://tiktok.com/">
                        <div class="circle"><i class="fa-brands fa-tiktok"></i></div>
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright"> Wszelkie prawa zastrzeżone. Medease 2023 ©</p>
    </footer>

</body>

<script src="script1.js"></script>

</html>