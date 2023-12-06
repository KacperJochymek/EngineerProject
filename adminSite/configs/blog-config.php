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
            echo '<div class="messageSent">Dane usunięte poprawnie.</div>';
        } else {
            echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }

    // Edycja i zapis wpisu

    if (isset($_POST['save-btn'])) {
        $id = $_POST['id'];
        $tekst = $_POST['tekst'];
    
        if (is_array($id) && is_array($tekst) && count($id) === count($tekst)) {
            for ($i = 0; $i < count($id); $i++) {
                $currentId = $id[$i];
                $currentTekst = isset($tekst[$i]) ? trim($tekst[$i]) : '';
    
                // Sprawdź, czy tekst nie jest pusty
                if (empty($currentTekst)) {
                    echo '<div class="messageSent">Błąd: Treść wpisu bloga nie może być pusta.</div>';
                } else {
                    $sql = "UPDATE blog SET tekst = '$currentTekst' WHERE id = $currentId";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="messageSent">Tekst pomyślnie zapisany!</div>';
                    } else {
                        echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
                    }
                }
            }
        }
    }
}
?>