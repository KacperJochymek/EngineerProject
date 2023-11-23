<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kontakt</title>
    <link rel="icon" href="/images/leaf.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>
</head>

<body>

    <div class="prevPage">
        <a href="/Logowanie/sign_in.php"><i class="fa-solid fa-circle-chevron-left"></i></a>
    </div>

    <div class="container">
        <form class="contact-form" action="https://formsubmit.co/karton2137j@gmail.com" method="POST">
            <p>Napisz do nas, aby odzyskać hasło.</p>
            <i class="fa-regular fa-envelope"><input type="email" name="email" class="email-hldr" placeholder="Wpisz swój e-mail" required></i>
            <textarea class="message-inpt" name="message" placeholder="Treść wiadomości" required></textarea>
            <input type="hidden" name="_next" value="http://localhost:3000/userSite/successfullMessage.php">
            <input type="submit" class="lekarz-btn" value="Wyślij">
        </form>
    </div>

</body>

<script src="/Logowanie/script.js"></script>

</html>