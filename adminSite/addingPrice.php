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
    <title>Cennik admin</title>
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

    <p class="lekarz-wybierz">Formularz dodawania/zmian cen w systemie</p>

    <div class="lekarzeDatabase">

        <form method="POST" enctype="multipart/form-data" class="doctor-form">
            <div class="add-inpt">
                <input type="text" name="nazwa" id="nazwa" placeholder="Nazwa zabiegu">
                <input type="text" name="cena" id="cena" placeholder="Cena"><br>
                <input type="submit" class="lekarz-btn" name="add_submit" value="Dodaj">
                <div class="validationMessage" style="display:none;">
                    <p class="nazwaError">Podana cena musi zawierać tylko litery.</p>
                    <p class="cenaError">Podana cena jest ujemna.</p>
                </div>
            </div>
        </form>

        <p class="lekarz-wybierz">Podgląd:</p>

        <?php
        require '../Logowanie/config.php';
        require '../adminSite/configs/cennik-config.php';

        $itemsPerPage = 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM cennik LIMIT $itemsPerPage OFFSET $offset";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="tble-cennik">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Id</th>';
            echo '<th>Nazwa zabiegu</th>';
            echo '<th>Cena</th>';
            echo '<th>Akcje</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["nazwa"] . '</td>';
                echo '<td>' . $row["cena"] . '</td>';
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<input type="text" class="new-price-form" name="cena" placeholder="Nowa cena">';
                echo '<button type="submit" class="edit-btn" name="edit-btn">Aktualizuj cenę</button>';
                echo '<button type="submit" class="delete-btn" name="delete-btn">Usuń</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            $sqlCount = "SELECT COUNT(*) AS total FROM cennik";
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
    //Walidacja formularza dodawania zabiegów i cen
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('.doctor-form');
        var validationMessage = document.querySelector('.validationMessage');
        var nazwaError = document.querySelector('.nazwaError');
        var cenaError = document.querySelector('.cenaError');

        form.addEventListener('submit', function(event) {
            var nazwaInput = document.getElementById('nazwa');
            var cenaInput = document.getElementById('cena');

            var nazwaRegex = /^[a-zA-Z]+$/;
            var cenaRegex = /^\d+(\.\d{1,2})?$/;

            var nazwaValid = nazwaRegex.test(nazwaInput.value);
            var cenaValid = cenaRegex.test(cenaInput.value);

            if (!nazwaValid && !cenaValid) {
                nazwaError.style.display = 'block';
                cenaError.style.display = 'block';
                validationMessage.style.display = 'block';
                event.preventDefault();
            } else if (!nazwaValid) {
                nazwaError.style.display = 'block';
                cenaError.style.display = 'none';
                validationMessage.style.display = 'block';
                event.preventDefault();
            } else if (!cenaValid) {
                cenaError.style.display = 'block';
                nazwaError.style.display = 'none';
                validationMessage.style.display = 'block';
                event.preventDefault();
            } else {
                validationMessage.style.display = 'none';
            }
        });
    });
</script>

</html>