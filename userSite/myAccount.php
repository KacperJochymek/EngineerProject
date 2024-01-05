<?php
session_start();

if (empty($_SESSION["id"])) {
    header("Location: /index.php"); 
    exit();
}

require '../Logowanie/config.php';

$message = "";

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);

    $email = $row["email"];
}

if (isset($_POST['zmien_haslo_btn'])) {
    $stare_haslo = $_POST['stare_haslo'];
    $nowe_haslo = $_POST['nowe_haslo'];
    $potwierdz_nowe_haslo = $_POST['potwierdz_nowe_haslo'];

    if (empty($stare_haslo) || empty($nowe_haslo) || empty($potwierdz_nowe_haslo)) {
        $message = "Proszę wypełnić wszystkie pola formularza.";
    } elseif ($nowe_haslo !== $potwierdz_nowe_haslo) {
        $message = "Nowe hasło i potwierdzenie nowego hasła nie pasują do siebie.";
    } else {
        $query = "SELECT password FROM users WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $haslo_bazy = $row['password'];

            if (password_verify($stare_haslo, $haslo_bazy)) {
                $haslo_hash = password_hash($nowe_haslo, PASSWORD_BCRYPT);

                $update_query = "UPDATE users SET password = '$haslo_hash' WHERE id = $id";
                $update_result = mysqli_query($conn, $update_query);

                if ($update_result) {
                    $message = "Hasło zostało pomyślnie zmienione.";
                } else {
                    $message = "Błąd podczas aktualizacji hasła: " . mysqli_error($conn) . "";
                }
            } else {
                $message = "Stare hasło jest niepoprawne.";
            }
        } else {
            $message = "Błąd zapytania do bazy danych: " . mysqli_error($conn) . "";
        }
    }
}

if (isset($_POST['usun_tak'])) {

    $delete_query = "DELETE FROM users WHERE id = $id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        session_destroy();

        header("Location: /index.php");
        exit;
    } else {
        $message = "Błąd podczas usuwania konta: " . mysqli_error($conn) . "";
    }
}

