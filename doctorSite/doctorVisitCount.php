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

require '../Logowanie/config.php';

if (isset($_POST['filter-btn'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $doctor_id = isset($_POST['doctor_id']) ? $conn->real_escape_string($_POST['doctor_id']) : null;

    $sql = "SELECT wizyty.id, wizyty.data_wizyty, wizyty.available_hour, wizyty.doctor_id, 
            pacjenci.id_pacjenta, wizyty.status_wizyty 
            FROM wizyty
            LEFT JOIN dostepnosc ON wizyty.id = dostepnosc.id_wizyty
            LEFT JOIN pacjenci ON dostepnosc.id_pacjenta = pacjenci.id
            WHERE wizyty.data_wizyty BETWEEN '$start_date' AND '$end_date'";

    if (!is_null($doctor_id)) {
        $sql .= " AND wizyty.doctor_id = '$doctor_id'";
    }
} else {
    $sql = "SELECT wizyty.id, wizyty.data_wizyty, wizyty.available_hour, wizyty.doctor_id, 
            pacjenci.id_pacjenta, wizyty.status_wizyty 
            FROM wizyty
            LEFT JOIN dostepnosc ON wizyty.id = dostepnosc.id_wizyty
            LEFT JOIN pacjenci ON dostepnosc.id_pacjenta = pacjenci.id";
}

$countQuery = "SELECT COUNT(*) as total FROM ($sql) as countTable";
$countResult = $conn->query($countQuery);
$countRow = $countResult->fetch_assoc();
$totalRecords = $countRow['total'];

$records_per_page = 4;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;
$sql .= " LIMIT $offset, $records_per_page";

$result = $conn->query($sql);

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
            <img src="/images/medease_doctor.png">
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
                    <a href="/doctorSite/doctorAccount.php">Godziny pracy</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorVisitCount.php" class="active2">Wizyty</a>
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

    <div class="accountAdminLook">

        <p class="lekarz-wybierz">Podgląd wizyt:</p>

        <div class="lookUsers">
            <form method="post" class="lookVis">
                <div class="slct-wrapper">
                    <p>Wybierz lekarza:</p>
                    <select name="doctor_id" id="doctor_id" class="wybor_lekarza">
                        <?php
                        $doctor_query = "SELECT imienazwisko FROM doctors";
                        $doctor_result = $conn->query($doctor_query);

                        if (!$doctor_result) {
                            die("Błąd: " . $conn->error);
                        }

                        while ($row = $doctor_result->fetch_assoc()) {
                            echo "<option value='" . $row['imienazwisko'] . "'>" . $row['imienazwisko'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="slct-wrapper">
                    <p>Od:</p>
                    <input type="date" name="start_date" placeholder="Data początkowa">
                </div>
                <div class="slct-wrapper">
                    <p>Do:</p>
                    <input type="date" name="end_date" placeholder="Data końcowa">
                </div>
                <button type="submit" class="filtruj" name="filter-btn">Filtruj</button>
            </form>


            <div class="validationMessage">
                <?php
                require '../adminSite/configs/wizyty-config.php';
                echo $message; ?>
            </div>

            <div class="vtableUsers">
                <?php

                require '../adminSite/configs/wizyty-config.php';

                if ($result->num_rows > 0) {
                    echo '<div class="tble-cennik">';
                    echo '<table>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Data</th>';
                    echo '<th>Godzina</th>';
                    echo '<th>Lekarz</th>';
                    echo '<th>Pacjent</th>';
                    echo '<th>Status</th>';
                    echo '<th>Akcje</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    $counter = 1;

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row["data_wizyty"] . '</td>';
                        echo '<td>' . $row["available_hour"] . '</td>';
                        echo '<td>' . $row["doctor_id"] . '</td>';
                        echo '<td>' . $row["id_pacjenta"] . '</td>';
                        echo '<td>' . $row["status_wizyty"] . '</td>';
                        echo '</td>';
                        echo '<td>';
                        echo '<button type="submit" class="edit-btn" name="anuluj_wizyte">Anuluj</button>';
                        echo '<form method="post">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<div class="ukrytyDiv" id="ukrytyDiv' . $counter . '" style="display:none;">';
                        echo '<p>Czy na pewno? </p>';
                        echo '<button name="tak_oo" id="tak_oo">Tak</button>';
                        echo '<button onclick="schowajDiv(' . $counter . ')">Nie</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';

                        $counter++;
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

            <?php
            echo '<div class="pagination">';
            for ($i = 1; $i <= ceil($totalRecords / $records_per_page); $i++) {
                $active_class = ($i == $page) ? 'active' : '';
                echo '<a class="' . $active_class . '" href="?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
            ?>

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
    function pokazDiv(nr) {
        var div = document.getElementById('ukrytyDiv' + nr);
        div.style.display = 'block';
    }

    function schowajDiv(nr) {
        var div = document.getElementById('ukrytyDiv' + nr);
        div.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.edit-btn');

        deleteButtons.forEach(function(button, index) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                pokazDiv(index + 1);
            });
        });
    });
</script>

</html>