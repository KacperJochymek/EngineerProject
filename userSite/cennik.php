<?php
session_start();

if (empty($_SESSION["id"])) {
    header("Location: /index.php"); 
    exit();
}

require '../Logowanie/config.php';
if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id =$id");
    $row = mysqli_fetch_assoc($result);

    $userType = $row["role"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cennik</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <?php
            if ($userType === 'user') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease.png"></a>';
            } elseif ($userType === 'doctor') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease_doctor.png"></a>';
            } elseif ($userType === 'admin') {
                echo '<a href="/indexLogged.php"> <img src="/images/medease_admin.png"></a>';
            } else {
                echo '<a href="/indexLogged.php"> <img src="/images/medease.png"></a>';
            }
            ?>
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
                    <a href="cennik.php" class="active2">Cennik</a>
                </li>
                <li>
                    <a href="blog.php">Aktualności</a>
                </li>
                <li>
                    <a href="contact.php">Kontakt</a>
                </li>

                <?php
                if ($userType === 'user') {
                    echo '<li><a href="/userSite/myAccount.php">Moje konto</a></li>';
                } elseif ($userType === 'doctor') {
                    echo '<li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>';
                } elseif ($userType === 'admin') {
                    echo '<li><a href="/adminSite/adminAccount.php">Moje Konto</a></li>';
                }
                ?>
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

    <div class="priceSite">
        <?php
        $sql = "SELECT nazwa, cena FROM cennik";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="pricing">';
            echo '<h2>Cennik naszych usług</h2>';
            echo '<table class="wyrownanie">';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["nazwa"]) . '</td>';
                echo '<td>' . number_format($row["cena"], 2) . ' zł</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</div>';
        } else {
            echo "Brak danych w cenniku.";
        }
        ?>


        <div class="warningInfo">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <p>Płatności za wykonane usługi realizowane są tylko za pomocą karty lub gotówki w placówce.</p>
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

<script src="script1.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var dostosujWysokosc = document.querySelector('.priceSite');
        var tabelaCennik = document.querySelector('.wyrownanie');
        var wierszeCennik = document.querySelectorAll('.wyrownanie tr');

        function dostosujWysokoscStrony() {
            var iloscRekordow = wierszeCennik.length;

            if (iloscRekordow > 4) {
                var dodatkowaWysokosc = (iloscRekordow - 4) * 30;
                dostosujWysokosc.style.height = (dostosujWysokosc.offsetHeight + dodatkowaWysokosc) + 'px';
            }
        }

        dostosujWysokoscStrony();
    });
</script>


</html>