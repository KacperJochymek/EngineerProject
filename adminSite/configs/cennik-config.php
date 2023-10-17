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
        echo '<script>alert("Dane dodane poprawnie");</script>';
    } else {
        echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
    }
}

?>

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit-btn'])) {
    $id = $_POST['id'];
    $cena = (float) str_replace(',', '.', $_POST['cena']);

    $sql = "UPDATE cennik SET cena = $cena WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Dane zaktualizowane poprawnie");</script>';
    } else {
        echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
    }
}

?>
<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete-btn'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM cennik WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Dane usunięte poprawnie");</script>';
    } else {
        echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
    }
}

?>