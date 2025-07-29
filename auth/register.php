<?php
require_once '../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../includes/db_connect.php';
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'student';

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra email đã tồn tại chưa
    $check_query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $error = "Email đã được sử dụng.";
    } else {
        // Thêm người dùng mới
        $insert_query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('ssss', $name, $email, $hashed_password, $role);
        if ($stmt->execute()) {
            $success = "Đăng ký thành công!";
        } else {
            $error = "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="background:#7fc97f;display:flex;align-items:center;justify-content:center;min-height:100vh;">
      <div style="background:#fff;padding:40px 30px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);width:350px;">
        <h2 style="text-align:center;margin-bottom:30px;font-size:2em;font-weight:500;">Register Form</h2>
        <?php
        if (isset($error)) {
            echo '<p style="color:red;text-align:center;">' . $error . '</p>';
        }
        if (isset($success)) {
            echo '<p style="color:green;text-align:center;">' . $success . '</p>';
        }
        ?>
        <form action="register.php" method="post" style="display:flex;flex-direction:column;gap:18px;">
          <input type="text" name="username" placeholder="username" required style="padding:12px 10px;font-size:1em;border:1px solid #eee;border-radius:4px;background:#f5f5f5;">
          <input type="email" name="email" placeholder="Email" required style="padding:12px 10px;font-size:1em;border:1px solid #eee;border-radius:4px;background:#f5f5f5;">
          <input type="password" name="password" placeholder="password" required style="padding:12px 10px;font-size:1em;border:1px solid #eee;border-radius:4px;background:#f5f5f5;">
          <button type="submit" style="background:#43a047;color:#fff;padding:12px 0;font-size:1em;border:none;border-radius:4px;cursor:pointer;font-weight:500;">REGISTER</button>
        </form>
        <div style="text-align:center;margin-top:18px;">
          <span>Bạn đã có tài khoản?</span>
          <a href="login.php" style="color:#43a047;font-weight:500;text-decoration:none;">Đăng nhập</a>
        </div>
      </div>
    </div>
</body>
</html>
