<?php
if (file_exists("data.csv")) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data.csv"');
    readfile("data.csv");
} else {
    echo "Файл не найден! <a href='index.php'>Назад</a>";
}
?>
