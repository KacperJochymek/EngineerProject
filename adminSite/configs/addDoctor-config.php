<!-- Zrobic update tego \/ -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit-btn'])) {
    $id = $_POST['id'];
    $nowa_profesja = $_POST['nowa_profesja'];

    $sql = "UPDATE doctors SET profesja = '$nowa_profesja' WHERE id = $id"; 
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Profesja zaktualizowana poprawnie");</script>';
    } else {
        echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
    }
}
?>

<!-- usuwanie z bazy danych -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete-btn'])) {
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
            echo '<script>alert("Dane usunięte poprawnie");</script>';
        } else {
            echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
        }
    }
}
?>
