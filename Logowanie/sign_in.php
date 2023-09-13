<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <script src="https://kit.fontawesome.com/0e252f77f3.js"></script>

    <title>EngineerProject</title>
</head>

<body>

    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Zaloguj</span>

                <form action="#">
                    <div class="input-field">
                        <input type="text" placeholder="Wpisz swój adres e-mail" required>
                        <i class="fa-regular fa-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Wpisz swoje hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                        <i class="fa-solid fa-eye showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logcheck">
                            <label for="logCheck" class="text">Zapamiętaj mnie</label>
                        </div>

                        <a href="#" class="text">Zapomniałeś hasła?</a>
                    </div>

                    <div class="input-field button">
                        <input type="button" value="Zaloguj się!">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Nie masz jeszcze konta?
                        <a href="#" class="text signup-link">Zarejestruj się!</a>
                    </span>
                </div>
            </div>


            <!--Register form!-->
            <div class="form signup">
                <span class="title">Zarejestruj się</span>

                <form action="#">
                    <div class="input-field">
                        <input type="text" placeholder="Podaj nazwę użytkownika" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Podaj swój adres e-mail" required>
                        <i class="fa-regular fa-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Podaj hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Powtórz hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                        <i class="fa-solid fa-eye showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logcheck">
                            <label for="logCheck" class="text">Zapamiętaj mnie</label>
                        </div>

                        <a href="#" class="text">Zapomniałeś hasła?</a>
                    </div>

                    <div class="input-field button">
                        <input type="button" value="Zaloguj się!">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text"> Masz już konto?
                        <a href="#" class="text login-link">Zaloguj się!</a>
                    </span>
                </div>
            </div>
        </div>
    </div>



    <script src="/Logowanie/script.js"></script>
</body>

</html>