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
    <title>Dane szczegółowe</title>
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

    <p class="lekarz-wybierz">Analiza danych szczegółowych ankietowanych</p>

    <div class="daneSzczegolowe">

        <div class="ankieta-cd">
            <p>Dane z ankiety:</p>
        </div>

        <div class="ankietaDaneWyniki">
            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vR-TRX2QUSvbUxH3qDZsFl_G3IrnE89WzXp9s-9pqdNp93FaQFTZQ-Ia3e41e5lJmta9fkIao7TPIUy/pubhtml?widget=true&amp;headers=false"></iframe>
        </div>

        <p class="tekst-dataWykresy">Obliczenia szczegółowe:</p>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formType"]) && $_POST["formType"] === "age") {
            $selectedAgeGroup = $_POST["selectedAgeGroup"];
            $selectedColumn = $_POST["selectedColumn"];
            $selectedMethod = $_POST["selectedMethod"];


            if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                $data = [];
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $data[] = $row;
                }
                fclose($handle);

                $filteredData = [];
                $selectedColumnIndex = array_search($selectedColumn, $data[0]);

                foreach ($data as $row) {
                    if (isset($row[2]) && trim($row[2]) == $selectedAgeGroup) {
                        $filteredData[] = $row;
                    }
                }

                if (!empty($filteredData)) {
                    $values = array_column(array_slice($filteredData, 1), $selectedColumnIndex);


                    $result = null;

                    if ($selectedMethod === "srednia") {
                        $result = number_format(array_sum($values) / count($values), 2);
                    } elseif ($selectedMethod === "odchylenie-std") {
                        $result = number_format(sqrt(array_sum(array_map(function ($x) use ($values) {
                            return pow($x - (array_sum($values) / count($values)), 2);
                        }, $values)) / count($values)), 2);
                    } elseif ($selectedMethod === "mediana") {
                        sort($values);
                        $count = count($values);
                        $middle = floor($count / 2);
                        if ($count % 2 == 0) {
                            $result = number_format(($values[$middle - 1] + $values[$middle]) / 2, 2);
                        } else {
                            $result = number_format($values[$middle], 2);
                        }
                    } elseif ($selectedMethod === "moda") {
                        $countValues = array_count_values($values);
                        arsort($countValues);
                        $modes = array_keys($countValues, max($countValues));
                        $result = implode(", ", $modes);
                    } elseif ($selectedMethod === "minimum") {
                        $result = number_format(min($values), 2);
                    } elseif ($selectedMethod === "maksimum") {
                        $result = number_format(max($values), 2);
                    } elseif ($selectedMethod === "kwartyl1") {
                        sort($values);
                        $result = number_format($values[floor(count($values) / 4)], 2);
                    } elseif ($selectedMethod === "kwartyl3") {
                        sort($values);
                        $result = number_format($values[floor(3 * count($values) / 4)], 2);
                    } elseif ($selectedMethod === "iqr") {
                        sort($values);
                        $count = count($values);
                        $q1 = $values[floor($count / 4)];
                        $q3 = $values[floor(3 * $count / 4)];
                        $result = number_format($q3 - $q1, 2);
                    }
                } else {
                    echo "Brak danych dla wybranego przedziału wiekowego.";
                }
            } else {
                echo "Błąd podczas otwierania pliku.";
            }
        }

        ?>

        <form method="post" action="" class="daneSzczegoloweContainer">
            <input type="hidden" name="formType" value="age">
            <div class="slct-wrapper">
                <p>Wybierz przedział:</p>
                <select name="selectedAgeGroup" class="slct-miara">
                    <option value="0-18">0-18</option>
                    <option value="19-35">19-35</option>
                    <option value="36-55">36-55</option>
                    <option value="55+">55+</option>
                </select>
            </div>

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
            <button type="submit" name="submit" class="lekarz-btn">Oblicz</button>
        </form>

        <div class="wykresyContent">
            <div class="wykresy-szczegolowe">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result)) {
                    echo "Wynik: $result";
                }
                ?>
            </div>
            <div class="wykresy-szczegolowe">
                <?php
                $values = [];

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                    $selectedAgeGroup = $_POST["selectedAgeGroup"];
                    $selectedColumn = $_POST["selectedColumn"];
                    $selectedMethod = $_POST["selectedMethod"];

                    if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                        $data = [];
                        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $data[] = $row;
                        }
                        fclose($handle);

                        $filteredData = [];
                        $selectedColumnIndex = array_search($selectedColumn, $data[0]);

                        foreach ($data as $row) {

                            if (isset($row[2]) && trim($row[2]) == $selectedAgeGroup) {
                                $filteredData[] = array_slice($row, 2);
                            }
                        }

                        if (!empty($filteredData)) {
                            $values = array_column($filteredData, $selectedColumnIndex);
                        } else {
                            echo "Brak danych dla wybranego przedziału wiekowego.";
                        }
                    } else {
                        echo "Błąd podczas otwierania pliku.";
                    }
                }
                ?>

                <?php
                if (!empty($values)) {

                    echo ' <table>';
                    foreach ($filteredData as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                    echo '</table>';
                }
                ?>
            </div>

        </div>

        <!-- Obliczenia dla płci -->

        <?php
        $result2 = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formType"]) && $_POST["formType"] === "sex") {
            $selectedSex = $_POST["selectedSex"];
            $selectedColumn = $_POST["selectedColumn"];
            $selectedMethod = $_POST["selectedMethod"];

            if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                $data = [];
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $data[] = $row;
                }
                fclose($handle);

                $filteredData2 = [];
                $selectedColumnIndex2 = array_search($selectedColumn, $data[0]);

                foreach ($data as $row) {
                    if (isset($row[3]) && trim($row[3]) == $selectedSex) {
                        $filteredData2[] = $row;
                    }
                }

                if (!empty($filteredData2)) {
                    $values = array_column(array_slice($filteredData2, 1), $selectedColumnIndex2);

                    $result2 = null;

                    if ($selectedMethod === "srednia") {
                        $result2 = number_format(array_sum($values) / count($values), 2);
                    } elseif ($selectedMethod === "odchylenie-std") {
                        $result2 = number_format(sqrt(array_sum(array_map(function ($x) use ($values) {
                            return pow($x - (array_sum($values) / count($values)), 2);
                        }, $values)) / count($values)), 2);
                    } elseif ($selectedMethod === "mediana") {
                        sort($values);
                        $count = count($values);
                        $middle = floor($count / 2);
                        if ($count % 2 == 0) {
                            $result2 = number_format(($values[$middle - 1] + $values[$middle]) / 2, 2);
                        } else {
                            $result2 = number_format($values[$middle], 2);
                        }
                    } elseif ($selectedMethod === "moda") {
                        $countValues = array_count_values($values);
                        arsort($countValues);
                        $modes = array_keys($countValues, max($countValues));
                        $result2 = implode(", ", $modes);
                    } elseif ($selectedMethod === "minimum") {
                        $result2 = number_format(min($values), 2);
                    } elseif ($selectedMethod === "maksimum") {
                        $result2 = number_format(max($values), 2);
                    } elseif ($selectedMethod === "kwartyl1") {
                        sort($values);
                        $result2 = number_format($values[floor(count($values) / 4)], 2);
                    } elseif ($selectedMethod === "kwartyl3") {
                        sort($values);
                        $result2 = number_format($values[floor(3 * count($values) / 4)], 2);
                    } elseif ($selectedMethod === "iqr") {
                        sort($values);
                        $count = count($values);
                        $q1 = $values[floor($count / 4)];
                        $q3 = $values[floor(3 * $count / 4)];
                        $result2 = number_format($q3 - $q1, 2);
                    }
                } else {
                    echo "Brak danych dla wybranej płci.";
                }
            } else {
                echo "Błąd podczas otwierania pliku.";
            }
        }
        ?>

        <form method="post" action="" class="daneSzczegoloweContainer">
            <input type="hidden" name="formType" value="sex">
            <div class="slct-wrapper">
                <p>Wybierz płci:</p>
                <select name="selectedSex" class="slct-miara">
                    <option value="Kobieta">Kobieta</option>
                    <option value="Mezczyzna">Mężczyzna</option>
                </select>
            </div>

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
            <button type="submit" name="submit2" class="lekarz-btn">Oblicz</button>
        </form>

        <div class="wykresyContent">
            <div class="wykresy-szczegolowe">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result2)) {
                    echo "Wynik: $result2";
                }
                ?>
            </div>
            <div class="wykresy-szczegolowe">
            <?php
                $values = [];

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit2"])) {
                    $selectedSex = $_POST["selectedSex"];
                    $selectedColumn = $_POST["selectedColumn"];
                    $selectedMethod = $_POST["selectedMethod"];

                    if (($handle = fopen("../analiza_danych2.csv", "r")) !== FALSE) {
                        $data = [];
                        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $data[] = $row;
                        }
                        fclose($handle);

                        $filteredData = [];
                        $selectedColumnIndex2 = array_search($selectedColumn, $data[0]);

                        foreach ($data as $row) {

                            if (isset($row[2]) && trim($row[3]) == $selectedSex) {
                                $filteredData[] = array_slice($row, 3);
                            }
                        }

                        if (!empty($filteredData)) {
                            $values = array_column($filteredData, $selectedColumnIndex2);
                        } else {
                            echo "Brak danych dla wybranego przedziału wiekowego.";
                        }
                    } else {
                        echo "Błąd podczas otwierania pliku.";
                    }
                }
                ?>

                <?php
                if (!empty($values)) {
                    echo ' <table>';
                    foreach ($filteredData as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                    echo '</table>';
                }
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

</html>