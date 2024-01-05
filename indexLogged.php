<?php
session_start();

if (empty($_SESSION["id"])) {
    header("Location: /index.php"); 
    exit();
}

require './Logowanie/config.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);

    $userType = $row["role"];
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
            <?php
            if ($userType === 'user') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease.png"></a>';
            } elseif ($userType === 'doctor') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease_doctor.png"></a>';
            } elseif ($userType === 'admin') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease_admin.png"></a>';
            } else {
                echo '<a href="/indexLogged.php"> <img src="/images/medease.png"></a>';
            }
            ?>
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="/images/medease.png" width="100px" height="100px" />
            </div>
            <ul>
                <?php
                if ($userType === 'user') {
                    echo '<li><a href="/indexLogged.php" class="active2">Strona główna</a></li>';
                    echo '<li><a href="/userSite/lekarze.php">Lekarze</a></li>';
                    echo '<li><a href="/userSite/cennik.php">Cennik</a></li>';
                    echo '<li><a href="/userSite/blog.php">Aktualności</a></li>';
                    echo '<li><a href="/userSite/contact.php">Kontakt</a></li>';
                    echo '<li><a href="/userSite/myAccount.php">Moje konto</a></li>';
                    echo '<li><a href="/Logowanie/logout.php" class="active">Wyloguj się</a></li>';
                } elseif ($userType === 'doctor') {
                    echo '<li><a href="/indexLogged.php" class="active2">Strona główna</a></li>';
                    echo '<li><a href="/doctorSite/doctorAccount.php">Godziny pracy</a></li>';
                    echo '<li><a href="/doctorSite/doctorVisitCount.php">Wizyty</a></li>';
                    echo '<li><a href="/userSite/contact.php">Kontakt</a></li>';
                    echo '<li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>';
                    echo '<li><a href="/Logowanie/logout.php" class="active">Wyloguj się</a></li>';
                } elseif ($userType === 'admin') {
                    echo '<li><a href="/indexLogged.php" class="active2">Strona główna</a></li>';
                    echo '<li><a href="/adminSite/addingDoctor.php">Dodaj lekarza</a></li>';
                    echo '<li><a href="/adminSite/addingPrice.php">Zmień cenę</a></li>';
                    echo '<li><a href="/adminSite/addingBlog.php">Wpisy Blog</a></li>';
                    echo '<li><a href="/adminSite/dataAnalysis.php">Analiza danych</a></li>';
                    echo '<li><a href="/adminSite/adminAccount.php">Moje Konto</a></li>';
                    echo '<li><a href="/Logowanie/logout.php" class="active">Wyloguj się</a></li>';
                } else {

                    echo '<li><a href="/Logowanie/sign_in.php" class="active">Zaloguj się</a></li>';
                }
                ?>
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

                <a href="/userSite/blog.php"><button class="aktualizacje-btn">Czytaj dalej...</button></a>
            </div>

        </div>
    </div>

    <div class="umow_sie">
        <p class="umow_sie_tekst"> Umów się na poradę już teraz! <br></p>
        <p class="umow_sie_tekst2">Rejestracja trwa tylko 5 minut. Zadbaj o swoje zdrowie. <br></p>
        <a href="/userSite/lekarze.php"><button class="btn_znajdz">Znajdź lekarza</button></a>
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
                    <li><a href="/userSite/lekarze.php">Umów wizytę</a></li>
                    <li><a href="/userSite/blog.php">Czytaj bloga</a></li>
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