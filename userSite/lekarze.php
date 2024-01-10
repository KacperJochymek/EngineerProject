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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wybór lekarza</title>
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
                <li>
                    <a href="/indexLogged.php">Strona główna</a>
                </li>
                <li>
                    <a href="lekarze.php" class="active2">Lekarze</a>
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

                <?php
                if ($userType === 'user') {
                    echo '<li><a href="/userSite/myAccount.php">Moje konto</a></li>';
                } elseif ($userType === 'doctor') {
                    echo '<li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>';
                } elseif ($userType === 'admin') {
                    echo '<li><a href="/adminSite/adminAccount.php">Moje Konto</a></li>';
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

    <p class="lekarz-wybierz">Wybierz lekarza dla siebie:</p>

    <div class="lekarze-wybor">
        <?php
        require '../Logowanie/config.php';

        if ($conn->connect_error) {
            die("Błąd połączenia: " . $conn->connect_error);
        }

        // Przygotuj zapytanie SQL do pobrania danych z tabeli 'doctors'
        $sql = "SELECT * FROM doctors";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Iteruj przez wyniki zapytania i generuj divy
            while ($row = $result->fetch_assoc()) {
                echo '<div class="lekarz-logo">';
                echo '<img src="/adminSite/uploads/' . $row["obrazek"] . '" alt="">';
                echo '<p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i> ' . $row["tytul"] . ' ' . $row["imienazwisko"] . ' </p>';
                echo '<p class="profesja"> <i class="fa-solid fa-stethoscope"></i>' . $row["profesja"] . '</p>';
                echo '<form method="GET" action="../userSite/doctorVisit.php">';
                echo '<input type="hidden" name="doctor_id" value="' . $row["imienazwisko"] . '">';
                echo '<button class="lekarz-btn" type="submit">Umów się</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "Brak danych do wyświetlenia.";
        }
        $conn->close();
        ?>
    </div>

    <div class="dostosuj-wysokosc"></div>
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
<script>
    //Skrypt do powiększania wysokości strony
    var dostosujWysokosc = document.querySelector('.dostosuj-wysokosc');
    var lekarzeContainer = document.querySelector('.lekarze-wybor');
    var lekarze = document.querySelectorAll('.lekarze-wybor .lekarz-logo');

    var lekarzeNaRzad = 2;
    var iloscRzedow = Math.ceil(lekarze.length / lekarzeNaRzad);
    var lekarzeWyborHeight = iloscRzedow * (lekarze[0].offsetHeight + 10);

    dostosujWysokosc.style.height = (lekarzeWyborHeight - 350) + 'px';
</script>

</html>