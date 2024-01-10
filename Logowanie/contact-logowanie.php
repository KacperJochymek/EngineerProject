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
        <form class="contact-form" id="contactForm" action="https://formsubmit.co/karton2137j@gmail.com" method="POST">
            <p>Masz pytanie? Napisz do nas!</p>
            <i class="fa-regular fa-envelope"><input type="email" name="email" class="email-hldr" placeholder="Wpisz swój e-mail" required></i>
            <div class="messageSent" id="messageSent"></div>
            <textarea class="message-inpt" name="message" placeholder="Treść wiadomości" required></textarea>
            <input type="hidden" name="_next" value="http://localhost:3000/Logowanie/contact-success.php">
            <input type="submit" class="lekarz-btn" value="Wyślij">
        </form>
    </div>


</body>

<script src="/Logowanie/script.js"></script>
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