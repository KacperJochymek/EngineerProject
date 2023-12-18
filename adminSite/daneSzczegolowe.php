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
            <img src="/images/medease_admin.png">
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
        <a href="/adminSite/daneAnkieta.php">
            <i class="fa-regular fa-circle-left"></i>
        </a>
    </div>
    <p class="lekarz-wybierz2">Analiza danych szczegółowych ankietowanych</p>

    <div class="daneSzczegolowe">

        <div class="ankieta-cd">
            <p>Dane z ankiety:</p>
        </div>

        <div class="ankietaDaneWyniki">
            <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vR-TRX2QUSvbUxH3qDZsFl_G3IrnE89WzXp9s-9pqdNp93FaQFTZQ-Ia3e41e5lJmta9fkIao7TPIUy/pubhtml?widget=true&amp;headers=false"></iframe>
        </div>

        <p class="tekst-dataWykresy2">Obliczenia dla danej grupy wiekowej:</p>

        <div class="paczka">
            <div class="daneSzczegoloweContainer">
                <input type="hidden" name="formType" value="age">
                <div class="slct-wrapper">
                    <p>Wybierz wiek:</p>
                    <select name="selectedAgeGroup" id="selectedAgeGroup" class="slct-miara">
                        <option value="brak">Brak</option>
                        <option value="0-18">0-18</option>
                        <option value="19-35">19-35</option>
                        <option value="36-55">36-55</option>
                        <option value="55+">55+</option>
                    </select>
                </div>

                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="selectedColumn" id="selectedColumn" class="slct-miara">
                        <option value="brak">Brak</option>
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
                    <select name="selectedMethod" id="selectedMethod" class="slct-miara">
                        <option value="brak">Brak</option>
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
                <button type="submit" name="submit" id="calculateButton" class="lekarz-btn">Oblicz</button>
            </div>

            <div class="wykresyContent">
                <div class="wykresy-wynik">
                    <p id="result"> </p>
                </div>
                <div class="wykresy-szczegolowe">
                    <div id="tableContainer"></div>
                </div>
            </div>
        </div>

        <!-- Obliczenia dla płci -->

        <p class="tekst-dataWykresy2">Obliczenia dla danej płci:</p>

        <div class="paczka">
            <div class="daneSzczegoloweContainer">
                <input type="hidden" name="formType" value="sex">
                <div class="slct-wrapper">
                    <p>Wybierz płeć:</p>
                    <select name="selectedSex" id="selectedSex" class="slct-miara">
                        <option value="brak">Brak</option>
                        <option value="Kobieta">Kobieta</option>
                        <option value="Mezczyzna">Mężczyzna</option>
                    </select>
                </div>

                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="selectedColumn2" id="selectedColumn2" class="slct-miara">
                        <option value="brak">Brak</option>
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
                    <select name="selectedMethod2" id="selectedMethod2" class="slct-miara">
                        <option value="brak">Brak</option>
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
                <button type="submit" name="submit2" id="calculateButton2" class="lekarz-btn">Oblicz</button>
            </div>

            <!-- Naprawić wyświetlanie tabeli, lub dodać paginacje -->

            <div class="wykresyContent">
                <div class="wykresy-wynik">
                    <p id="result2"></p>
                </div>
                <div class="wykresy-szczegolowe">
                    <div id="tableContainer2"></div>
                </div>
            </div>
        </div>
        <!-- Obliczenia dla specjalisty -->

        <p class="tekst-dataWykresy2">Obliczenia dla danego specjalisty:</p>

        <div class="paczka">
            <div class="daneSzczegoloweContainer">
                <input type="hidden" name="formType" value="specialist">
                <div class="slct-wrapper">
                    <p>Wybierz specjalistę:</p>
                    <select name="selectedSpecialist" id="selectedSpecialist" class="slct-miara">
                        <!-- Tutaj dodać wczytywanie z pliku, ustawić na konkretna kolumne -->
                        <option value="brak">Brak</option>
                        <option value="Onkolog">Onkolog</option>
                        <option value="Podolog">Podolog</option>
                    </select>
                </div>

                <div class="slct-wrapper">
                    <p>Wybierz wartość:</p>
                    <select name="selectedColumn" id="selectedColumn3" class="slct-miara">
                        <option value="brak">Brak</option>
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
                    <select name="selectedMethod" id="selectedMethod3" class="slct-miara">
                        <option value="brak">Brak</option>
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
                <button type="submit" name="submit3" id="calculateButton3" class="lekarz-btn">Oblicz</button>
            </div>

            <div class="wykresyContent">
                <div class="wykresy-wynik">
                    <p id="result3"> </p>
                </div>
                <div class="wykresy-szczegolowe">
                    <div id="tableContainer3"></div>
                </div>
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

