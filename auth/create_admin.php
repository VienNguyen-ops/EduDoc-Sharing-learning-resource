<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
$name = 'Admin';
$email = 'vien@gmail.com';
$plain_password = '123';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $name, $email, $hashed_password, $role);
if ($stmt->execute()) {
    echo "Tạo tài khoản admin thành công!";
} else {
    echo "Lỗi: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
