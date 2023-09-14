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

        <!-- Logowanie -->
            <div class="form login">
                <span class="title">Zaloguj</span>

                <?php
                if (isset($_POST["login"])){
                    $nick = $_POST["nick"];
                    $password = $_POST["password"];
                    require_once "database.php";
                    $sql = "SELECT * FROM users WHERE nick = '$nick'";
                    $result = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if($user){
                        if(password_verify($password, $user["password"])){
                            session_start();
                            $_SESSION["user"] = "yes";
                            header("Location: UserLogin.php");
                            die();
                        }else{
                            echo "<div class='alert alert-danger'>Nieprawidłowe hasło.</div>";
                        }

                    }else{
                        echo "<div class='alert alert-danger'>Nieprawidłowa nazwa użytkownika.</div>";
                    }
                }
                ?>
                <form action="sign_in.php" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Nazwa użytkownika" required>
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Hasło" required>
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
                        <input type="submit" value="Zaloguj się!">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Nie masz jeszcze konta?
                        <a href="#" class="text signup-link">Zarejestruj się!</a>
                    </span>
                </div>
            </div>


            <!--Rejestracja-->
            <div class="form signup">
                <span class="title">Zarejestruj się</span>


                <?php
                if(isset($_POST["submit"])){
                    $nick = $_POST["nick"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $passwordRepeat= $_POST["passwordRepeat"];

                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    $errors = array();

                    if(empty($nick) OR empty ($email) OR empty ($password) OR empty ($passwordRepeat)){
                        array_push($errors, "Wszystkie pola wymagane!");
                    }
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "Email nieprawidłowy");
                    }
                    if(strlen($password)<8){
                        array_push($errors,"Hasło musi mieć conajmniej 8 znaków.");
                    }
                    if($password!==$passwordRepeat){
                        array_push($errors,"Hasła do siebie nie pasują.");
                    }

                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    require_once "database.php";
                    $result = mysqli_query($conn, $sql);
                    $rowCount = mysqli_num_rows($result);
                    if ($rowCount>0){
                        array_push($errors, "Email już istnieje");
                    }

                    if(count($errors)>0){
                        foreach($errors as $error){
                            echo "<div class ='alert alert-danger'>$error</div>";
                        }
                    }else{
                     
                        $sql = "INSERT INTO users (nick, email, password) VALUES (?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                        if($prepareStmt){
                            mysqli_stmt_bind_param($stmt,"sss",$nick, $email, $passwordHash);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-succes'>Pomyślnie zarejestrowano!</div>";
                        }else{
                            die("Cos poszlo nie tak.");
                        }

                    }
                }
                ?>

                <form action="sign_in.php" method="post">
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
                        <input type="submit" value="Zarejestruj się!">
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