<!-- Oliczenia dla wybranej grupy wiekowej -->

<script>
    document.getElementById("calculateButton").addEventListener("click", function() {
        var selectedAgeGroupElement = document.getElementById("selectedAgeGroup");
        var selectedColumnElement = document.getElementById("selectedColumn");
        var selectedMethodElement = document.getElementById("selectedMethod");

        if (!selectedAgeGroupElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedAgeGroup = selectedAgeGroupElement.value;
        var selectedColumn = selectedColumnElement.value;
        var selectedMethod = selectedMethodElement.value;

        // Pobieranie danych z pliku CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn);

                // Filtrowanie danych 
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[2].trim() === selectedAgeGroup;
                });

                if (filteredData.length > 0) {
                    var values = filteredData.map(function(row) {
                        var rowData = row.split(',');
                        return parseFloat(rowData[selectedColumnIndex]);
                    });

                    var result = null;

                    // Obliczenia w zależności od wyboru
                    if (selectedMethod === "srednia") {
                        result = (values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod === "odchylenie-std") {
                        var mean = values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length;
                        result = Math.sqrt(values.reduce(function(sum, value) {
                            return sum + Math.pow(value - mean, 2);
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod === "mediana") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var middle = Math.floor(sortedValues.length / 2);
                        result = (sortedValues.length % 2 === 0 ?
                            (sortedValues[middle - 1] + sortedValues[middle]) / 2 :
                            sortedValues[middle]).toFixed(2);
                    } else if (selectedMethod === "moda") {
                        var countValues = values.reduce(function(count, value) {
                            count[value] = (count[value] || 0) + 1;
                            return count;
                        }, {});

                        var maxCount = Math.max.apply(null, Object.values(countValues));

                        // Znajdź wszystkie mody, które mogą mieć więcej wystąpień
                        var modes = Object.keys(countValues).filter(function(key) {
                            return countValues[key] === maxCount;
                        });

                        // Sprawdź, czy jest więcej niż jedna moda
                        if (modes.length > 1) {
                            result = modes.map(function(mode) {
                                return mode + ".00";
                            }).join(", ");
                        } else {
                            result = modes[0] + ".00";
                        }
                    } else if (selectedMethod === "minimum") {
                        result = Math.min.apply(null, values).toFixed(2);
                    } else if (selectedMethod === "maksimum") {
                        result = Math.max.apply(null, values).toFixed(2);
                    } else if (selectedMethod === "kwartyl1") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod === "kwartyl3") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(3 * sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod === "iqr") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var q1 = sortedValues[Math.floor(sortedValues.length / 4)];
                        var q3 = sortedValues[Math.floor(3 * sortedValues.length / 4)];
                        result = (q3 - q1).toFixed(2);
                    }

                    // Wyświetlanie wyniku
                    var resultElement = document.getElementById("result");
                    resultElement.textContent = "Uśredniony wynik: " + result;
                } else {
                    console.error('Brak danych dla wybranego przedziału wiekowego.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>
<script>
    document.getElementById("calculateButton").addEventListener("click", function() {
        var selectedAgeGroupElement = document.getElementById("selectedAgeGroup");
        var selectedColumnElement = document.getElementById("selectedColumn");
        var selectedMethodElement = document.getElementById("selectedMethod");

        if (!selectedAgeGroupElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedAgeGroup = selectedAgeGroupElement.value;
        var selectedColumn = selectedColumnElement.value;
        var selectedMethod = selectedMethodElement.value;

        // Pobieranie danych z CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn);

                // Filtrowanie danych na podstawie wyboru
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[2].trim() === selectedAgeGroup;
                });

                if (filteredData.length > 0) {
                    // Generowanie tabeli na podstawie wyboru admina
                    var tableHtml = '<div class="tble-hpracy">';
                    tableHtml += '<table>';
                    tableHtml += '<thead>';
                    tableHtml += '<tr>';
                    tableHtml += '<th>Przedział wieku</th>';
                    tableHtml += '<th>Płeć</th>';
                    tableHtml += '<th>Profesja</th>';
                    tableHtml += '<th>Ocena</th>';
                    tableHtml += '<th>Obsługa</th>';
                    tableHtml += '<th>Satysfakcja</th>';
                    tableHtml += '<th>Dostępność</th>';
                    tableHtml += '<th>Polecenie</th>';
                    tableHtml += '</tr>';
                    tableHtml += '</thead>';
                    tableHtml += '<tbody>';
                    for (var j = 0; j < filteredData.length; j++) {
                        var rowData = filteredData[j].split(',');
                        tableHtml += '<tr>';
                        for (var k = 2; k < 10; k++) {
                            tableHtml += '<td>' + rowData[k] + '</td>';
                        }
                        tableHtml += '</tr>';
                    }
                    tableHtml += '</tbody>';
                    tableHtml += '</table>';
                    tableHtml += '</div>';

                    // Wyświetl tabelę
                    var tableContainer = document.getElementById("tableContainer");
                    tableContainer.innerHTML = tableHtml;
                } else {
                    console.error('Brak danych dla wybranego przedziału wiekowego.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>

<!-- Obliczenia dla wybranej płci -->

<script>
    document.getElementById("calculateButton2").addEventListener("click", function() {
        var selectedSexElement = document.getElementById("selectedSex");
        var selectedColumnElement = document.getElementById("selectedColumn2");
        var selectedMethodElement = document.getElementById("selectedMethod2");

        if (!selectedSexElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedSex = selectedSexElement.value;
        var selectedColumn2 = selectedColumnElement.value;
        var selectedMethod2 = selectedMethodElement.value;

        // Pobieranie danych z CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn2);

                // Filtrowanie danych dla wybranej płci
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[3].trim() === selectedSex;
                });

                if (filteredData.length > 0) {
                    var values = filteredData.map(function(row) {
                        var rowData = row.split(',');
                        return parseFloat(rowData[selectedColumnIndex]);
                    });

                    var result = null;

                    // Obliczenia w zależności od wybranej miary
                    if (selectedMethod2 === "srednia") {
                        result = (values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod2 === "odchylenie-std") {
                        var mean = values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length;
                        result = Math.sqrt(values.reduce(function(sum, value) {
                            return sum + Math.pow(value - mean, 2);
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod2 === "mediana") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var middle = Math.floor(sortedValues.length / 2);
                        result = (sortedValues.length % 2 === 0 ?
                            (sortedValues[middle - 1] + sortedValues[middle]) / 2 :
                            sortedValues[middle]).toFixed(2);
                    } else if (selectedMethod2 === "moda") {
                        var countValues = values.reduce(function(count, value) {
                            count[value] = (count[value] || 0) + 1;
                            return count;
                        }, {});

                        var maxCount = Math.max.apply(null, Object.values(countValues));

                        // Znajdź wszystkie mody
                        var modes = Object.keys(countValues).filter(function(key) {
                            return countValues[key] === maxCount;
                        });

                        // Sprawdź, czy jest więcej niż jedna moda
                        if (modes.length > 1) {
                            result = modes.map(function(mode) {
                                return mode + ".00";
                            }).join(", ");
                        } else {
                            result = modes[0] + ".00";
                        }
                    } else if (selectedMethod2 === "minimum") {
                        result = Math.min.apply(null, values).toFixed(2);
                    } else if (selectedMethod2 === "maksimum") {
                        result = Math.max.apply(null, values).toFixed(2);
                    } else if (selectedMethod2 === "kwartyl1") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod2 === "kwartyl3") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(3 * sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod2 === "iqr") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var q1 = sortedValues[Math.floor(sortedValues.length / 4)];
                        var q3 = sortedValues[Math.floor(3 * sortedValues.length / 4)];
                        result = (q3 - q1).toFixed(2);
                    }

                    // Wyświetlanie wyniku
                    var resultElement = document.getElementById("result2");
                    resultElement.textContent = "Uśredniony wynik: " + result;
                } else {
                    console.error('Brak danych dla wybranego przedziału wiekowego.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>
<script>
    document.getElementById("calculateButton2").addEventListener("click", function() {
        var selectedSexElement = document.getElementById("selectedSex");
        var selectedColumnElement = document.getElementById("selectedColumn2");
        var selectedMethodElement = document.getElementById("selectedMethod2");

        if (!selectedSexElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedSex = selectedSexElement.value;
        var selectedColumn2 = selectedColumnElement.value;
        var selectedMethod2 = selectedMethodElement.value;

        // Pobieranie danych z pliku CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn2);

                // Filtrowanie danych na podstawie wyboru admina
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[3].trim() === selectedSex;
                });

                if (filteredData.length > 0) {
                    // Generowanie tabelu na podstawie wyboru
                    var tableHtml = '<div class="tble-hpracy">';
                    tableHtml += '<table>';
                    tableHtml += '<thead>';
                    tableHtml += '<tr>';
                    tableHtml += '<th>Przedział wieku</th>';
                    tableHtml += '<th>Płeć</th>';
                    tableHtml += '<th>Profesja</th>';
                    tableHtml += '<th>Ocena</th>';
                    tableHtml += '<th>Obsługa</th>';
                    tableHtml += '<th>Satysfakcja</th>';
                    tableHtml += '<th>Dostępność</th>';
                    tableHtml += '<th>Polecenie</th>';
                    tableHtml += '</tr>';
                    tableHtml += '</thead>';
                    tableHtml += '<tbody>';
                    for (var j = 0; j < filteredData.length; j++) {
                        var rowData = filteredData[j].split(',');
                        tableHtml += '<tr>';
                        for (var k = 2; k < 10; k++) {
                            tableHtml += '<td>' + rowData[k] + '</td>';
                        }
                        tableHtml += '</tr>';
                    }
                    tableHtml += '</tbody>';
                    tableHtml += '</table>';
                    tableHtml += '</div>';

                    // Wyświetlanie tabeli
                    var tableContainer = document.getElementById("tableContainer2");
                    tableContainer.innerHTML = tableHtml;
                } else {
                    console.error('Brak danych dla wybranej płci.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>

<!-- Obliczenia dla wybranego specjalisty -->

<script>
    document.getElementById("calculateButton3").addEventListener("click", function() {
        var selectedSpecialistElement = document.getElementById("selectedSpecialist");
        var selectedColumnElement = document.getElementById("selectedColumn3");
        var selectedMethodElement = document.getElementById("selectedMethod3");

        if (!selectedSpecialistElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedSpecialist = selectedSpecialistElement.value;
        var selectedColumn3 = selectedColumnElement.value;
        var selectedMethod3 = selectedMethodElement.value;

        // Pobieranie danych z pliku CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn3);

                // Filtrowanie danych dla wybranego specjalisty
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[4].trim() === selectedSpecialist;
                });

                if (filteredData.length > 0) {
                    var values = filteredData.map(function(row) {
                        var rowData = row.split(',');
                        return parseFloat(rowData[selectedColumnIndex]);
                    });

                    var result = null;

                    // Obliczenia w zależności od wybranej miary
                    if (selectedMethod3 === "srednia") {
                        result = (values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod3 === "odchylenie-std") {
                        var mean = values.reduce(function(sum, value) {
                            return sum + value;
                        }, 0) / values.length;
                        result = Math.sqrt(values.reduce(function(sum, value) {
                            return sum + Math.pow(value - mean, 2);
                        }, 0) / values.length).toFixed(2);
                    } else if (selectedMethod3 === "mediana") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var middle = Math.floor(sortedValues.length / 2);
                        result = (sortedValues.length % 2 === 0 ?
                            (sortedValues[middle - 1] + sortedValues[middle]) / 2 :
                            sortedValues[middle]).toFixed(2);
                    } else if (selectedMethod3 === "moda") {
                        var countValues = values.reduce(function(count, value) {
                            count[value] = (count[value] || 0) + 1;
                            return count;
                        }, {});

                        var maxCount = Math.max.apply(null, Object.values(countValues));

                        // Znajdź wszystkie mody
                        var modes = Object.keys(countValues).filter(function(key) {
                            return countValues[key] === maxCount;
                        });

                        // Sprawdź, czy jest więcej niż jedna moda
                        if (modes.length > 1) {
                            result = modes.map(function(mode) {
                                return mode + ".00";
                            }).join(", ");
                        } else {
                            result = modes[0] + ".00";
                        }
                    } else if (selectedMethod3 === "minimum") {
                        result = Math.min.apply(null, values).toFixed(2);
                    } else if (selectedMethod3 === "maksimum") {
                        result = Math.max.apply(null, values).toFixed(2);
                    } else if (selectedMethod3 === "kwartyl1") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod3 === "kwartyl3") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        result = sortedValues[Math.floor(3 * sortedValues.length / 4)].toFixed(2);
                    } else if (selectedMethod3 === "iqr") {
                        var sortedValues = values.slice().sort(function(a, b) {
                            return a - b;
                        });
                        var q1 = sortedValues[Math.floor(sortedValues.length / 4)];
                        var q3 = sortedValues[Math.floor(3 * sortedValues.length / 4)];
                        result = (q3 - q1).toFixed(2);
                    }

                    // Wyświetlanie wyniku
                    var resultElement = document.getElementById("result3");
                    resultElement.textContent = "Uśredniony wynik: " + result;
                } else {
                    console.error('Brak danych dla wybranego przedziału wiekowego.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>
<script>
    document.getElementById("calculateButton3").addEventListener("click", function() {
        var selectedSpecialistElement = document.getElementById("selectedSpecialist");
        var selectedColumnElement = document.getElementById("selectedColumn3");
        var selectedMethodElement = document.getElementById("selectedMethod3");

        if (!selectedSpecialistElement || !selectedColumnElement || !selectedMethodElement) {
            console.error("Nie można odnaleźć wszystkich elementów.");
            return;
        }

        var selectedSpecialist = selectedSpecialistElement.value;
        var selectedColumn3 = selectedColumnElement.value;
        var selectedMethod3 = selectedMethodElement.value;

        // Pobieranie dane z pliku CSV
        fetch('../analiza_danych2.csv')
            .then(response => response.text())
            .then(csvData => {
                var rows = csvData.split('\n');
                var header = rows[0].split(',');
                var selectedColumnIndex = header.indexOf(selectedColumn3);

                // Filtruj dane dla wybranego specjalisty
                var filteredData = rows.slice(1).filter(function(row) {
                    var rowData = row.split(',');
                    return rowData[4].trim() === selectedSpecialist;
                });

                if (filteredData.length > 0) {
                    // Generowanie tabeli na podstawie wyboru admina
                    var tableHtml = '<div class="tble-hpracy">';
                    tableHtml += '<table>';
                    tableHtml += '<thead>';
                    tableHtml += '<tr>';
                    tableHtml += '<th>Przedział wieku</th>';
                    tableHtml += '<th>Płeć</th>';
                    tableHtml += '<th>Profesja</th>';
                    tableHtml += '<th>Ocena</th>';
                    tableHtml += '<th>Obsługa</th>';
                    tableHtml += '<th>Satysfakcja</th>';
                    tableHtml += '<th>Dostępność</th>';
                    tableHtml += '<th>Polecenie</th>';
                    tableHtml += '</tr>';
                    tableHtml += '</thead>';
                    tableHtml += '<tbody>';
                    for (var j = 0; j < filteredData.length; j++) {
                        var rowData = filteredData[j].split(',');
                        tableHtml += '<tr>';
                        for (var k = 2; k < 10; k++) {
                            tableHtml += '<td>' + rowData[k] + '</td>';
                        }
                        tableHtml += '</tr>';
                    }
                    tableHtml += '</tbody>';
                    tableHtml += '</table>';
                    tableHtml += '</div>';

                    // Wyświetlanie tabeli
                    var tableContainer = document.getElementById("tableContainer3");
                    tableContainer.innerHTML = tableHtml;
                } else {
                    console.error('Brak danych dla wybranej płci.');
                }
            })
            .catch(error => {
                console.error('Wystąpił błąd podczas pobierania lub przetwarzania danych:', error);
            });
    });
</script>

</html>