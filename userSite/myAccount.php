<?php
session_start();
require '../Logowanie/config.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Moje konto</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
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
                    <a href="lekarze.php">Lekarze</a>
                </li>
                <li>
                    <a href="cennik.php">Cennik</a>
                </li>
                <li>
                    <a href="blog.php">Aktualności</a>
                </li>
                <li>
                    <a href="contact.php">Kontakt</a>
                </li>

                <li>
                    <a href="myAccount.php">Moje Konto</a>
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

    <div class="myAccountSite">
        <h1>Witamy <?php echo $row["username"]; ?> !</h1>

        <p class="settingi" id="toggleSettings"><i class="fa-solid fa-gears"></i>Ustawienia</p>

        <div class="mojeWizyty-container">
            <div class="mojeWizyty">
                <p class="tekst-wizytyMyAcc">Moje wizyty:</p>

                <div class="wyswietlanieMyAcc">
                    <img src="../adminSite/uploads/kobieta.png" alt="">
                    <div class="resztaMyAcc">
                        <p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>Imie i Nazwisko lekarza</p>
                        <p class="profesja"> <i class="fa-solid fa-stethoscope"></i>Profesja</p>
                        <p id="selectedDate" class="selected-date">Data</p>
                        <p id="selectedHour" class="selected-hour">Godzina twojej wizyty</p>
                    </div>
                    <button class="myAccBtn">Anuluj</button>
                </div>

                <div class="wyswietlanieMyAcc">
                    <img src="../adminSite/uploads/kobieta.png" alt="">
                    <div class="resztaMyAcc">
                        <p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>Imie i Nazwisko lekarza</p>
                        <p class="profesja"> <i class="fa-solid fa-stethoscope"></i>Profesja</p>
                        <p id="selectedDate" class="selected-date">Data</p>
                        <p id="selectedHour" class="selected-hour">Godzina twojej wizyty</p>
                    </div>
                    <button class="myAccBtn">Anuluj</button>
                </div>
            </div>

            <div class="settings-inpt">
                <div class="changePass">
                    <div class="input-cntiner">
                        <input class="haslo" type="password" placeholder="Stare hasło">
                        <input class="haslo" type="password" placeholder="Nowe hasło">
                    </div>
                    <button class="myAccBtn">Zmień hasło</button>
                    <button class="myAccBtn">Usuń konto</button>
                </div>
            </div>
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
                    <li><a href="/userSite/myAccount.php">Moje konto</a></li>
                    <li><a href="/userSite/analizeForm.php">Ankieta</a></li>
                    <li><a href="/userSite/contact.php">Kontakt</a></li>
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

<script src="/script1.js"></script>
<script src="/userSite/test.js"></script>

</html>