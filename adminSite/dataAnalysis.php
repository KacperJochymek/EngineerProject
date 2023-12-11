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
    <title>Analiza danych</title>
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
                    <a href="dataAnalysis.php">Analiza danych</a>
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

    <p class="lekarz-wybierz">Analiza danych systemowych</p>

    <div class="dataAnalize">

        <?php

        require '../Logowanie/config.php';

        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $query = "SELECT wiek FROM pacjenci";
        $result = $conn->query($query);

        $ages = array();

        if ($result->num_rows > 0) {
            $totalAge = 0;
            $totalPatients = 0;

            while ($row = $result->fetch_assoc()) {
                $age = $row["wiek"];
                $ages[] = $age;

                $totalAge += $age;
                $totalPatients++;

            }

            $averageAge = $totalAge / $totalPatients;
        } else {
            echo "Brak danych pacjentów w bazie.";
        }

        $conn->close();
        ?>

        <div class="ankieta-cd">
            <p>Dane ankieta <a href="/adminSite/daneAnkieta.php"><i class="fa-solid fa-circle-arrow-right"></i> </p></a>
            <p class="linia"></p>
        </div>
        <p class="tekst-dataWykresy">Miary statystyczne:</p>
        <div class="dataAnalizeSquare">
            <img src="/images/Analiza-danych.jpg" alt="">
            <!-- Miary statystyczne -->
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select class="slct-miara" id="selectValue">
                        <option value="wiek">Wiek</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz miarę:</p>
                    <select class="slct-miara" id="selectMeasure">
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
                <button id="calculateButton" class="lekarz-btn">Oblicz</button>
            </div>
            <div class="wykresy-wynik">
                <p id="result"> </p>
            </div>
        </div>

        <p class="tekst-dataWykresy2">Wykresy:</p>

        <div class="dataAnalizeSquare2">

            <?php

            require '../Logowanie/config.php';

            if ($conn->connect_error) {
                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
            }

            $query = "SELECT województwo FROM pacjenci";
            $result = $conn->query($query);

            $wojewodztwoCount = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $wojewodztwo = $row["województwo"];
                    if (isset($wojewodztwoCount[$wojewodztwo])) {
                        $wojewodztwoCount[$wojewodztwo]++;
                    } else {
                        $wojewodztwoCount[$wojewodztwo] = 1;
                    }
                }
            } else {
                echo "Brak danych pacjentów w bazie.";
            }

            $conn->close();
            ?>

            <?php
            require '../Logowanie/config.php';

            if ($conn->connect_error) {
                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
            }

            $query = "SELECT miasto FROM pacjenci";
            $result = $conn->query($query);

            $miastoCount = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $miasto = $row["miasto"];
                    if (isset($miastoCount[$miasto])) {
                        $miastoCount[$miasto]++;
                    } else {
                        $miastoCount[$miasto] = 1;
                    }
                }
            } else {
                echo "Brak danych pacjentów w bazie.";
            }

            $conn->close();
            ?>

            <img src="/images/wykresy.png" alt="">
            <!-- Wykresy -->
            <div class="miaryStat">
                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select class="slct-miara" id="selectLocation">
                        <option value="miasto">Miasto</option>
                        <option value="wojewodztwo">Województwo</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz wykres:</p>
                    <select class="slct-miara" id="selectChartType">
                        <option value="kolowy">Kołowy</option>
                        <option value="slupkowy">Słupkowy</option>
                    </select>
                </div>
                <button class="lekarz-btn" id="generateChart">Generuj wykres</button>
            </div>
            <div class="wykresy-wykr">
                <canvas id="locationChart"></canvas>
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
<script>
    document.getElementById("calculateButton").addEventListener("click", function() {
        var selectedValue = document.getElementById("selectValue").value;
        var selectedMeasure = document.getElementById("selectMeasure").value;

        var resultText = "";

        if (selectedValue === "wiek" && selectedMeasure === "srednia") {
            var averageAge = <?php echo $averageAge; ?>;
            resultText += "Średni wiek pacjentów: " + averageAge.toFixed(2) + " lat";
        } else if (selectedValue === "wiek" && selectedMeasure === "mediana") {
            var ages = <?php echo json_encode($ages); ?>;
            ages = ages.map(Number);

            if (ages.length === 0) {
                resultText += "Brak dostępnych danych do obliczenia mediany.";
            } else {
                var median;
                ages.sort(function(a, b) {
                    return a - b;
                });
                if (ages.length % 2 === 0) {
                    median = (ages[ages.length / 2 - 1] + ages[ages.length / 2]) / 2;
                } else {
                    median = ages[Math.floor(ages.length / 2)];
                }
                resultText += "Mediana wieku pacjentów: " + median.toFixed(2) + " lat";
            }
        } else if (selectedValue === "wiek" && selectedMeasure === "odchylenie-std") {
            var ages = <?php echo json_encode($ages); ?>;
            ages = ages.map(Number);

            if (ages.length === 0) {
                resultText += "Brak dostępnych danych do obliczenia odchylenia standardowego.";
            } else {
                var mean = ages.reduce(function(sum, value) {
                    return sum + value;
                }, 0) / ages.length;

                var variance = ages.reduce(function(sum, value) {
                    return sum + Math.pow(value - mean, 2);
                }, 0) / ages.length;

                var stdDev = Math.sqrt(variance);
                resultText += "Odchylenie standardowe wieku pacjentów: " + stdDev.toFixed(2) + " lat";
            }
        } else if (selectedValue === "wiek" && selectedMeasure === "moda") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia mody.";
        } else {
            var modeMap = {};
            var maxCount = 0;
            var modes = [];

            for (var i = 0; i < ages.length; i++) {
                var age = ages[i];
                modeMap[age] = (modeMap[age] || 0) + 1;

                if (modeMap[age] > maxCount) {
                    maxCount = modeMap[age];
                    modes = [age];
                } else if (modeMap[age] === maxCount) {
                    modes.push(age);
                }
            }

            if (modes.length === 1) {
                resultText += "Moda wieku pacjentów: " + modes[0] + " lat";
            } else {
                resultText += "Wiele mod: " + modes.join(", ") + " lat";
            }
        }
    } else if (selectedValue === "wiek" && selectedMeasure === "minimum") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia minimum.";
        } else {
            var minimumAge = Math.min(...ages);
            resultText += "Minimum wieku pacjentów: " + minimumAge + " lat";
        }
    } else if (selectedValue === "wiek" && selectedMeasure === "maksimum") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia maksimum.";
        } else {
            var maximumAge = Math.max(...ages);
            resultText += "Maksimum wieku pacjentów: " + maximumAge + " lat";
        }
    }  else if (selectedValue === "wiek" && selectedMeasure === "kwartyl1") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia kwartylu1.";
        } else {
            ages.sort(function(a, b) {
                return a - b;
            });

            var indexQ1 = Math.floor(ages.length / 4);
            var q1 = ages[indexQ1];

            resultText += "Kwartyl 1 wieku pacjentów: " + q1.toFixed(2) + " lat";
        }
    } else if (selectedValue === "wiek" && selectedMeasure === "kwartyl3") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia kwartylu3.";
        } else {
            ages.sort(function(a, b) {
                return a - b;
            });

            var indexQ3 = Math.floor((3 * ages.length) / 4);
            var q3 = ages[indexQ3];

            resultText += "Kwartyl 3 wieku pacjentów: " + q3.toFixed(2) + " lat";
        }
    } else if (selectedValue === "wiek" && selectedMeasure === "iqr") {
        var ages = <?php echo json_encode($ages); ?>;
        ages = ages.map(Number);

        if (ages.length === 0) {
            resultText += "Brak dostępnych danych do obliczenia IQR.";
        } else {
            ages.sort(function(a, b) {
                return a - b;
            });

            var indexQ1 = Math.floor(ages.length / 4);
            var indexQ3 = Math.floor((3 * ages.length) / 4);

            var q1 = ages[indexQ1];
            var q3 = ages[indexQ3];

            var iqr = q3 - q1;

            resultText += "IQR wieku pacjentów: " + iqr.toFixed(2) + " lat";
        }
    } else {
        resultText += "Brak dostępnych danych lub błędne opcje.";
    }

        document.getElementById("result").textContent = resultText;
    });
