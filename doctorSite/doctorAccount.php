<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: /index.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] !== "doctor") {
    header('Location: ../userSite/noPermission.php');
    session_destroy();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Wizyty</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
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
                    <a href="/doctorSite/doctorAccount.php" class="active2">Godziny pracy</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorVisitCount.php">Wizyty</a>
                </li>
                <li>
                    <a href="/userSite/contact.php">Kontakt</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorFirstSite.php">Moje konto</a>
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

    <p class="lekarz-wybierz">Dodaj godziny pracy lekarza:</p>

    <div class="messageSent"></div>

    <div class="doctorAccDiv">

        <?php
        require '../Logowanie/config.php';

        if (isset($_POST["add_hour"])) {
            $doctor_id = $_POST["doctor_id"];
            $data_wizyty = $_POST["data_wizyty"];
            $available_hour = $_POST["available_hour"];
            $status_wizyty = 'dostepna';

            // Czy wizyta już istnieje w bazie
            $check_sql = "SELECT id FROM wizyty WHERE doctor_id = ? AND data_wizyty = ? AND available_hour = ?";
            $check_stmt = $conn->prepare($check_sql);

            if ($check_stmt) {
                $check_stmt->bind_param("sss", $doctor_id, $data_wizyty, $available_hour);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    echo '<div class="messageSent">Wizyta o tej godzinie już istnieje.</div>';
                } else {

                    // Dodawanie nowej wizyty do bazy
                    $sql = "INSERT INTO wizyty (doctor_id, data_wizyty, available_hour, status_wizyty) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("ssss", $doctor_id, $data_wizyty, $available_hour, $status_wizyty);

                        if ($stmt->execute()) {
                            echo '<div class="messageSent">Wizyta dodana pomyślnie.</div>';
                        } else {
                            echo '<div class="messageSent">Błąd: ' . $stmt->error . '</div>';
                        }
                        $stmt->close();
                    } else {
                        echo '<div class="messageSent">Błąd przy przygotowywaniu zapytania.</div>';
                    }
                }

                $check_stmt->close();
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data" class="doctor-form">
            <div class="add-inpt">

                <select name="doctor_id" id="doctor_id" class="wybor_lekarza">
                    <?php

                    $doctor_query = "SELECT id_lekarza FROM doctors";
                    $doctor_result = $conn->query($doctor_query);

                    if (!$doctor_result) {
                        die("Błąd: " . $conn->error);
                    }


                    while ($row = $doctor_result->fetch_assoc()) {
                        echo "<option value='" . $row['id_lekarza'] . "'>" . $row['id_lekarza'] . "</option>";
                    }
                    ?>
                </select>
                <input type="date" name="data_wizyty" class="id_leka2" id="data_wizyty">
                <input type="time" name="available_hour" id="available_hour" class="id_leka3" placeholder="Wybierz godzinę"><br>
                <input type="submit" class="lekarz-btn" name="add_hour" value="Dodaj">
            </div>
        </form>


        <p class="lekarz-wybierz">Podgląd lekarzy:</p>

        <?php

        $itemsPerPage = 3;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM doctors LIMIT $itemsPerPage OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="tble-hpracy">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Lp.</th>';
            echo '<th>Tytuł</th>';
            echo '<th>Imię i nazwisko</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id_lekarza'] . '</td>';
                echo '<td>' . $row['tytul'] . '</td>';
                echo ' <td>' . $row['imienazwisko'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            $sqlCount = "SELECT COUNT(*) AS total FROM doctors";
            $resultCount = $conn->query($sqlCount);
            $rowCount = $resultCount->fetch_assoc()['total'];
            $totalPages = ceil($rowCount / $itemsPerPage);

            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $active_class = ($i == $page) ? 'active' : '';
                echo '<a class="' . $active_class . '" href="addingPrice.php?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
        } else {
            echo '<div class="blog_brakdan">';
            echo "Brak danych do wyświetlenia.";
            echo '<a href="addingPrice.php?page=1"><i class="fa-solid fa-circle-arrow-left"></i></a>';
            echo '</div>';
        }

        $conn->close();
        ?>
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
                    <li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>
                    <li><a href="/userSite/analizeForm.php">Ankieta</a></li>
                    <li><a href="/userSite/lekarze.php">Lekarze</a></li>
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
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('.doctor-form');

        form.addEventListener('submit', function(event) {
            var doctorIdInput = document.getElementById('doctor_id');
            if (!validateNumber(doctorIdInput.value)) {
                displayErrorMessage('Pole "id lekarza" musi zawierać liczby całkowite dodatnie.');
                event.preventDefault();
                return false;
            }

            var dataWizytyInput = document.getElementById('data_wizyty');
            if (!validateDate(dataWizytyInput.value)) {
                displayErrorMessage('Musisz wybrać datę.');
                event.preventDefault();
                return false;
            }

            var availableHourInput = document.getElementById('available_hour');
            if (!validateTime(availableHourInput.value)) {
                displayErrorMessage('Musisz wybrać godzinę.');
                event.preventDefault();
                return false;
            }

            clearErrorMessage();
            return true;
        });

        function displayErrorMessage(message) {
            var messageSent = document.querySelector('.messageSent');
            messageSent.innerHTML = message;
        }

        function clearErrorMessage() {
            var messageSent = document.querySelector('.messageSent');
            messageSent.innerHTML = '';
        }

        function validateNumber(number) {
            var regex = /^[0-9]+$/;
            return regex.test(number);
        }

        function validateDate(date) {
            var regex = /^\d{4}-\d{2}-\d{2}$/;
            return regex.test(date);
        }

        function validateTime(time) {
            var regex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            return regex.test(time);
        }
    });
</script>


</html>