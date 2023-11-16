<?php
require '../Logowanie/config.php';
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);

    $email = $row["email"];
}

if (isset($_GET["doctor_id"])) {
    $doctor_id = $_GET["doctor_id"];

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lekarz 2</title>
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

    <p class="lekarz-wybierz" id="lekarz-wybierz-text">Wybierz date i godzine wizyty:</p>

    <div class="messageSent"></div>

    <div class="doctorContent2">

        <div class="lekarz-logo2">

            <p class="pdsm">Podsumowanie:</p>
            <?php
            if (isset($tytul) && isset($imienazwisko)) {
                echo '<img src="../adminSite/uploads/' . $obrazek . '" alt="">';
                echo '<p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>' . $tytul . ' ' . $imienazwisko . '</p>';
                echo '<p class="profesja"> <i class="fa-solid fa-stethoscope"></i>' . $profesja . '</p>';
                echo '<form method="GET" action="../userSite/doctorChosen.php">';
                echo '<p id="selectedDate" class="selected-date"><i class="fa-solid fa-calendar-days"></i></p>';
                echo '<p id="selectedHour" class="selected-hour">Godzina twojej wizyty</p>';
                echo '</form>';
            } else {
                echo "Nie wybrano lekarza.";
            }
            ?>
        </div>

        <div class="doc-chosen">
            <div class="test" id="formContainer">
                <?php
                require '../Logowanie/config.php';

                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["umow_btn"])) {
                    $imie = $_POST["imie"];
                    $nazwisko = $_POST["nazwisko"];
                    $wiek = $_POST["wiek"];
                    $pesel = $_POST["pesel"];
                    $miasto = $_POST["miasto"];
                    $wojewodztwo = $_POST["wojewodztwo"];
                    $adres_email = $_POST["adres_email"];

                    $id_pacjenta = $imie . " " . $nazwisko;

                    if ($conn->connect_error) {
                        die("Błąd połączenia: " . $conn->connect_error);
                    }

                    $sql = "INSERT INTO pacjenci (id_pacjenta, wiek, pesel, miasto, województwo, adres_email) VALUES ('$id_pacjenta', '$wiek', '$pesel', '$miasto', '$wojewodztwo', '$adres_email')";

                    if ($conn->query($sql) === TRUE) {
                        $sql_wizyta = "SELECT id FROM wizyty WHERE doctor_id = $doctor_id AND status_wizyty = 'dostepna'";
                        $result_wizyta = $conn->query($sql_wizyta);

                        if ($result_wizyta->num_rows > 0) {
                            $row_wizyta = $result_wizyta->fetch_assoc();
                            $id_wizyty = $row_wizyta["id"];

                            $sql_dostepnosc = "INSERT INTO dostepnosc (id_wizyty, id_pacjenta) VALUES ('$id_wizyty', (SELECT id FROM pacjenci WHERE id_pacjenta = '$id_pacjenta'))";

                            if ($conn->query($sql_dostepnosc) === TRUE) {
                                $sql_update_status = "UPDATE wizyty SET status_wizyty = 'zarezerwowana' WHERE id = $id_wizyty";

                                if ($conn->query($sql_update_status) === TRUE) {
                                    echo '<script>window.location.href = "/userSite/successfullVisit.php";</script>';
                                    exit;
                                }
                            } else {
                                echo '<div class="messageSent">Błąd: ' . $sql_update_status . '\\n' . $conn->error . '</div>';
                            }
                        } else {
                            echo '<div class="messageSent">Błąd: ' . $sql_dostepnosc . '\\n' . $conn->error . '</div>';
                        }
                    } else {
                        echo '<div class="messageSent">Brak dostępnych wizyt dla wybranego lekarza"</div>';
                    }
                } 

                ?>

                <form method="POST" onsubmit="return validateForm()">
                    <div class="doctoruser-form">
                        <div class="teksikv">
                            <p class="tekst-doctor3">Imię:</p>
                            <input type="text" name="imie" id="imie" placeholder="Wpisz imię">
                            <p class="tekst-doctor3">Nazwisko:</p>
                            <input type="text" name="nazwisko" id="nazwisko" placeholder="Wpisz nazwisko">
                        </div>
                        <div class="teksikv">
                            <p class="tekst-doctor3">Wiek:</p>
                            <input type="text" name="wiek" id="wiek" placeholder="Wpisz swój wiek">
                            <p class="tekst-doctor3">Pesel:</p>
                            <input type="text" name="pesel" id="pesel" placeholder="Wpisz swój pesel">
                        </div>
                        <div class="teksikv">
                            <p class="tekst-doctor3">Miasto:</p>
                            <input type="text" name="miasto" id="miasto" placeholder="Wpisz miasto">
                            <p class="tekst-doctor3">Województwo:</p>
                            <input type="text" name="wojewodztwo" id="wojewodztwo" placeholder="Wpisz województwo">
                            <p class="tekst-doctor3">E-mail</p>
                            <input type="text" name="adres_email" id="adres_email" placeholder="Wpisz E-mail" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="btn-chosen">

                        <button type="submit" class="lekarz-btn" id="powrotButton" name="powrot_btn">Powrót</button>
                        <button type="submit" class="lekarz-btn" name="umow_btn">Umów się!</button>
                    </div>
                </form>

            </div>

            <div class="wstep_calendar" id="calendarContainer">
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

            <div class="btn-chosen" id="guziczki">

                <?php
                echo '<a href="/userSite/lekarze.php"><button type="submit" class="lekarz-btn" name="powrot_btn">Powrót</button></a>';

                echo '<button class="lekarz-btn" type="submit" name="submit">Dalej</button>';

                ?>
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

<script src="/userSite/test.js"></script>
<script src="/script1.js"></script>
<script src="/userSite/calendar.js"></script>

</html>