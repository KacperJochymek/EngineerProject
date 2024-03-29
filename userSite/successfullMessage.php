<?php
require '../Logowanie/config.php';
session_start();

if (empty($_SESSION["id"])) {
    header("Location: /index.php"); 
    exit();
}

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);

    $userType = $row["role"];
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["doctor_id"])) {
    $doctor_id = $_POST["doctor_id"];


    $sql = "SELECT * FROM doctors WHERE id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $selected_doctor = $result->fetch_assoc();
        $imie = $selected_doctor["imie"];
        $nazwisko = $selected_doctor["nazwisko"];
        $profesja = $selected_doctor["profesja"];
        $obrazek = $selected_doctor["obrazek"];
    } else {
        echo "Brak danych do wyświetlenia.";
    }
}

if (isset($_SESSION["doctor_data"])) {
    $doctor_data = $_SESSION["doctor_data"];
    $doctor_id = $doctor_data["doctor_id"];
    $imie = $doctor_data["imie"];
    $nazwisko = $doctor_data["nazwisko"];
    $profesja = $doctor_data["profesja"];
    $obrazek = $doctor_data["obrazek"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wiadomość ✔️</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
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
                if ($userType === 'user' || $userType === 'admin') {
                    // Nawigacja dla usera
                    echo '<li><a href="/indexLogged.php">Strona główna</a></li>';
                    echo '<li><a href="lekarze.php">Lekarze</a></li>';
                    echo '<li><a href="cennik.php">Cennik</a></li>';
                    echo '<li><a href="blog.php">Aktualności</a></li>';
                    echo '<li><a href="contact.php" class="active2">Kontakt</a></li>';
                    echo '<li><a href="myAccount.php">Moje konto</a></li>';
                } elseif ($userType === 'doctor') {
                    // Nawigacja dla lekarza
                    echo '<li><a href="/indexLogged.php">Strona główna</a></li>';
                    echo '<li><a href="/doctorSite/doctorAccount.php">Godziny pracy</a></li>';
                    echo '<li><a href="/doctorSite/doctorVisitCount.php">Wizyty</a></li>';
                    echo '<li><a href="contact.php" class="active2">Kontakt</a></li>';
                    echo '<li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>';
                }
                ?>
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

    <div class="succesfullContent">

        <div class="messageSuccess">
            <p class="succesThanks">Dziękujemy za wiadomość!</p>
            <i class="fa-regular fa-circle-check"></i>
            <p class="messageCancel">Odpowiemy na Twoje pytanie, tak szybko jak tylko będziemy mogli.
                <?php
                if ($userType === 'user' || $userType === 'admin') {
                    echo 'Aby powrócić do strony głównej <a href="/userSite/myAccount.php">kliknij tutaj.</a>';
                } elseif ($userType === 'doctor') {
                    echo 'Aby powrócić do panelu lekarza <a href="/doctorSite/doctorFirstSite.php">kliknij tutaj.</a>';
                } else {
                    echo 'Aby powrócić do strony głównej <a href="/indexLogged.php">kliknij tutaj.</a>';
                }
                ?>
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

<script src="script1.js"></script>

</html>