if (isset($_POST['tak_oo'])) {
    $wizytaId = $_POST['wizyta_id'];

    $getPacjentIdQuery = "SELECT pacjenci.id FROM pacjenci 
                         JOIN dostepnosc ON pacjenci.id = dostepnosc.id_pacjenta
                         WHERE dostepnosc.id_wizyty = $wizytaId";
    $getPacjentIdResult = mysqli_query($conn, $getPacjentIdQuery);

    if ($getPacjentIdResult) {
        $pacjentRow = mysqli_fetch_assoc($getPacjentIdResult);
        $pacjentId = $pacjentRow['id'];

        $updateWizytaQuery = "UPDATE wizyty SET status_wizyty = 'dostepna' WHERE id = $wizytaId";
        $updateWizytaResult = mysqli_query($conn, $updateWizytaQuery);

        $deleteDostepnoscQuery = "DELETE FROM dostepnosc WHERE id_wizyty = $wizytaId";
        $deleteDostepnoscResult = mysqli_query($conn, $deleteDostepnoscQuery);

        if ($updateWizytaResult && $deleteDostepnoscResult) {
            $message = "Anulowanie wizyty powiodło się.";
        } else {
            $message = "Błąd podczas anulowania: " . mysqli_error($conn) . "";
        }
    } else {
        $message = "Błąd podczas pobierania danych pacjenta: " . mysqli_error($conn) . "";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Moje konto</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="/indexLogged.php"> <img src="/images/medease.png"></a>
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="/images/medease.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/indexLogged.php">Strona główna</a>
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
                    <a href="myAccount.php" class="active2">Moje konto</a>
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

    <div class="myAccountSite">
        <h1>Witamy <?php echo $row["username"]; ?> !</h1>

        <div class="messageSent2"></div>

        <p class="settingi" id="toggleSettings"><i class="fa-solid fa-gears"></i>Ustawienia</p>

        <div class="mojeWizyty-container">
            <div class="mojeWizyty">
                <p class="tekst-wizytyMyAcc">Moje wizyty:</p>


                <?php

                $recordsPerPage = 2;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($currentPage - 1) * $recordsPerPage;


                $sql = "SELECT wizyty.id, wizyty.data_wizyty, wizyty.available_hour, wizyty.doctor_id, wizyty.status_wizyty,
        doctors.imienazwisko, doctors.profesja, doctors.obrazek
        FROM wizyty
        LEFT JOIN dostepnosc ON wizyty.id = dostepnosc.id_wizyty
        LEFT JOIN pacjenci ON dostepnosc.id_pacjenta = pacjenci.id
        LEFT JOIN doctors ON wizyty.doctor_id = doctors.id_lekarza
        WHERE pacjenci.adres_email = '$email' AND wizyty.status_wizyty = 'zarezerwowana'
        LIMIT $recordsPerPage OFFSET $offset";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $counter = 1;

                    while ($row = $result->fetch_assoc()) {
                        $obrazekPath = '/adminSite/uploads/' . $row['obrazek'];

                        echo '<div class="wyswietlanieMyAcc">';
                        echo '<img src="' . $obrazekPath . '" alt="">';
                        echo '<div class="resztaMyAcc">';
                        echo '<p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>' . $row['imienazwisko'] . '</p>';
                        echo '<p class="profesja"> <i class="fa-solid fa-stethoscope"></i>' . $row['profesja'] . '</p>';
                        echo '<p id="selectedDate" class="selected-date">' . $row['data_wizyty'] . '</p>';
                        echo '<p id="selectedHour" class="selected-hour">' . $row['available_hour'] . '</p>';
                        echo '</div>';
                        echo '<button class="myAccBtn" onclick="pokazDiv(' . $counter . ')">Anuluj</button>';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="wizyta_id" value="' . $row['id'] . '">';
                        echo '<div class="ukrytyDiv" id="ukrytyDiv' . $counter . '" style="display:none;">';
                        echo '<p>Czy na pewno? </p>';
                        echo '<button name="tak_oo" id="tak_oo">Tak</button>';
                        echo '<button onclick="schowajDiv(' . $counter . ')">Nie</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';

                        $counter++;
                    }

                    $totalRecordsQuery = "SELECT COUNT(*) as total FROM wizyty
                         LEFT JOIN dostepnosc ON wizyty.id = dostepnosc.id_wizyty
                         LEFT JOIN pacjenci ON dostepnosc.id_pacjenta = pacjenci.id
                         WHERE pacjenci.adres_email = '$email' AND wizyty.status_wizyty = 'zarezerwowana'";
                    $totalRecordsResult = $conn->query($totalRecordsQuery);
                    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = ($i == $currentPage) ? 'active' : '';
                        echo '<a class="' . $activeClass . '" href="?page=' . $i . '">' . $i . '</a>';
                    }
                    echo '</div>';
                } else {
                    echo "Brak dostępnych rekordów w bazie danych.";
                }

                $conn->close();
                ?>

                <script>
                    function pokazDiv(nr) {
                        var div = document.getElementById('ukrytyDiv' + nr);
                        div.style.display = 'block';
                    }

                    function schowajDiv(nr) {
                        var div = document.getElementById('ukrytyDiv' + nr);
                        div.style.display = 'none';
                    }
                </script>

            </div>

            <div class="settings-inpt">
                <p p class="tekst-wizytyMyAcc2">Zmień hasło lub usuń konto.</p>
                <div class="changePass">
                    <form method="post">
                        <div class="input-cntiner">
                            <input class="haslo" type="password" name="stare_haslo" placeholder="Stare hasło">
                            <input class="haslo" type="password" name="nowe_haslo" placeholder="Nowe hasło">
                            <input class="haslo" type="password" name="potwierdz_nowe_haslo" placeholder="Potwierdź nowe hasło">
                        </div>
                        <button class="filtruj" type="submit" name="zmien_haslo_btn">Zmień hasło</button>
                    </form>
                    <button class="filtruj" type="submit" id="pokazDiv">Usuń konto</button>
                    <form method="post">
                        <div class="czy-napewno" style="display: none;">
                            <p>Czy napewno chcesz usunąć konto?</p>
                            <button type="submit" name="usun_tak" id="usun_tak">Tak</button>
                            <button type="submit" name="usun_nie" id="usun_nie">Nie</button>
                        </div>
                    </form>
                    <script>
                        document.getElementById('pokazDiv').addEventListener('click', function() {
                            document.querySelector('.czy-napewno').style.display = 'block';
                        });

                        document.getElementById('usunNie').addEventListener('click', function() {
                            document.querySelector('.czy-napewno').style.display = 'none';
                        });
                    </script>

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
                    <li><a href="/userSite/myAccount.php">Moje konto</a></li>
                    <li><a href="/userSite/analizeForm.php">Ankieta</a></li>
                    <li><a href="/userSite/contact.php">Kontakt</a></li>
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

<script src="/script1.js"></script>
<script src="/userSite/test.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var messageDiv = document.querySelector('.messageSent2');
        messageDiv.innerHTML = "<?php echo $message; ?>";
    });
</script>

</html>