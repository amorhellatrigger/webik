<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Такси-сервис</title>
    <script>
       function validateForm(event) {
    event.preventDefault();
    let valid = true;
    let errors = [];

    function isOnlyLetters(str) {
        return /^[A-Za-zА-Яа-яЁё\s-]+$/.test(str);
    }

    function isNotOnlyNumbers(str) {
        return !/^\d+$/.test(str);
    }

    function isValidLicense(str) {
        return /^\d{10}$/.test(str);
    }

   function isValidAddress(str) {
        return /^[A-Za-zА-Яа-яЁё0-9\s.,/-]+$/.test(str) && /[A-Za-zА-Яа-яЁё]/.test(str);
    }

    let form = document.forms["mainForm"];
    let driverName = form["driver_name"].value.trim();
    let car = form["car"].value.trim();
    let license = form["license"].value.trim();
    let customerName = form["customer_name"].value.trim();
    let pickup = form["pickup"].value.trim();
    let destination = form["destination"].value.trim();
    let tariff = form["tariff"].value.trim();

    if (driverName === "" || car === "" || license === "" || customerName === "" || pickup === "" || destination === "" || tariff === "") {
        errors.push(" Ошибка: Все поля должны быть заполнены!");
        valid = false;
    }

    if (!isOnlyLetters(driverName)) {
        errors.push(" Имя водителя должно содержать только буквы!");
        valid = false;
    }
    if (!isNotOnlyNumbers(car)) {
        errors.push(" Название машины не может состоять только из цифр!");
        valid = false;
    }
    if (!isValidLicense(license)) {
        errors.push(" Номер водительского удостоверения должен содержать ровно 10 цифр!");
        valid = false;
    }
    if (!isOnlyLetters(customerName)) {
        errors.push(" Имя клиента должно содержать только буквы!");
        valid = false;
    }
    if (!isValidAddress(pickup)) {
        errors.push(" Поле 'Откуда' должно содержать буквы и может включать спец.символы!");
        valid = false;
    }
    if (!isValidAddress(destination)) {
        errors.push(" Поле 'Куда' должно содержать буквы и может включать спец.символы!");
        valid = false;
    }

    if (valid) {
        let formData = new FormData(form);
        fetch("save.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("formMessages").innerHTML = data;
            document.getElementById("downloadButton").style.display = "block";
        })
        .catch(error => console.error("Ошибка:", error));
    } else {
        document.getElementById("formMessages").innerHTML = errors.join("<br>");
    }
}
    </script>
</head>
<body>
    <h2>Такси-сервис</h2>
    <form name="mainForm" method="post" onsubmit="validateForm(event)">
        <h3>Добавить данные о водителе</h3>
        Имя водителя: <input type="text" name="driver_name"><br>
        Машина: <input type="text" name="car"><br>
        Номер водительского удостоверения (10 цифр): <input type="text" name="license"><br>

        <h3>Добавить данные о заказе</h3>
        Имя клиента: <input type="text" name="customer_name"><br>
        Откуда: <input type="text" name="pickup"><br>
        Куда: <input type="text" name="destination"><br>
        Тариф:
        <select name="tariff">
            <option value="Эконом">Эконом</option>
            <option value="Бизнес">Бизнес</option>
            <option value="Комфорт">Комфорт</option>
        </select><br>

        <button type="submit"> Сохранить все данные</button>
    </form>
    <div id="formMessages" style="color: red;"></div>

    <!-- Кнопка для скачивания CSV -->
    <button id="downloadButton" style="display: none; margin-top: 10px;" onclick="window.location.href='download.php'">
         Скачать CSV
    </button>
</body>
</html>
