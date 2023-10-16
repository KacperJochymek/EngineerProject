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
                    <a href="/adminSite/addingDoctor.php">Dodaj Lekarza</a>
                </li>
                <li>
                    <a href="#">Zmień cene</a>
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

                $sql = "SELECT * FROM wizyty";
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
                        echo '<td>' . $row["id"] . '</td>';
                        echo '<td>' . $row["data"] . '</td>';
                        echo '<td>' . $row["godzina"] . '</td>';
                        echo '<td>' . $row["lekarz"] . '</td>';
                        echo '<td>' . $row["pacjent"] . '</td>';
                        echo '<td> <select id="status">
                            <option value="oczekujaca">Oczekująca</option>
                            <option value="potwierdzona">Potwierdzona</option>
                            <option value="anulowana">Anulowana</option>'
                        


                            . $row["status"] .
                            '</select>
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