<?php
require '../Logowanie/config.php';
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["doctor_id"])) {
    $doctor_id = $_POST["doctor_id"];


    $sql = "SELECT * FROM doctors WHERE id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $selected_doctor = $result->fetch_assoc();
        $tytul = $selected_doctor["tytul"];
        $imienazwisko = $selected_doctor["imienazwisko"];
        $profesja = $selected_doctor["profesja"];
        $obrazek = $selected_doctor["obrazek"];
    } else {
        echo "Brak danych do wyświetlenia.";
    }
}

$_SESSION["doctor_data"] = array(
    "doctor_id" => $doctor_id,
    "tytul" => $tytul,
    "imienazwisko" => $imienazwisko,
    "profesja" => $profesja,
    "obrazek" => $obrazek
);
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
            <a href="/index.php"> <img src="/images/logo.png"></a>
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="./images/logo.png" width="100px" height="100px" />
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
                    <a href="blog.php">Blog</a>
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

    <p class="lekarz-wybierz">Wybierz date i godzine wizyty:</p>

    <div class="doctorContent2">
        <div class="lekarz-logo2">
            <?php
            if (isset($tytul) && isset($imienazwisko)) {
                echo '<img src="../adminSite/uploads/' . $obrazek . '" alt="">';
                echo '<p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>' . $tytul . ' ' . $imienazwisko . '</p>';
                echo '<p class="profesja"> <i class="fa-solid fa-stethoscope"></i>' . $profesja . '</p>';
                echo '<form method="POST" action="../userSite/doctorChosen.php">';
                echo '<p id="selectedDate" class="selected-date"><i class="fa-solid fa-calendar-days"></i></p>';
                echo '<p id="selectedHour" class="selected-hour">Godzina twojej wizyty</p>';
                echo '<input type="hidden" name="selectedDate" id="selectedDateInput" value="">';
                echo '<input type="hidden" name="selectedDate" id="selectedDateInput" value="">';
                echo '</form>';
            } else {
                echo "Nie wybrano lekarza.";
            }
            ?>
        </div>

        <div class="doc-chosen">

            <div class="wstep_calendar">
                <p class="current_date"></p>
                <div class="calendar_icons">
                    <i id="prev" class="fa-solid fa-arrow-left"></i>
                    <i id="next" class="fa-solid fa-arrow-right"></i>
                </div>
                <div class="calendar">
                    <ul class="weeks">
                        <li>Pon</li>
                        <li>Wt</li>
                        <li>Śr</li>
                        <li>Czw</li>
                        <li>Pt</li>
                        <li>Sb</li>
                        <li>Nd</li>
                    </ul>
                    <ul class="days">
                        <!-- Generowanie dni -->
                    </ul>
                </div>
            </div>

            <div class="godzinaWizyty" id="availableHours">
                <p class="tekst-wizyta"><i class="fa-regular fa-clock"></i>Godziny wizyt</p>
                <!-- Generowanie godzin wizyt -->
            </div>

            <div class="btn-chosen">
                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["powrot_btn"])) {
                    session_unset();
                    session_destroy();
                    echo '<script>window.location.href = "/userSite/lekarze.php";</script>';
                    exit;
                }
                ?>
                <button type="submit" class="lekarz-btn" name="powrot_btn">Powrót</button>
                <a href="/userSite/doctorChosen.php"><button class="lekarz-btn" type="submit" name="submit">Dalej</button></a>
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
<script src="/userSite/calendar.js"></script>

</html>