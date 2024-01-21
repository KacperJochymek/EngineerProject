<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'registerlog';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$backupFilePath = 'backups/backup_' . date('Y-m-d') . '.sql';
$handle = fopen($backupFilePath, 'w');

// Zapisz tabele (bez tabeli dostepnosc)
$tablesOrder = ['users', 'doctors', 'pacjenci', 'wizyty', 'cennik', 'blog'];

foreach ($tablesOrder as $table) {
    if ($table !== 'dostepnosc') {
        // Zapisz
        fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n");
        
        $createTable = $mysqli->query("SHOW CREATE TABLE `$table`");
        $createTableInfo = $createTable->fetch_row();
        fwrite($handle, $createTableInfo[1] . ";\n\n");

        // Wstaw dane
        $resultTable = $mysqli->query("SELECT * FROM `$table`");
        while ($rowTable = $resultTable->fetch_assoc()) {
            $line = "INSERT INTO `$table` VALUES (";
            foreach ($rowTable as $value) {
                $line .= "'" . $mysqli->real_escape_string($value) . "',";
            }
            $line = rtrim($line, ',') . ");\n";
            fwrite($handle, $line);
        }
        fwrite($handle, "\n");
    }
}

// Sprawdź dostepnosc, wczytaj dane
fwrite($handle, "DROP TABLE IF EXISTS `dostepnosc`;\n");
$createTable = $mysqli->query("SHOW CREATE TABLE dostepnosc");
$createTableInfo = $createTable->fetch_row();
fwrite($handle, $createTableInfo[1] . ";\n\n");

$resultTable = $mysqli->query("SELECT * FROM dostepnosc");
while ($rowTable = $resultTable->fetch_assoc()) {
    $line = "INSERT INTO dostepnosc VALUES (";
    foreach ($rowTable as $value) {
        $line .= "'" . $mysqli->real_escape_string($value) . "',";
    }
    $line = rtrim($line, ',') . ");\n";
    fwrite($handle, $line);
}
fwrite($handle, "\n");

fclose($handle);
$mysqli->close();

echo "Backup completed successfully!";
?>
