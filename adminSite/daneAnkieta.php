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
    <title>Analiza ankieta</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="/images/medease.png">
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

    <div class="ikona_powrot">
        <a href="/adminSite/dataAnalysis.php">
            <i class="fa-regular fa-circle-left"></i>
        </a>
    </div>
    <p class="lekarz-wybierz2">Analiza danych ankietowanych</p>

    <div class="dataAnalize2">

        <div class="ankieta-cd">
            <p>Dane z ankiety:</p>
        </div>

        <div class="ankietaDaneWyniki">
            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vR-TRX2QUSvbUxH3qDZsFl_G3IrnE89WzXp9s-9pqdNp93FaQFTZQ-Ia3e41e5lJmta9fkIao7TPIUy/pubhtml?widget=true&amp;headers=false"></iframe>
        </div>

        <p class="tekst-dataWykresy">Obliczenia dla całej przychodni:</p>

        <div class="dataAnalizeSquare">
            <img src="/images/ankieta.jpg" alt="">
            <!-- Ankieta -->
            <form method="post" action="" class="miaryStat">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $selectedColumn = $_POST["selectedColumn"];
                    $selectedMethod = $_POST["selectedMethod"];

                    if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                        $data = [];
                        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $data[] = $row;
                        }
                        fclose($handle);

                        // Przetwarzanie danych i obliczenia
                        $selectedColumnIndex = array_search($selectedColumn, $data[0]);
                        $values = array_column(array_slice($data, 1), $selectedColumnIndex);

                        $result = null;

                        if ($selectedMethod === "srednia") {
                            $result = array_sum($values) / count($values);
                        } elseif ($selectedMethod === "odchylenie-std") {
                            $result = sqrt(array_sum(array_map(function ($x) use ($values) {
                                return pow($x - (array_sum($values) / count($values)), 2);
                            }, $values)) / count($values));
                        } elseif ($selectedMethod === "mediana") {
                            sort($values);
                            $count = count($values);
                            $middle = floor($count / 2);
                            if ($count % 2 == 0) {
                                $result = ($values[$middle - 1] + $values[$middle]) / 2;
                            } else {
                                $result = $values[$middle];
                            }
                        } elseif ($selectedMethod === "moda") {
                            $countValues = array_count_values($values);
                            arsort($countValues);
                            $modes = array_keys($countValues, max($countValues));
                            $result = implode(", ", $modes);
                        } elseif ($selectedMethod === "minimum") {
                            $result = min($values);
                        } elseif ($selectedMethod === "maksimum") {
                            $result = max($values);
                        } elseif ($selectedMethod === "kwartyl1") {
                            sort($values);
                            $result = $values[floor(count($values) / 4)];
                        } elseif ($selectedMethod === "kwartyl3") {
                            sort($values);
                            $result = $values[floor(3 * count($values) / 4)];
                        } elseif ($selectedMethod === "iqr") {
                            sort($values);
                            $count = count($values);
                            $q1 = $values[floor($count / 4)];
                            $q3 = $values[floor(3 * $count / 4)];
                            $result = $q3 - $q1;
                        }
                    }
                }

                ?>
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="selectedColumn" class="slct-miara">
                        <?php
                        if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                            $header = fgetcsv($handle, 1000, ",");
                            fclose($handle);

                            for ($i = 5; $i < 10 && $i < count($header); $i++) {
                                $column = $header[$i];
                                echo "<option value='$column'>$column</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz miarę:</p>
                    <select name="selectedMethod" class="slct-miara">
                        <option value="srednia">Średnia</option>
                        <option value="mediana">Mediana</option>
                        <option value="moda">Moda</option>
                        <option value="minimum">Minimum</option>
                        <option value="maksimum">Maksimum</option>
                        <option value="kwartyl1">Kwartyl1</option>
                        <option value="kwartyl3">Kwartyl3</option>
                        <!-- zakres miedzykwartylowy -->
                        <option value="iqr">IQR</option>
                        <option value="odchylenie-std">Odchylenie sd</option>
                    </select>
                </div>
                <button class="lekarz-btn">Oblicz</button>
            </form>

            <div class="wykresy">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result)) {
                    // Ograniczenie do dwóch miejsc po przecinku
                    $resultFormatted = number_format($result, 2, '.', '');
                    echo "Wynik obliczenia: $resultFormatted";
                }
                ?>
            </div>
        </div>

        <p class="tekst-dataWykresy">Wykresy dla całej przychodni:</p>

        <div class="dataAnalizeSquare">
            <img src="/images/wykresy.png" alt="">
            <!-- Wykresy -->
            <div class="miaryStat">

                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="wybranaColumna" class="slct-miara" id="selectColumn">

                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz wykres:</p>
                    <select name="wybranyWykres" class="slct-miara" id="chartTypeSelect">
                        <option value="pie">Kołowy</option>
                        <option value="bar">Słupkowy</option>
                    </select>
                </div>
                <button class="lekarz-btn" id="generateChart">Generuj wykres</button>
            </div>
            <div class="wykresy">
                <canvas id="myCharts"></canvas>
            </div>
        </div>

        <div class="ankieta-cd">

            <p class="linia"></p>
            <p>Dane szczegółowe <a href="/adminSite/daneSzczegolowe.php"><i class="fa-solid fa-circle-arrow-right"></i> </p></a>
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
                    <li><a href="/index.php">Strona główna</a></li>
                    <li><a href="/adminSite/addingDoctor.php">Dodaj lekarza</a></li>
                    <li><a href="/adminSite/addingBlog.php">Wpisy blog</a></li>
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
<script src="/adminSite/daneAnaliza.js"></script>


</html>