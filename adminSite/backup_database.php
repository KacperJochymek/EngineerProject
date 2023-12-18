<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'registerlog';

$mysqldumpPath = 'mysqldump';

$backupFolderPath = 'backups\\';
$backupFilePath = $backupFolderPath . 'backup.sql';

$command = "$mysqldumpPath -h$host -u$user -p$password $database > $backupFilePath";
system($command);

if (file_exists($backupFilePath)) {
    echo "Kopia zapasowa bazy danych została utworzona pomyślnie.";
} else {
    echo "Błąd podczas tworzenia kopii zapasowej bazy danych.";
}
?>
