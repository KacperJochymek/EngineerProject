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

    <p class="lekarz-wybierz">Sekcja analizy danych dla administratora</p>

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

                // Tutaj możesz wykonywać operacje na województwach i miastach, np. tworzyć wykresy
            }

            $averageAge = $totalAge / $totalPatients;
        } else {
            echo "Brak danych pacjentów w bazie.";
        }

        $conn->close();
        ?>

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
                        <option value="odchylenie-std">Odchylenie std</option>
                    </select>
                </div>
                <button id="calculateButton" class="lekarz-btn">Oblicz</button>
            </div>
            <div class="wykresy">
                <p id="result">Wynik będzie wyświetlony tutaj</p>
            </div>
        </div>

        <p class="tekst-dataWykresy">Wykresy:</p>

        <div class="dataAnalizeSquare">

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
                        <option value="wojewodztwo">Wojewodztwo</option>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Wybierz wykres:</p>
                    <select class="slct-miara" id="selectChartType">
                        <option value="kolowy">Kołowy</option>
                        <option value="liniowy">Liniowy</option>
                        <option value="slupkowy">Słupkowy</option>
                    </select>
                </div>
                <button class="lekarz-btn" id="generateChart">Generuj wykres</button>
            </div>
            <div class="wykresy">
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
                    data: data,
                }],
            },
            options: {
                responsive: true,
            },
        });
    }
});

</script>

</html>