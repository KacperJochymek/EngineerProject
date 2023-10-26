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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="/images/logo.png">
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

    <p class="lekarz-wybierz">Sekcja analizy danych dla administratora</p>

    <div class="dataAnalize">

        <p class="tekst-dataWykresy">Dane z ankiety:</p>

        <div class="ankietaDaneWyniki">
            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vR-TRX2QUSvbUxH3qDZsFl_G3IrnE89WzXp9s-9pqdNp93FaQFTZQ-Ia3e41e5lJmta9fkIao7TPIUy/pubhtml?widget=true&amp;headers=false"></iframe>
        </div>

        <p class="tekst-dataWykresy">Obliczenia:</p>

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
                        <option value="odchylenie-std">Odchylenie std</option>
                        <option value="mediana">Mediana</option>
                        <option value="moda">Moda</option>
                    </select>
                </div>
                <button class="lekarz-btn">Oblicz</button>
            </form>

            <div class="wykresy">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result)) {
                    echo "Wynik obliczenia: $result";
                }
                ?>
            </div>
        </div>

        <p class="tekst-dataWykresy">Wykresy:</p>

        <div class="dataAnalizeSquare">
            <img src="/images/wykresy.png" alt="">
            <!-- Wykresy -->
            <form method="post" action="" class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="selectedColumn" class="slct-miara">
                    <?php
                        if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                            $header = fgetcsv($handle, 1000, ",");
                            fclose($handle);

                            for ($i = 2; $i < count($header); $i++) {
                                $column = $header[$i];
                                echo "<option value='$column'>$column</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz wykres:</p>
                    <select class="slct-miara">
                        <option value="kolowy">Kołowy</option>
                        <option value="liniowy">Liniowy</option>
                        <option value="slupkowy">Słupkowy</option>
                    </select>
                </div>
                <button class="lekarz-btn">Generuj wykres</button>
            </form>
            <div class="wykresy">
                <canvas id="myChart"></canvas>
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