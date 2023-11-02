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
    <title>Podgląd wizyt</title>
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
                    <a href="/adminSite/addingDoctor.php">Dodaj Lekarza</a>
                </li>
                <li>
                    <a href="/adminSite/addingPrice.php">Zmień cene</a>
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

    <div class="accountAdminLook">

        <p class="lekarz-wybierz">Podgląd wizyt</p>

        <div class="lookUsers">
            <div class="lookVis">
                <p>Wybierz przedział dat:</p>
                <input type="date" placeholder="Wpisz date">
                <input type="date" placeholder="Wpisz date">
            </div>
            <div class="vtableUsers">
                <?php

                require '../Logowanie/config.php';
                require '../adminSite/configs/blog-config.php';

                $sql = "SELECT * FROM pacjenci";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="tble-cennik">';
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Id</th>';
                    echo '<th>Data</th>';
                    echo '<th>Godzina</th>';
                    echo '<th>Lekarz</th>';
                    echo '<th>Pacjent</th>';
                    echo '<th>Status</th>';
                    echo '<th>Akcje</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<form method="post" action="">';
                        echo '<td>' . $row["id_pacjenta"] . '</td>';
                        echo '<td>' . $row["wiek"] . '</td>';
                        echo '<td>' . $row["pesel"] . '</td>';
                        echo '<td>' . $row["miasto"] . '</td>';
                        echo '<td>' . $row["województwo"] . '</td>';
                        echo '<td> <select id="status">
                            
                            </td>';
                        echo '<td>';
                        echo '<input type="hidden" name="id[]" value="' . $row["id"] . '">';
                        echo '<button type="submit" class="edit-btn" name="save-btn[]">Zapisz</button>';
                        echo '<button type="submit" class="delete-btn" name="delete-btn[]">Usuń</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo "Brak danych do wyświetlenia.";
                }
                $conn->close();
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
                    <li><a href="/adminSite/adminAccount.php">Moje konto</a></li>
                    <li><a href="/adminSite/dataAnalysis.php">Analiza danych</a></li>
                    <li><a href="/adminSite/addingDoctor.php">Dodaj Lekarza</a></li>
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