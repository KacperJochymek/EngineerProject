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
                    <a href="/index.php">Strona główna</a>
                </li>
                <li>
                    <a href="/adminSite/addingDoctor.php">Dodaj lekarza</a>
                </li>
                <li>
                    <a href="/adminSite/addingPrice.php">Zmień cenę</a>
                </li>

                <li>
                    <a href="/adminSite/addingBlog.php">Wpisy blog</a>
                </li>
                <li>
                    <a href="dataAnalysis.php" class="active2">Analiza danych</a>
                </li>
                <li>
                    <a href="/adminSite/adminAccount.php">Moje konto</a>
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
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select id="selectedColumn" class="slct-miara">
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
                    <select id="selectedMethod" class="slct-miara">
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
                <button class="lekarz-btn" id="calculateButton">Oblicz</button>
            </div>

            <div class="wykresy-wynik">
                <p id="result"> </p>
            </div>
        </div>

        <p class="tekst-dataWykresy2">Wykresy dla całej przychodni:</p>

        <div class="dataAnalizeSquare2">
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
            <div class="wykresy-wykr">
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
<script>
    //Obliczanie miar na podstawie pliku CSV - czyli bazy danych z ankiety :)
    document.getElementById("calculateButton").addEventListener("click", function() {
        var selectedColumn = document.getElementById("selectedColumn").value;
        var selectedMethod = document.getElementById("selectedMethod").value;

        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                // Przetwarzanie danych i obliczenia
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn);
                var values = rows.slice(1).map(function(row) {
                    var rowData = row.split(',');
                    return parseFloat(rowData[selectedColumnIndex]);
                });

                var result = null;

                if (selectedMethod === "srednia") {
                    result = values.reduce(function(sum, value) {
                        return sum + value;
                    }, 0) / values.length;
                } else if (selectedMethod === "odchylenie-std") {
                    var mean = values.reduce(function(sum, value) {
                        return sum + value;
                    }, 0) / values.length;
                    result = Math.sqrt(values.reduce(function(sum, value) {
                        return sum + Math.pow(value - mean, 2);
                    }, 0) / values.length);
                } else if (selectedMethod === "mediana") {
                    var sortedValues = values.slice().sort(function(a, b) {
                        return a - b;
                    });
                    var middle = Math.floor(sortedValues.length / 2);
                    result = sortedValues.length % 2 === 0 ?
                        (sortedValues[middle - 1] + sortedValues[middle]) / 2 :
                        sortedValues[middle];
                } else if (selectedMethod === "moda") {
                    var countValues = values.reduce(function(count, value) {
                        count[value] = (count[value] || 0) + 1;
                        return count;
                    }, {});

                    var maxCount = Math.max.apply(null, Object.values(countValues));

                    var modes = Object.keys(countValues).filter(function(key) {
                        return countValues[key] === maxCount;
                    });

                    // Sprawdzenie, czy jest więcej niż jedna moda
                    if (modes.length > 1) {
                        result = modes.map(function(mode) {
                            return mode + ".00";
                        }).join(", ");
                    } else {
                        result = modes[0] + ".00";
                    }
                } else if (selectedMethod === "minimum") {
                    result = Math.min.apply(null, values);
                } else if (selectedMethod === "maksimum") {
                    result = Math.max.apply(null, values);
                } else if (selectedMethod === "kwartyl1") {
                    var sortedValues = values.slice().sort(function(a, b) {
                        return a - b;
                    });
                    result = sortedValues[Math.floor(sortedValues.length / 4)];
                } else if (selectedMethod === "kwartyl3") {
                    var sortedValues = values.slice().sort(function(a, b) {
                        return a - b;
                    });
                    result = sortedValues[Math.floor(3 * sortedValues.length / 4)];
                } else if (selectedMethod === "iqr") {
                    var sortedValues = values.slice().sort(function(a, b) {
                        return a - b;
                    });
                    var q1 = sortedValues[Math.floor(sortedValues.length / 4)];
                    var q3 = sortedValues[Math.floor(3 * sortedValues.length / 4)];
                    result = q3 - q1;
                }

                var resultElement = document.getElementById("result");
                if (typeof result === "number") {
                    resultElement.textContent = "Wynik obliczenia: " + result.toFixed(2);
                } else {
                    resultElement.textContent = "Wynik obliczenia: " + result;
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>

</html>