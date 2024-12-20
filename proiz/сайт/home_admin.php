<<?php
session_start();

$servername = "134.90.167.42:10306";
$username = "Zhigailo";
$password = "Is6CJR";
$dbname = "project_Zhigailo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$isRegistrationMode = isset($_GET['mode']) ? $_GET['mode'] === 'register' : true;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
    $username = $_POST["username"];
    $password = $_POST["password"];
    $isRegistration = $_POST["isRegistration"] === "true";

    if ($isRegistration) {
        // Registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userType = $_POST["userType"];
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashedPassword, $userType);

        if ($stmt->execute()) {
            $message = "Регистрация успешна";
        } else {
            $message = "Ошибка при регистрации: " . $stmt->error;
        }
    } else {
        // Login
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    
                    switch ($user['role']) {
                        case 'admin':
                            header('Location: admin_dashboard.php');
                    }
                    exit();
                } else {
                    $error_message = "Неверный логин или пароль!";
                }
            }
                exit();
            } else {
            
            }
            
        }
    

    $stmt->close();


$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация и вход</title>
    <link rel="stylesheet" href="Style123.css">
    <div class="clickable-image">
    <a href="https://belovokyzgty.ru/" target="_blank">
    <img src="logo2.png" style="width: 200px; height: auto;">
    </a>
</div>
</head>
<body>
<div class="login-container">
    <h2><?php echo $isRegistrationMode ? 'Регистрация' : 'Вход'; ?></h2>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form id="userForm" action="" method="POST">
        <input type="text" placeholder="Имя пользователя" name="username" required>
        <input type="password" placeholder="Пароль" name="password" required>
        <?php if ($isRegistrationMode): ?>
            <select name="userType" required>
                <option value="">Выберите тип пользователя</option>
                <option value="admin">Администратор</option>
            </select>
        <?php endif; ?>
        <input type="hidden" name="isRegistration" value="<?php echo $isRegistrationMode ? 'true' : 'false'; ?>">
        <button type="submit"><?php echo $isRegistrationMode ? 'Зарегистрироваться' : 'Войти'; ?></button>
    </form>
    <a href="?mode=<?php echo $isRegistrationMode ? 'login' : 'register'; ?>">
        <?php echo $isRegistrationMode ? 'Переключить на вход' : 'Переключить на регистрацию'; ?>
    </a>
    </div>
    </body>
    </html>