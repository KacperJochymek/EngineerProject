<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: UserLogin.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>EngineerProject</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="./images/logo.png">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="./images/logo.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="">Strona Główna</a>
                </li>
                <li>
                    <a href="">Lekarze</a>
                </li>
                <li>
                    <a href="">Cennik</a>
                </li>
                <li>
                    <a href="">Kontakt</a>
                </li>
                <li>
                    <a href="">Moje Konto</a>
                </li>
                <li>
                    <a href="./Logowanie/sign_in.php" class="active">Zaloguj się</a>
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>
    <div class="lekarze">
        <img src="./images/lekarze.png">
    </div>
    <div class="tekst">
        Umów się na poradę do Twojego lekarza. Od teraz łatwo, szybko <br>
        i bezpiecznie, a to wszystko <br> w jednym miejscu.
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="ikony_dwa">
        <div id="obrazek_jeden">
            <img src="./images/gwarancja_satysfakcji.png" alt="">
            Gwarancja satysfakcji
        </div>
        <div id="obrazek_dwa">
            <img src="./images/cena.png" alt="">
            Konkurencyjna cena
        </div>
        <div id="obrazek_trzy">
            <img src="./images/doctor.png" alt="">
            Znani specjaliści
        </div>
        <div id="obrazek_cztery">
            <img src="./images/rocker.png" alt="">
            Szybkie terminy
        </div>

    </div>

    <div class="cennik">
        Elastyczny cennik
    </div>

    <div class="informacja">
        Aktualizacje:
    </div>

    <div class="umow_sie">
        Umów się na poradę już teraz! <br><br>

        Rejestracja trwa tylko 5 minut. Zadbaj o swoje zdrowie.

        <button>Znajdź lekarza</button>
    </div>

    <div class="patroni">
        Jesteśmy wspierani przez:
    </div>

    <footer>
        <div class="foo">
            <div class="col-1">
                <h3>O nas</h3>
                <img src="./images/logo.png" class="logo">
                <p>Jesteśmy firmą specjalizującą się w oprogramowaniu dla sieci szpitali i przychodni. <br>
                    Dzięki nam pacjent ma wszystko pod ręką.</p>
            </div>

            <div class="col-1">
                <h3>Biuro</h3>
                <p>ul. Galla Anonima 7</p>
                <p>Jaworzno, Polska</p>
                <p class="email-id">k.joch19@wp.pl</p>
                <p>576-157-274</p>
            </div>

            <div class="col-1">
                <h3>Przydatne linki</h3>
                <ul>
                    <li><a href="#">Strona główna</a></li>
                    <li><a href="#">Umów wizytę</a></li>
                    <li><a href="#">Cennik</a></li>
                </ul>
            </div>
            <div class="col-1">
                <h3>Kontakt</h3>
                <form>
                    <input type="text" placeholder="Twój adres e-mail">
                    <input type="text" placeholder="Zadaj pytanie">
                    <button type="submit">Wyślij!</button>
                </form>
                <div class="sociale">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-tiktok"></i>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright"> Copyright © YOHM 2023 Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>

</html>