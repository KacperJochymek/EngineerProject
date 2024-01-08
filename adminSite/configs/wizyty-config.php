<?php
require '../Logowanie/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tak_oo'])) {
    $id = $_POST['id'];

    // Usuń rekord z tabeli dostepnosc
    $sqlDostepnosc = "DELETE FROM dostepnosc WHERE id_wizyty = $id";

    // Zaktualizuj pole status_wizyty w tabeli wizyty
    $sqlWizyty = "UPDATE wizyty SET status_wizyty = 'dostepna' WHERE id = $id AND status_wizyty = 'zarezerwowana'";

    // Wykonaj w kolejności, aby zapewniśc spójność bazy danych
    $conn->begin_transaction();

    try {
        if ($conn->query($sqlDostepnosc) && $conn->query($sqlWizyty)) {
            // Wszystko pomyślnie, zatwierdź
            $conn->commit();
           $message = "Dane usunięte i wizyta zaktualizowana poprawnie.";
        } else {
            // Błąd, cofnij 
            $conn->rollback();
            $message = "Błąd:  $conn->error  ";
        }
    } catch (Exception $e) {
        // Błąd, cofnij 
        $conn->rollback();
        $message = "Błąd:  $conn->error  ";
    }
}

?>