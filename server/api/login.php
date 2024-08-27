<?php
require_once '../database.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$conn = getDB();

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(['success' => true, 'message' => 'Вход успешен']);
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный email или пароль']);
}

$stmt->close();
$conn->close();
?>