</script>
<script>
  document.getElementById('generateChart').addEventListener('click', function() {
    var selectedValue = document.getElementById('selectLocation').value;
    var selectedChartType = document.getElementById('selectChartType').value;

    var locationCountsMiasto = <?php echo json_encode($miastoCount); ?>;
    var locationCountsWojewodztwo = <?php echo json_encode($wojewodztwoCount); ?>;
    var parsedLocationCounts = selectedValue === 'miasto' ? locationCountsMiasto : locationCountsWojewodztwo;

    var labels = Object.keys(parsedLocationCounts);
    var data = Object.values(parsedLocationCounts);

    var total = data.reduce((acc, value) => acc + value, 0);
    var percentages = data.map(value => ((value / total) * 100).toFixed(2));
    
    var ctx = document.getElementById('locationChart').getContext('2d');

    if (window.locationChart instanceof Chart) {
        window.locationChart.destroy();
    }

    if (selectedChartType === "kolowy") {
        // Wygeneruj wykres kołowy
        window.locationChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: '%',
                    data: percentages,
                }],
            },
            options: {
                responsive: true,
            },
        });
    } else if (selectedChartType === "slupkowy") {
        // Wygeneruj wykres słupkowy
        window.locationChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Liczba pacjentów',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            },
        });
    }
});

</script>

</html>