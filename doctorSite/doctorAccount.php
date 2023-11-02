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
                    <a href="/index.php">Strona Główna</a>
                </li>
                <li>
                    <a href="/userSite/lekarze.php">Lekarze</a>
                </li>
                <li>
                    <a href="/userSite/cennik.php">Cennik</a>
                </li>
                <li>
                    <a href="/userSite/blog.php">Aktualności</a>
                </li>
                <li>
                    <a href="/userSite/contact.php">Kontakt</a>
                </li>
                <li>
                    <a href="/doctorSite/doctorAccount.php">Moje Konto</a>
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

    <p class="lekarz-wybierz">Dodaj godziny pracy:</p>

    <div class="doctorAccDiv">

        <?php
        require '../Logowanie/config.php';

        if (isset($_POST["add_hour"])) {
            $id_lekarza = $_POST["id_lekarza"];
            $data_wizyty = $_POST["data_wizyty"];
            $available_hour = $_POST["available_hour"];
            $id_pacjenta = null; 
            $status = 'Oczekujący'; 

            // Sprawdzenie, czy wizyta już istnieje
            $check_sql = "SELECT id FROM wizyty WHERE id_lekarza = ? AND data_wizyty = ? AND available_hour = ?";
            $check_stmt = $conn->prepare($check_sql);

            if ($check_stmt) {
                $check_stmt->bind_param("sss", $id_lekarza, $data_wizyty, $available_hour);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {
                    echo '<script>alert("Wizyta o tej godzinie już istnieje.");</script>';
                } else {
                    // Dodawanie nowej wizyty
                    $sql = "INSERT INTO wizyty (id_lekarza, data_wizyty, available_hour, id_pacjenta, status) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param("sssss", $id_lekarza, $data_wizyty, $available_hour, $id_pacjenta, $status);

                        if ($stmt->execute()) {
                            echo '<script>alert("Wizyta dodana pomyślnie");</script>';
                        } else {
                            echo '<script>alert("Błąd: ' . $stmt->error . '");</script>';
                        }
                        $stmt->close();
                    } else {
                        echo '<script>alert("Błąd przy przygotowywaniu zapytania.");</script>';
                    }
                }

                $check_stmt->close();
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data" class="doctor-form">
            <div class="add-inpt">
                <input type="number" name="id_lekarza" id="id_lekarza" placeholder="Podaj id lekarza"><br>
                <input type="date" name="data_wizyty" id="data_wizyty">
                <input type="time" name="available_hour" id="available_hour" placeholder="Wybierz godzinę"><br>
                <input type="submit" class="lekarz-btn" name="add_hour" value="Dodaj">
            </div>
        </form>


        <p class="lekarz-wybierz">Podgląd wizyt:</p>

        <?php

        require '../Logowanie/config.php';

        $sql = "SELECT * FROM wizyty";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="tble-cennik">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>id</th>';
            echo '<th>Data</th>';
            echo '<th>Dostępne godziny</th>';
            echo '<th>id_lekarza</th>';
            echo '<th>id_pacjenta</th>';
            echo '<th>status</th>';
            echo '<th>Akcje</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["data_wizyty"] . '</td>';
                echo '<td>' . $row["available_hour"] . '</td>';
                echo '<td>' . $row["doctor_id"] . '</td>';
                echo '<td>' . $row["id_pacjenta"] . '</td>';
                echo '<td>' . $row["status"] . '</td>';
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<button type="submit" class="edit-btn" name="edit-btn">Aktualizuj</button>';
                echo '<button type="submit" class="delete-btn" name="delete-btn">Usuń</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
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

</html>