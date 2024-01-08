<!-- Aktualizacja profesji -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit-btn'])) {
    $id = $_POST['id'];
    $nowa_profesja = $_POST['nowa_profesja'];

    if (!preg_match('/^[a-zA-Z]+$/', $nowa_profesja)) {
        echo '<div class="messageSent">Błąd: Profesja powinna zawierać tylko litery!</div>';
    } else {
        $sql = "UPDATE doctors SET profesja = '$nowa_profesja' WHERE id = $id"; 
    
        if ($conn->query($sql) === TRUE) {
            echo '<div class="messageSent">Profesja zaktualizowana pomyślnie!</div>';
        } else {
            echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
}
?>

<!-- usuwanie z bazy danych -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tak_oo'])) {
    $id = $_POST['id'];

    $sql = "SELECT obrazek FROM doctors WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $obrazekName = $row["obrazek"];

        $obrazekPath = 'uploads/' . $obrazekName;
        if (file_exists($obrazekPath)) {
            unlink($obrazekPath);
        }

        $sql = "DELETE FROM doctors WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo '<div class="messageSent">Dane usunięte poprawnie.</div>';
        } else {
            echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }
}

?>