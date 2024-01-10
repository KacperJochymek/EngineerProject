<!-- Aktualizacja profesji -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['edit-btn'])) {
    $imienazwisko = $_POST['id']; // Zmieniono z $id na $imienazwisko
    $nowa_profesja = $_POST['nowa_profesja'];

    $sqlCheckAppointments = "SELECT COUNT(*) as appointments_count FROM wizyty 
    WHERE doctor_id = '$imienazwisko' AND status_wizyty = 'zarezerwowana'";
    $resultCheckAppointments = $conn->query($sqlCheckAppointments);

    if ($resultCheckAppointments->num_rows > 0) {
        $rowCheckAppointments = $resultCheckAppointments->fetch_assoc();

        if ($rowCheckAppointments["appointments_count"] > 0) {
            echo '<div class="messageSent">Nie można zmienić profesji, ponieważ lekarz ma umówione wizyty.</div>';
        } else {
            if (!preg_match('/^[a-zA-Z]+$/', $nowa_profesja)) {
                echo '<div class="messageSent">Błąd: Profesja powinna zawierać tylko litery!</div>';
            } else {
                $sqlUpdateProfession = "UPDATE doctors SET profesja = '$nowa_profesja' WHERE imienazwisko = '$imienazwisko'"; // Zmieniono z id na imienazwisko

                if ($conn->query($sqlUpdateProfession) === TRUE) {
                    echo '<div class="messageSent">Profesja zaktualizowana pomyślnie!</div>';
                } else {
                    echo '<div class="messageSent">Błąd: ' . $sqlUpdateProfession . '<br>' . $conn->error . '</div>';
                }
            }
        }
    }
}
?>

<!-- usuwanie z bazy danych -->

<?php
require '../Logowanie/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tak_oo'])) {
    $imienazwisko = $_POST['id']; 

    $sqlCheckAppointments = "SELECT COUNT(*) as appointments_count FROM wizyty WHERE doctor_id = '$imienazwisko' 
    AND status_wizyty = 'zarezerwowana'";
    $resultCheckAppointments = $conn->query($sqlCheckAppointments);

    if ($resultCheckAppointments->num_rows > 0) {
        $rowCheckAppointments = $resultCheckAppointments->fetch_assoc();
        $appointmentsCount = $rowCheckAppointments["appointments_count"];

        if ($appointmentsCount > 0) {
            echo '<div class="messageSent">Nie możesz usunąć lekarza, ponieważ ma on umówione wizyty.</div>';
        } else {

            $sqlDeleteFreeAppointments = "DELETE FROM wizyty WHERE doctor_id = '$imienazwisko' AND status_wizyty = 'dostepna'";
            if ($conn->query($sqlDeleteFreeAppointments) === TRUE) {
                echo '<div class="messageSent">Wolne terminy usunięte poprawnie.</div>';
            } else {
                echo '<div class="messageSent">Błąd: ' . $sqlDeleteFreeAppointments . '<br>' . $conn->error . '</div>';
            }

            $sql = "SELECT obrazek FROM doctors WHERE imienazwisko = '$imienazwisko'"; // Zmieniono z id na imienazwisko
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $obrazekName = $row["obrazek"];

                $obrazekPath = 'uploads/' . $obrazekName;
                if (file_exists($obrazekPath)) {
                    unlink($obrazekPath);
                }

                $sql = "DELETE FROM doctors WHERE imienazwisko = '$imienazwisko'"; // Zmieniono z id na imienazwisko
                if ($conn->query($sql) === TRUE) {
                    echo '<div class="messageSent">Dane usunięte poprawnie.</div>';
                } else {
                    echo '<div class="messageSent">Błąd: ' . $sql . '<br>' . $conn->error . '</div>';
                }
            }
        }
    }
}
?>