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

    <a href="/index.php"><i class="fa-solid fa-angle-left"></i></a>

    <div class="container">
        <div class="forms">

            <!-- Logowanie -->
            <div class="form login">
                <span class="title">Zaloguj</span>

                <?php
                session_start();
                require '../Logowanie/config.php';

                if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
                    header("Location: sign_in.php");
                    exit();
                }

                if (isset($_POST["login_submit"])) {
                    $usernamemail = $_POST["usernamemail"];
                    $password = $_POST["password"];

                    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$usernamemail' OR email = '$usernamemail'");
                    $row = mysqli_fetch_assoc($result);

                    if (mysqli_num_rows($result) > 0) {

                        $hashedPasswordFromDatabase = $row["password"];

                        if (password_verify($password, $hashedPasswordFromDatabase)) {
                            $_SESSION["login"] = true;
                            $_SESSION["id"] = $row["id"];
                            $_SESSION["role"] = $row["role"];

                            if ($_SESSION["role"] === "admin") {
                                header("Location: ../adminSite/adminAccount.php");
                                exit();
                            } elseif ($_SESSION["role"] === "doctor") {
                                header("Location: ../doctorSite/doctorFirstSite.php");
                                exit();
                            } else {
                                header("Location: ../userSite/myAccount.php");
                                exit();
                            }
                        } else {
                            echo "<script>alert('Złe hasło');</script>";
                        }
                    } else {
                        echo "<script>alert('Nie jesteś zarejestrowany!');</script>";
                    }
                }
                ?>
                <form action="sign_in.php" method="post">
                    <div class="input-field">
                        <input type="text" name="usernamemail" id="usernamemail" placeholder="Nazwa użytkownika lub e-mail" required>
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" class="password" placeholder="Hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                        <i class="fa-solid fa-eye showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logcheck" name="remember_me">
                            <label for="logcheck" class="text">Zapamiętaj mnie</label>
                        </div>

                        <a href="#" class="text">Zapomniałeś hasła?</a>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="login_submit" value="Zaloguj się!">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Nie masz jeszcze konta?
                        <a href="#" class="text signup-link">Zarejestruj się!</a>
                    </span>
                </div>
            </div>

            <!-- Rejestracja -->
            <div class="form signup">
                <span class="title">Zarejestruj się</span>

                <?php
                if (isset($_POST["signup_submit"])) {
                    $username = $_POST["username"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $confirmpassword = $_POST["confirmpassword"];


                    if (empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
                        echo "<script>alert('Wszystkie pola są wymagane.');</script>";
                    } else {

                        if (strlen($password) < 6) {
                            echo "<script>alert('Hasło musi mieć co najmniej 6 znaków.');</script>";
                        } else {
                            if (!preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*()_+]/', $password)) {
                                echo "<script>alert('Hasło musi zawierać co najmniej jedną dużą literę i jeden znak specjalny.');</script>";
                            } else {

                                if ($password == $confirmpassword) {

                                    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
                                    if (mysqli_num_rows($duplicate) > 0) {
                                        echo "<script>alert('Nazwa użytkownika lub e-mail już istnieje.');</script>";
                                    } else {

                                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
                                        if (mysqli_query($conn, $query)) {
                                            echo "<script>alert('Pomyślnie zarejestrowano!');</script>";
                                        } else {
                                            echo "<script>alert('Wystąpił błąd podczas rejestracji.');</script>";
                                        }
                                    }
                                } else {
                                    echo "<script>alert('Hasła nie pasują do siebie.');</script>";
                                }
                            }
                        }
                    }
                }
                ?>

                <form action="sign_in.php" method="post" autocomplete="off">

                    <div class="input-field">
                        <input type="text" name="username" id="username" placeholder="Podaj nazwę użytkownika" required>
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <div class="input-field">
                        <input type="email" name="email" id="email" placeholder="Podaj swój adres e-mail" required>
                        <i class="fa-regular fa-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" id="password" class="password" placeholder="Podaj hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="confirmpassword" id="confirmpassword" class="password" placeholder="Powtórz hasło" required>
                        <i class="fa-solid fa-lock icon"></i>
                        <i class="fa-solid fa-eye showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="regcheck" name="remember_me">
                            <label for="regcheck" class="text">Zapamiętaj mnie</label>
                        </div>

                        <a href="#" class="text">Zapomniałeś hasła?</a>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="signup_submit" value="Zarejestruj się!">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Masz już konto?
                        <a href="#" class="text login-link">Zaloguj się!</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script src="/Logowanie/script.js"></script>
</body>

</html>