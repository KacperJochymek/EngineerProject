<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: sign_in.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Strona Główna</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="/index.php"> <img src="/images/medease.png"></a>
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="/images/medease.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/index.php">Strona Główna</a>
                </li>
                <li>
                    <a href="#">Lekarze</a>
                </li>
                <li>
                    <a href="#">Cennik</a>
                </li>
                <li>
                    <a href="#">Aktualności</a>
                </li>
                <li>
                    <a href="#">Kontakt</a>
                </li>
                <li>
                    <a href="#">Moje Konto</a>
                </li>
                <li>
                    <a href="/Logowanie/sign_in.php" class="active">Zaloguj się</a>
                </li>
            </ul>
        </nav>
        <label for="nav_check" class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </label>
    </header>

    <div class="wstep">
        <div class="lekarze">
            <!-- <img src="./images/lekarze.png"> -->
        </div>
        <div class="tekst">
            Umów się na poradę do Twojego lekarza. Od teraz łatwo, szybko
            i bezpiecznie, a to wszystko w jednym miejscu.
        </div>

    </div>

    <div class="ikony_dwa">
        <div class="obrazek_jeden">
            <img src="./images/gwarancja_satysfakcji.png" alt="">
            Gwarancja satysfakcji
        </div>
        <div class="obrazek_jeden">
            <img src="./images/cena.png" alt="">
            Konkurencyjna cena
        </div>
        <div class="obrazek_jeden">
            <img src="./images/doctor.png" alt="">
            Znani specjaliści
        </div>
        <div class="obrazek_jeden">
            <img src="./images/rocker.png" alt="">
            Szybkie terminy
        </div>

    </div>

    <div class="cennik">
        <div class="badanie-cennik">
            <p class="elastyczny-cennik"></p>Elastyczny cennik:
            <div class="badania">199,99zł <br> Zestaw 2 badań</div>
            <div class="badania">99,99 zł <br> Konsultacja</div>
            <div class="badania">899,99 <br> Zestaw 10 badań</div>
        </div>
    </div>

    <div class="informacja">
        <p class="aktualizacje">Aktualizacje:</p>
        <div class="informacja-dwa">
            <div class="logo-aktualizacje">
                <img src="./images/Analiza-danych.jpg" alt="">
            </div>

            <div class="tekst-aktualizacje">
                <b>Postępy w technologii telemedycyny: </b> Telemedycyna staje się coraz popularniejsza, zwłaszcza w kontekście pandemii COVID-19. <br>
                Pacjenci mogą skonsultować się z lekarzem online, otrzymać recepty,a nawet poddać się prostym badaniom medycznym <br>
                bez konieczności wizyty w gabinecie lekarskim. <br>

                <a><button class="aktualizacje-btn">Czytaj dalej...</button></a>
            </div>

        </div>
    </div>

    <div class="umow_sie">
        <p class="umow_sie_tekst"> Umów się na poradę już teraz! <br></p>
        <p class="umow_sie_tekst2">Rejestracja trwa tylko 5 minut. Zadbaj o swoje zdrowie. <br></p>
        <a><button class="btn_znajdz">Znajdź lekarza</button></a>
    </div>

    <div class="patroni">
        Jesteśmy wspierani przez:
        <div class="patroni-logo">
            <img src="/images/logo.png" alt="">
            <img src="/images/medease.png" alt="">
            <img src="/images/hotel.png" alt="">
        </div>
        <div class="patroni-logo">
            <img src="/images/drop.png" alt="">
            <img src="/images/sklep-kj.png" alt="">
            <img src="/images/logo.png" alt="">
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
                    <li><a href="index.php">Strona główna</a></li>
                    <li><a href="#">Umów wizytę</a></li>
                    <li><a href="#">Czytaj bloga</a></li>
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