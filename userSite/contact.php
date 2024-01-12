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
    <title>Formularz kontakt</title>
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
                <?php
                if ($userType === 'user' || $userType === 'admin') {
                    // Nawigacja dla usera
                    echo '<li><a href="/indexLogged.php">Strona główna</a></li>';
                    echo '<li><a href="lekarze.php">Lekarze</a></li>';
                    echo '<li><a href="cennik.php">Cennik</a></li>';
                    echo '<li><a href="blog.php">Aktualności</a></li>';
                    echo '<li><a href="contact.php" class="active2">Kontakt</a></li>';
                    echo '<li><a href="myAccount.php">Moje konto</a></li>';
                } elseif ($userType === 'doctor') {
                    // Nawigacja dla lekarza
                    echo '<li><a href="/indexLogged.php">Strona główna</a></li>';
                    echo '<li><a href="/doctorSite/doctorAccount.php">Godziny pracy</a></li>';
                    echo '<li><a href="/doctorSite/doctorVisitCount.php">Wizyty</a></li>';
                    echo '<li><a href="contact.php" class="active2">Kontakt</a></li>';
                    echo '<li><a href="/doctorSite/doctorFirstSite.php">Moje konto</a></li>';
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

    <div class="contact-site">

        <h1>Hej <?php echo $row["username"]; ?>, jeśli masz jakieś pytania skontaktuj się z nami!</h1>

        <div class="messageSent" id="messageSent"></div>

        <div class="paczka_blog">
            <form class="contact-form" action="https://formsubmit.co/karton2137j@gmail.com" method="POST">
                <i class="fa-regular fa-envelope"><input type="email" name="email" class="email-hldr" placeholder="Wpisz swój e-mail" required></i>
                <textarea class="message-inpt" name="message" placeholder="Treść wiadomości" required></textarea>
                <input type="hidden" name="_next" value="http://localhost:3000/userSite/successfullMessage.php">
                <input type="submit" class="lekarz-btn" value="Wyślij">
            </form>
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
                    <li><a href="/userSite/blog.php">Blog</a></li>
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var contactForm = document.querySelector(".contact-form");
        var messageSentDiv = document.getElementById("messageSent");

        contactForm.addEventListener("submit", function(event) {
            var messageTextarea = document.querySelector(".message-inpt");
            var trimmedMessage = messageTextarea.value.trim();

            if (trimmedMessage === "") {
                event.preventDefault();
                messageSentDiv.innerHTML = "Wiadomość nie może być pusta.";
            }
        });
    });
</script>

</html>