<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function validateInput($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    function isOnlyLetters($str) {
        return preg_match("/^[A-Za-zА-Яа-яЁё\s-]+$/u", $str);
    }

    function isNotOnlyNumbers($str) {
        return !preg_match("/^\d+$/", $str);
    }

    function isValidLicense($str) {
        return preg_match("/^\d{10}$/", $str);
    }

    function isValidAddress($str) {
        return preg_match("/^[A-Za-zА-Яа-яЁё0-9\s.,\/\-]+$/u", $str) && preg_match("/[A-Za-zА-Яа-яЁё]/u", $str);
}


    $driverName = validateInput($_POST["driver_name"] ?? '');
    $car = validateInput($_POST["car"] ?? '');
    $license = validateInput($_POST["license"] ?? '');
    $customerName = validateInput($_POST["customer_name"] ?? '');
    $pickup = validateInput($_POST["pickup"] ?? '');
    $destination = validateInput($_POST["destination"] ?? '');
    $tariff = validateInput($_POST["tariff"] ?? '');

    if (
        empty($driverName) || empty($car) || empty($license) ||
        empty($customerName) || empty($pickup) || empty($destination) || empty($tariff)
    ) {
        die(" Ошибка: Все поля должны быть заполнены!");
    }

    if (!isOnlyLetters($driverName)) {
        die(" Ошибка: Имя водителя должно содержать только буквы!");
    }
    if (!isNotOnlyNumbers($car)) {
        die(" Ошибка: Название машины не может состоять только из цифр!");
    }
    if (!isValidLicense($license)) {
        die(" Ошибка: Лицензия должна содержать ровно 10 цифр!");
    }
    if (!isOnlyLetters($customerName)) {
        die(" Ошибка: Имя клиента должно содержать только буквы!");
    }
    if (!isValidAddress($pickup)) {
        die(" Ошибка: Поле 'Откуда' должно содержать буквы и может включать цифры, точки и запятые!");
    }
    if (!isValidAddress($destination)) {
        die(" Ошибка: Поле 'Куда' должно содержать буквы и может включать цифры, точки и запятые!");
    }

    $file = "data.csv";

    if (!file_exists($file)) {
        file_put_contents($file, "=== ВОДИТЕЛИ ===\nИмя, Машина, Лицензия\n\n=== ЗАКАЗЫ ===\nКлиент, Откуда, Куда, Тариф\n\n");
    }

    $driverData = "\n === ВОДИТЕЛЬ === \n Имя: $driverName\n Машина: $car\n Номер водительских прав: $license\n";
    $orderData = "\n === ЗАКАЗ === \n Клиент: $customerName\n Откуда: $pickup\n Куда: $destination\n Тариф: $tariff\n";

    file_put_contents($file, $driverData, FILE_APPEND);
    file_put_contents($file, $orderData, FILE_APPEND);

    echo "<span style='color: green;'> Данные успешно сохранены!</span>";
}
?>
