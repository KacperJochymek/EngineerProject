<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION["id"])) {
    header("Location: /index.php"); // Przekieruj na stronę logowania, jeśli użytkownik nie jest zalogowany
    exit();
}

// Sprawdź, czy użytkownik ma rolę administratora
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
                <img src="./images/logo.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/index.php">Strona Główna</a>
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
                    <a href="">Analiza Danych</a>
                </li>
                <li>
                    <a href="">Moje Konto</a>
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

    
    <p class="lekarz-wybierz">Dodaj post na strone bloga</p>


    <div class="blog_adding">
        <?php
        require '../Logowanie/config.php';

        if (isset($_POST["signup_submit"])) {
            $tekst = $_POST["tekst"];
            $data = date("Y-m-d"); // Aktualna data

            // Obsługa przesyłania pliku
            $obrazek_name = $_FILES["obrazek"]["name"];
            $obrazek_temp = $_FILES["obrazek"]["tmp_name"];
            $obrazek_type = $_FILES["obrazek"]["type"];

            // Sprawdź, czy przesłany plik to obrazek
            if (substr($obrazek_type, 0, 5) === "image") {
                // Przenieś przesłany plik do stałego miejsca
                move_uploaded_file($obrazek_temp, "uploads/" . $obrazek_name);

                if ($conn->connect_error) {
                    die("Błąd połączenia: " . $conn->connect_error);
                }

                // Przygotuj i wykonaj zapytanie SQL do dodania danych
                $sql = "INSERT INTO blog (tekst, obrazek, dat) VALUES ('$tekst', '$obrazek_name', '$data')";

                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Wpis dodany pomyślnie!");</script>';
                } else {
                    echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
                }

                $conn->close();
            } else {
                echo '<script>alert("Błąd: Plik nie jest obrazkiem.");</script>';
            }
        }
        ?>

        <form class="blog-form" method="POST" enctype="multipart/form-data"> <!-- Dodaj enctype="multipart/form-data" aby obsłużyć przesyłanie pliku -->
            <input type="text" name="tekst" class="message-inpt" placeholder="Treść wpisu bloga">
            <input type="file" name="obrazek" id="obrazek" class="file-input">
            <input type="submit" name="signup_submit" class="lekarz-btn" value="Wyślij">
        </form>
    
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