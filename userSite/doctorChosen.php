<?php
require '../Logowanie/config.php';
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["doctor_id"])) {
    $doctor_id = $_POST["doctor_id"];

    
    $sql = "SELECT * FROM doctors WHERE id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $selected_doctor = $result->fetch_assoc();
        $imie = $selected_doctor["imie"];
        $nazwisko = $selected_doctor["nazwisko"];
        $profesja = $selected_doctor["profesja"];
        $obrazek = $selected_doctor["obrazek"];
    } else {
        echo "Brak danych do wyświetlenia.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>EngineerProject</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="/index.php"> <img src="/images/logo.png"></a>
        </div>
        <input type="checkbox" id="nav_check" hidden>
        <nav>
            <div class="logo">
                <img src="./images/logo.png" width="100px" height="100px" />
            </div>
            <ul>
                <li>
                    <a href="/index.php">Strona Główna</a>
                </li>
                <li>
                    <a href="">Lekarze</a>
                </li>
                <li>
                    <a href="">Cennik</a>
                </li>
                <li>
                    <a href="">Kontakt</a>
                </li>
                
                <li>
                    <a href="">Moje Konto</a>
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

    
    <p class="lekarz-wybierz">Podaj dane osobowe:</p>


    <div class="doctorContent">
    <!-- <div class="lekarz-logo2">
            <img src="/images/lekarz-w.png" alt="">

            <p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i> lek. med. Anita Wrona </p> 
            <p class="profesja"> <i class="fa-solid fa-stethoscope"></i>Laryngolog</p>
    </div> -->


    <div class="lekarz-logo2">
        <?php
        if (isset($imie) && isset($nazwisko)) {
            echo '<img src="../adminSite/uploads/' . $obrazek . '" alt="">';
            echo '<p class="lekarz-med"> <i class="fa-solid fa-user-doctor"></i>' . $imie . ' ' . $nazwisko . '</p>';
            echo '<p class="profesja"> <i class="fa-solid fa-stethoscope"></i>' . $profesja . '</p>';
        } else {
            echo "Nie wybrano lekarza.";
        }
        ?>
    


    </div>

    <div class="doc-chosen">
        <div class="doctor-form">
            <p class="tekst-doctor3">Imię:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz imię"> 
            <p class="tekst-doctor3">Nazwisko:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz nazwisko">
            <p class="tekst-doctor3">Wiek:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz swój wiek">
            <p class="tekst-doctor3">Pesel:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz swój pesel">
            <p class="tekst-doctor3">Miasto:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz miasto">
            <p class="tekst-doctor3">Województwo:</p>
            <input type="text" name="name" id="name" placeholder="Wpisz województwo">
        </div>

        <div class="btn-chosen">
            <button class="lekarz-btn"><a href="/userSite/lekarze.php">Powrót</a></button>
            <button class="lekarz-btn"><a href="#">Dalej</a></button>
        </div>
    </div>
    </div>
    
    

    <footer>
        <div class="foo">
            <div class="col-1">
                <h1>O nas</h1>

                <p class="footer-text">Witamy w Kacper Jochymek. Jesteśmy firmą, która zajmuje się tworzeniem oprogramowania dla sieci przychodni. W naszej aplikacji pacjent może wybrać odpowiedniego dla siebie lekarza, umówić wizytę, skonsultować
                     swój stan zdrowia i ma to wszystko pod ręką.</p>
            </div>

            <div class="col-1">
                <h1>Biuro</h1>
                <p class="footer-text">ul. Galla Anonima 7</p>
                <p>43-608 Jaworzno, Polska</p>
                <p class="email-id"><b>Nasz adres e-mail:</b> <br> k.joch19@wp.pl</p>
                <p><b>Numer telefonu: </b> <br> 576-157-274</p>
            </div>

            <div class="col-1">
                <h1>Przydatne linki</h1>
                <ul>
                    <li><a href="/index.php">Strona główna</a></li>
                    <li><a href="#">Umów wizytę</a></li>
                    <li><a href="#">Cennik</a></li>
                </ul>
            </div>
            <div class="col-1">
                <h1>Skontaktuj się!</h1>
                <!-- <form>
                    <input type="text" placeholder="Twój adres e-mail">
                    <input type="text" placeholder="Zadaj pytanie">
                    <button type="submit">Wyślij!</button>
                </form> -->
                <div class="sociale">
                    <div class="circle"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="circle"><i class="fa-brands fa-x-twitter"></i></div>
                    <div class="circle"><i class="fa-brands fa-instagram"></i></div>
                    <div class="circle"><i class="fa-brands fa-tiktok"></i></div>
                </div>
            </div>
        </div>
        <hr>
        <p class="copyright"> Copyright © YOHM 2023 Wszelkie prawa zastrzeżone.</p>
    </footer>
    
</body>

<script src="script1.js"></script>
</html>