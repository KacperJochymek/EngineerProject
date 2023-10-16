<!-- usuwanie wpisu -->
<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['delete-btn'])) {
        $id = $_POST['id']; 
        
        if (is_array($id)) {
            $id = reset($id); 
        }

        $sql = "DELETE FROM blog WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Dane usunięte poprawnie");</script>';
        } else {
            echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
        }
    }

    // Edycja i zapis wpisu

    if (isset($_POST['save-btn'])) {
        $id = $_POST['id'];
        $tekst = $_POST['tekst'];

        if (is_array($id) && is_array($tekst) && count($id) === count($tekst)) {
            for ($i = 0; $i < count($id); $i++) {
                $currentId = $id[$i];
                $currentTekst = $tekst[$i];

                $sql = "UPDATE blog SET tekst = '$currentTekst' WHERE id = $currentId";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Tekst pomyślnie zapisany");</script>';
                } else {
                    echo '<script>alert("Błąd: ' . $sql . '\\n' . $conn->error . '");</script>';
                }
            }
        }
    }
}
?>

