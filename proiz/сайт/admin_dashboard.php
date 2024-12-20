<?php
$servername = "134.90.167.42:10306";
$username = "Zhigailo";
$password = "Is6CJR";
$dbname = "project_Zhigailo";

$connect = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$message = ""; // Переменная для хранения сообщения

// Обработка формы добавления пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $ID = $_POST['ID']; // Получаем ID из формы  
    $role = $_POST['Kulture'];                                        
    $username = $_POST['Size']; // Changed from 'username' to 'login' to match the form
    $password = $_POST['Status'];

    $ID = $connect->real_escape_string($ID);
    $role = $connect->real_escape_string($role);
    $username = $connect->real_escape_string($username); // Changed from $login to $username
    $password = $connect->real_escape_string($password);

    // Вставка нового пользователя в базу данных
    $query = "INSERT INTO `Main`(`ID`, `Kulture`, `Size`, `Status`) VALUES ('$ID', '$Kulture','$Size','$Status')";
    $result = mysqli_query($connect, $query);
    if ($result) {
        $message = "<p style='color: green;'>Партия успешно добавлен!</p>";
    } else {
        $message = "<p style='color: red;'>Ошибка: " . $connect->error . "</p>";
    }
          }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update_role') 
        $ID_to_update = $_POST['ID_to_update'];
        $new_role = $_POST['new_role'];
    
        $ID_to_update = $connect->real_escape_string($ID_to_update);
        $new_role = $connect->real_escape_string($new_role);
    
        
    // Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $ID_to_delete = $_POST['ID_to_delete'];
    $ID_to_delete = $connect->real_escape_string($ID_to_delete);

    // SQL query to delete the user
    $delete_query = "DELETE FROM `Main` WHERE `ID` = '$ID_to_delete'";
    if ($connect->query($delete_query) === TRUE) {
        $message = "<p style='color: green;'>Партия успешно удалена!</p>";
    } else {
        $message = "<p style='color: red;'>Ошибка при удалении партии: " . $connect->error . "</p>";
    }
}

// Получение всех пользователей из базы данных
$sql = "SELECT ID, Kulture, Size, Status FROM Main"; 
$result = $connect->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель админа</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
      body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #b2c3d5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff; /* Цвет кнопки */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Цвет кнопки при наведении */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <div class="container">
    <h1>Панель админа</h1>
        <h2>Добавить партию</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="add">
            <label for="ID">ID:</label>
            <input type="text" id="ID" name="ID" required>

            <label for="username">Культура:</label>
            <input type="text" id="Kulture" name="Kulture" required>

            <label for="password">Вес:</label>
            <input type="Size" id="password" name="Size" required>

            <label for="password">Статус:</label>
            <input type="Statys" id="password" name="Statys" required>
            <input type="submit" value="Добавить партию">
        </form>

        <?php if ($message != ""): ?>
            <div style="text-align: center; margin-bottom: 20px;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <h2>Список партий</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Культура</th>
                <th>Вес</th>
                <th>Статус</th>
                <th>Удалить</th>
            </tr>
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['ID']."</td>";
                    echo "<td>".$row['Kulture']."</td>";
                    echo "<td>".$row['Size']."</td>";
                    echo "<td>".$row['Status']."</td>";
                    echo "<td>
                        <form method='POST' action='' style='display:inline;'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='ID_to_delete' value='".$row['ID']."'>
                            <input type='submit' value='Удалить' onclick='return confirm(\"Вы уверены, что хотите удалить эту партию?\");' style='background-color: #dc3545;'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Нет партий</td></tr>";
            }
            ?>
        </table>