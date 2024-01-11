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
            <img src="/images/medease_admin.png">
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
                    <a href="/adminSite/addingDoctor.php" class="active2">Dodaj lekarza</a>
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

    <p class="lekarz-wybierz">Formularz dodawania lekarza do systemu</p>

    <div class="wysoko_addDoctor">
        <?php

        require '../Logowanie/config.php';

        if (isset($_POST["signup_submit"])) {
            $tytul = $_POST["tytul"];
            $imie = $_POST["imie"];
            $nazwisko = $_POST["nazwisko"];
            $profesja = $_POST["profesja"];

            $imienazwisko = $_POST["imie"] . ' ' . $_POST["nazwisko"];

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
                <div class="laczenie">
                    <div class="slct-wrapper">
                        <p>Wybierz tytuł:</p>
                        <select class="select-prof" name="tytul" id="tytul">
                            <option value="lek.">lek.</option>
                            <option value="mgr">mgr</option>
                            <option value="dr">dr</option>
                            <option value="dr n. med.">dr n. med.</option>
                            <option value="dr hab. n. med.">dr hab. n. med.</option>
                            <option value="prof. dr hab. n. med.">prof. dr hab. n. med.</option>
                        </select>
                    </div>
                    <div class="slct-wrapper">
                        <p>Wybierz specjalizację:</p>
                        <select class="select-prof" name="profesja" id="profesja">
                            <option value="Podolog">Podolog</option>
                            <option value="Onkolog">Onkolog</option>
                            <option value="Psycholog">Psycholog</option>
                            <option value="Kardiolog">Kardiolog</option>
                            <option value="Internista">Internista</option>
                            <option value="Neurolog">Neurolog</option>
                        </select>
                    </div>
                </div>
                <div class="laczenie">
                    <input class="new_lekz" type="text" name="imie" id="imie" placeholder="Imię">
                    <input class="new_lekz" type="text" name="nazwisko" id="nazwisko" placeholder="Nazwisko">
                </div>

                <div class="file-container">
                    <p>Wybierz plik:</p>
                    <i class="fa-solid fa-circle-arrow-up" id="fileIcon"></i>
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

        $itemsPerPage = 5;
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
            echo '<th>Imię i Nazwisko</th>';
            echo '<th>Specjalizacja</th>';
            echo '<th>Akcje</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $count = $offset + 1;
            $counter = 1;

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $count .  '</td>';
                echo '<td>' . htmlspecialchars($row["tytul"]) . ' ' . htmlspecialchars($row["imienazwisko"]) . '</td>';
                echo '<td>' . $row["profesja"] . '</td>';
                echo '<td>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="id" value="' . $row["imienazwisko"] . '">';
                echo '<input type="text" class="new-price-form" name="nowa_profesja" placeholder="Nowa profesja">';
                echo '<button type="submit" class="edit-btn" name="edit-btn">Aktualizuj</button>';
                echo '<button type="submit" class="delete-btn" name="delete-btn">Usuń</button>';
                echo '</form>';
                echo '<form method="post">';
                echo '<input type="hidden" name="id" value="' . $row['imienazwisko'] . '">';
                echo '<div class="ukrytyDiv" id="ukrytyDiv' . $counter . '" style="display:none;">';
                echo '<p>Czy na pewno? </p>';
                echo '<button name="tak_oo" id="tak_oo">Tak</button>';
                echo '<button onclick="schowajDiv(' . $counter . ')">Nie</button>';
                echo '</div>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';

                $count++;
                $counter++;
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

    <div class="dostosuj-wysokosc"></div>
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
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('.doctor-form');
        var messageSent = document.querySelector('.messageSent');

        form.addEventListener('submit', function(event) {
            clearErrorMessage();

            var imieInput = document.getElementById('imie');
            var nazwiskoInput = document.getElementById('nazwisko');

            var imieValid = validateText(imieInput.value);
            var nazwiskoValid = validateText(nazwiskoInput.value);

            if (!imieValid || !nazwiskoValid) {
                event.preventDefault();
                messageSent.innerHTML = 'Pola "Imię" i "Nazwisko" muszą zawierać tylko litery.';
                messageSent.style.color = 'red';
            }
        });

        function clearErrorMessage() {
            messageSent.innerHTML = '';
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
        var deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(function(button, index) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                pokazDiv(index + 1);
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-btn');
        var dostosujWysokosc = document.querySelector('.dostosuj-wysokosc');

        deleteButtons.forEach(function(button, index) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                pokazDiv(index + 1); 
                dostosujWysokoscStrony();
            });
        });

        function dostosujWysokoscStrony() {
            var aktualnaWysokosc = dostosujWysokosc.offsetHeight;
            var nowaWysokosc = aktualnaWysokosc + 50; 
            dostosujWysokosc.style.height = nowaWysokosc + 'px';
        }
    });
</script>

</html>