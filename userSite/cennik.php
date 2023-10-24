<?php
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
                <img src="/images/logo.png" width="100px" height="100px" />
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

    <div class="priceSite">
        <?php

        $sql = "SELECT nazwa, cena FROM cennik";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="pricing">';
            echo '<h2>Cennik naszych usług</h2>';
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                echo '<li>' . htmlspecialchars($row["nazwa"]) . ': ' . number_format($row["cena"], 2) . ' zł</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo "Brak danych w cenniku.";
        }
        ?>

        <div class="warningInfo">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <p>Płatności za wykonane usługi realizowane są tylko za pomocą karty lub gotówki w placówce.</p>
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
                <p class="footer-text">ul. Sezamkowa 15</p>
                <p>43-600 XYZ, Polska</p>
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