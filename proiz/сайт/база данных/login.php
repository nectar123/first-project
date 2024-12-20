<?php
require_once 'db.php';

$username = $_POST['username'] ?? false;
$password = $_POST['password'] ?? false;
$user_type = $_POST['user_type'] ?? false;

if (check_auth()) {
    header('Location: /');
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on user role
        switch ($user['role']) {
            case 'admin':
                header('Location: admin_dashboard.php');
                break;
            case 'user':
                header('Location: user_dashboard.php');
                break;
            case 'seller':
                header('Location: seller_dashboard.php');
                break;
            default:
                header('Location: index.php');
                break;
        }
        exit();
    } else {
        $error_message = "Неверный логин или пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        Логин: <input type="text" name="username" required><br>
        Пароль: <input type="password" name="password" required><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
