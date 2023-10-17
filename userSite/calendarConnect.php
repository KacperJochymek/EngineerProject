<?php
require '../Logowanie/config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectedDate"])) {
    $selectedDate = $_POST["selectedDate"];

    // Przyjmujemy, że $selectedDate to data w formacie "Y-m-d", na przykład "2023-10-20".
    // Możesz dostosować ten format do swojej aplikacji.

    // Zabezpiecz zmienną przed atakami SQL Injection
    $selectedDate = mysqli_real_escape_string($conn, $selectedDate);

    // Pobieranie dostępnych godzin tylko dla wybranego dnia
    $query = "SELECT available_hour FROM wizyty WHERE data_wizyty = '$selectedDate'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $godziny = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $godziny[] = $row['available_hour'];
    }

    // Zamknij połączenie z bazą danych
    mysqli_close($conn);

    // Zwróć dane jako JSON
    header('Content-Type: application/json');
    echo json_encode($godziny);
} else {
    die("Nieprawidłowe żądanie.");
}
?>


