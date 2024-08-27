<?php
require_once '../database.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$conn = getDB();

$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Регистрация прошла успешно']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка регистрации']);
}

$stmt->close();
$conn->close();
?>
