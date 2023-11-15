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
    <title>Dodaj lekarza</title>
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

    <p class="lekarz-wybierz">Formularz dodawania lekarza do systemu</p>

    <div class="lekarzeDatabase">
        <?php

        require '../Logowanie/config.php';

        if (isset($_POST["signup_submit"])) {
            $tytul = $_POST["tytul"];
            $imienazwisko = $_POST["imienazwisko"];
            $profesja = $_POST["profesja"];

            $obrazek_name = $_FILES["obrazek"]["name"];
            $obrazek_temp = $_FILES["obrazek"]["tmp_name"];
            $obrazek_type = $_FILES["obrazek"]["type"];

            if (substr($obrazek_type, 0, 5) === "image") {

                move_uploaded_file($obrazek_temp, "uploads/" . $obrazek_name);

                if ($conn->connect_error) {
                    die("Błąd połączenia: " . $conn->connect_error);
                }

                $sql = "INSERT INTO doctors (tytul, imienazwisko, profesja, obrazek) VALUES ('$tytul', '$imienazwisko', '$profesja', '$obrazek_name')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div class="messageSent">Dane dodane poprawnie!</div>';
                } else {
                    echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
                }
                $conn->close();
            } else {
                echo '<div class="messageSent">Błąd: Plik nie jest obrazkiem.</div>';
            }
        }
        ?>

        <form method="POST" enctype="multipart/form-data" class="doctor-form">
            <div class="add-inpt">
                <input type="text" name="tytul" id="tytul" placeholder="Tytuł naukowy">
                <input type="text" name="imienazwisko" id="imienazwisko" placeholder="Imię i nazwisko"><br>
                <input type="text" name="profesja" id="profesja" placeholder="Specjalizacja">
                <div class="file-container">
                <i class="fa-solid fa-circle-arrow-down" id="fileIcon"></i>
                    <div class="file-name" id="fileName"></div>
                </div>
                <input type="file" name="obrazek" id="obrazek" class="file-input">
                <input type="submit" class="lekarz-btn" name="signup_submit" value="Wyślij">
                <div class="messageSent"></div>
            </div>
        </form>

        <p class="lekarz-wybierz">Podgląd:</p>

        <?php

        require '../Logowanie/config.php';
        require '../adminSite/configs/addDoctor-config.php';

        $itemsPerPage = 4;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM doctors LIMIT $itemsPerPage OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="tble-cennik">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Id</th>';
            echo '<th>Imie i Nazwisko</th>';
            echo '<th>Profesja</th>';
            echo '<th>Akcje</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . htmlspecialchars($row["tytul"]) . ' ' . htmlspecialchars($row["imienazwisko"]) . '</td>';
                echo '<td>' . $row["profesja"] . '</td>';
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<input type="text" class="new-price-form" name="nowa_profesja" placeholder="Nowa profesja">';
                echo '<button type="submit" class="edit-btn" name="edit-btn">Aktualizuj</button>';
                echo '<button type="submit" class="delete-btn" name="delete-btn">Usuń</button>';
                echo '</form>';
                echo '</td>';
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
                echo '<a class="' . $active_class . '" href="addingDoctor.php?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';
        } else {
            echo '<div class="blog_brakdan">';
            echo "Brak danych do wyświetlenia.";
            echo '<a href="addingDoctor.php?page=1"><i class="fa-solid fa-circle-arrow-left"></i></a>';
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
                    <li><a href="/adminSite/adminAccount.php">Moje konto</a></li>
                    <li><a href="/adminSite/dataAnalysis.php">Analiza danych</a></li>
                    <li><a href="/adminSite/addingBlog.php">Dodaj wpis</a></li>
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
document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('.doctor-form');
    var messageSent = document.querySelector('.messageSent');

    form.addEventListener('submit', function (event) {
        var tytulInput = document.getElementById('tytul');
        if (!validateTextWithDot(tytulInput.value)) {
            displayErrorMessage('Pole "Tytuł naukowy" musi zawierać tylko litery i kropki.');
            event.preventDefault();
            return false;
        }

        var imienazwiskoInput = document.getElementById('imienazwisko');
        if (!validateText(imienazwiskoInput.value)) {
            displayErrorMessage('Pole "Imię i nazwisko" musi zawierać tylko litery.');
            event.preventDefault();
            return false;
        }

        var profesjaInput = document.getElementById('profesja');
        if (!validateText(profesjaInput.value)) {
            displayErrorMessage('Pole "Specjalizacja" musi zawierać tylko litery.');
            event.preventDefault();
            return false;
        }

        clearErrorMessage();
        return true;
    });

    function displayErrorMessage(message) {
        messageSent.innerHTML = message;
        messageSent.style.color = 'red';
    }

    function clearErrorMessage() {
        messageSent.innerHTML = '';
    }

    function validateTextWithDot(text) {
        var regex = /^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s.]+$/;
        return regex.test(text);
    }

    function validateText(text) {
        var regex = /^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/;
        return regex.test(text);
    }
});
</script>
<script>
    const fileIcon = document.getElementById('fileIcon');
    const fileInput = document.getElementById('obrazek');
    const fileNameDisplay = document.getElementById('fileName');

    fileIcon.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        fileNameDisplay.textContent = fileInput.files[0].name;
    });
</script>

</html>