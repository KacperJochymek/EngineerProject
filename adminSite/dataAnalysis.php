<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: /index.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] !== "admin") {
    header('Location: ../userSite/noPermission.php');
    session_destroy();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>EngineerProject</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="/images/logo.png">
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="/images/logo.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/index.php">Strona Główna</a>
                </li>
                <li>
                    <a href="/adminSite/addingDoctor.php">Dodaj Lekarza</a>
                </li>
                <li>
                    <a href="#">Zmień cene</a>
                </li>

                <li>
                    <a href="/adminSite/addingBlog.php">Wpisy Blog</a>
                </li>
                <li>
                    <a href="dataAnalysis.php">Analiza Danych</a>
                </li>
                <li>
                    <a href="/adminSite/adminAccount.php">Moje Konto</a>
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

    <p class="lekarz-wybierz">Sekcja analizy danych dla administratora</p>

    <div class="dataAnalize">
        
        <p class="tekst-dataWykresy">Miary statystyczne:</p>
        <div class="dataAnalizeSquare">
            <img src="/images/Analiza-danych.jpg" alt="">
            <!-- Miary statystyczne -->
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select class="slct-miara">
                        <option value="wiek">Wiek</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz miarę:</p>
                    <select class="slct-miara">
                        <option value="srednia">Średnia</option>
                        <option value="mediana">Mediana</option>
                        <option value="odchylenie-std">Odchylenie std</option>
                    </select>
                </div>
                <button class="lekarz-btn">Oblicz</button>
            </div>
            <div class="wykresy">
                <p>Tutaj beda sie generowac obliczenia</p>
            </div>
        </div>

        <p class="tekst-dataWykresy">Wykresy:</p>

        <div class="dataAnalizeSquare">
            <img src="/images/wykresy.png" alt="">
            <!-- Wykresy -->
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select class="slct-miara">
                        <option value="wiek">Wiek</option>
                        <option value="miasto">Miasto</option>
                        <option value="wojewodztwo">Wojewodztwo</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz wykres:</p>
                    <select class="slct-miara">
                        <option value="miara1">Kołowy</option>
                        <option value="miara2">Liniowy</option>
                        <option value="miara3">Słupkowy</option>
                    </select>
                </div>
                <button class="lekarz-btn">Generuj wykres</button>
            </div>
            <div class="wykresy">
                <p>Tutaj beda sie generowac wykresy</p>
            </div>
        </div>

        <p class="tekst-dataWykresy">Date z ankiety:</p>

        <div class="dataAnalizeSquare">
            <img src="/images/ankieta.jpg" alt="">
            <!-- Ankieta -->
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz:</p>
                    <select class="slct-miara">
                        <option value="miara1">Miara 1</option>
                        <option value="miara2">Miara 2</option>
                        <option value="miara3">Miara 3</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz:</p>
                    <select class="slct-miara">
                        <option value="miara1">Miara 1</option>
                        <option value="miara2">Wiek</option>
                        <option value="miara3">Miara 3</option>
                    </select>
                </div>
                <button class="lekarz-btn">Oblicz</button>
            </div>
            <div class="wykresy">
                <p>Tutaj beda sie wyświetlać obliczenia z ankiety</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="foo">
            <div class="col-1">
                <h1>O nas</h1>

                <p class="footer-text">Witamy w Kacper Jochymek. Jesteśmy firmą, która zajmuje się tworzeniem oprogramowania dla sieci przychodni. W naszej aplikacji pacjent może wybrać odpowiedniego dla siebie lekarza, umówić wizytę, skonsultować
                    swój stan zdrowia i ma to wszystko pod ręką.</p>
            </div>

            <div class="col-1">
                <h1>Biuro</h1>
                <p class="footer-text">ul. Galla Anonima 7</p>
                <p>43-608 Jaworzno, Polska</p>
                <p class="email-id"><b>Nasz adres e-mail:</b> <br> k.joch19@wp.pl</p>
                <p><b>Numer telefonu: </b> <br> 576-157-274</p>
            </div>

            <div class="col-1">
                <h1>Przydatne linki</h1>
                <ul>
                    <li><a href="/index.php">Strona główna</a></li>
                    <li><a href="#">Umów wizytę</a></li>
                    <li><a href="#">Cennik</a></li>
                </ul>
            </div>
            <div class="col-1">
                <h1>Skontaktuj się!</h1>
                <!-- <form>
                    <input type="text" placeholder="Twój adres e-mail">
                    <input type="text" placeholder="Zadaj pytanie">
                    <button type="submit">Wyślij!</button>
                </form> -->
                <div class="sociale">
                    <div class="circle"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="circle"><i class="fa-brands fa-x-twitter"></i></div>
                    <div class="circle"><i class="fa-brands fa-instagram"></i></div>
                    <div class="circle"><i class="fa-brands fa-tiktok"></i></div>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright"> Copyright © YOHM 2023 Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>

<script src="script1.js"></script>

</html>