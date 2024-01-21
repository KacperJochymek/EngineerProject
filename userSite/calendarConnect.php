<?php
require '../Logowanie/config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["selectedDate"]) && isset($_GET["doctor_id"])) { 
    $selectedDate = $_GET["selectedDate"]; 
    $doctorId = $_GET["doctor_id"]; 

    // Zabezpieczenie przed atakami SQL Injection
    $selectedDate = mysqli_real_escape_string($conn, $selectedDate);
    $doctorId = mysqli_real_escape_string($conn, $doctorId);

    // Pobieranie dostępnych godzin tylko dla wybranego dnia i lekarza
    $query = "SELECT available_hour, status_wizyty FROM wizyty WHERE data_wizyty = '$selectedDate' AND doctor_id = '$doctorId'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $godziny = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $godziny[] = array(
            'hour' => $row['available_hour'],
            'status_wizyty' => $row['status_wizyty']
        );
    }

    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($godziny);
} else {
    die("Nieprawidłowe żądanie.");
}