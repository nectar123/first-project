<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $role])) {
        echo "Пользователь зарегистрирован!";
    } else {
        echo "Ошибка регистрации!";
    }
}
?>

<form method="post">
    Логин: <input type="text" name="username" required>
    Пароль: <input type="password" name="password" required>
    Роль: 
    <select name="role" required>
        <option value="admin">Админ</option>
        <option value="seller">Продавец</option>
        <option value="customer">Клиент</option>
    </select>
    <button type="submit">Регистрация</button>
</form>
