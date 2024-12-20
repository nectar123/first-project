<<?php
$host = 'localhost';
$dbname = 'shoe_store';
$username = 'username';
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Connection error: " . $e->getMessage());
    die("An error occurred. Please try again later.");
}
?>    