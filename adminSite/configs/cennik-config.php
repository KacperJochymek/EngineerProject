<?php

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

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_submit'])) {
    $nazwa = $_POST['nazwa'];
    $cena = (float) str_replace(',', '.', $_POST['cena']);

    $sql = "INSERT INTO cennik (nazwa, cena) VALUES ('$nazwa', '$cena')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="validationMessage">Dane dodane poprawnie</div>';
    } else {
        echo '<div class="validationMessage">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
    }
}

?>

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit-btn'])) {
    $id = $_POST['id'];
    $cena = $_POST['cena'];

    if (!preg_match('/^[0-9]+([,.][0-9]+)?$/', $cena)) {
        echo '<div class="validationMessage">Błąd: Podana cena jest ujemna!</div>';
    } else {
        $cena = (float) str_replace(',', '.', $cena);
        $sql = "UPDATE cennik SET cena = $cena WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo '<div class="validationMessage">Dane zaktualizowane poprawnie</div>';
        } else {
            echo '<div class="validationMessage">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
}
?>


<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete-btn'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM cennik WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="validationMessage">Dane usunięte poprawnie</div>';
    } else {
        echo '<div class="validationMessage">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
    }
}

?>