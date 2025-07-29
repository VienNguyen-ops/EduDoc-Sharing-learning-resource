
<?php
require_once '../includes/functions.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../includes/db_connect.php';
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT id, name, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashed_password, $role);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $role;
            if ($role == 'admin') {
                header('Location: ../admin/admin_dashboard.php');
                exit();
            } else {
                header('Location: ../index.php');
                exit();
            }
        } else {
            $error = "Sai mật khẩu.";
        }
    } else {
        $error = "Tài khoản không tồn tại.";
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
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div style="background:#7fc97f;height:100vh;display:flex;align-items:center;justify-content:center;">
      <div style="background:#fff;padding:40px 30px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);width:350px;">
        <h2 style="text-align:center;margin-bottom:30px;font-size:2em;font-weight:500;">Login Form</h2>
        <?php
        if (isset($error)) {
            echo '<p style="color:red;text-align:center;">' . $error . '</p>';
        }
        ?>
        <form action="login.php" method="post" style="display:flex;flex-direction:column;gap:18px;">
          <input type="email" name="email" placeholder="Email" required style="padding:12px 10px;font-size:1em;border:1px solid #eee;border-radius:4px;background:#f5f5f5;">
          <input type="password" name="password" placeholder="password" required style="padding:12px 10px;font-size:1em;border:1px solid #eee;border-radius:4px;background:#f5f5f5;">
          <button type="submit" style="background:#43a047;color:#fff;padding:12px 0;font-size:1em;border:none;border-radius:4px;cursor:pointer;font-weight:500;">LOGIN</button>
        </form>
        <div style="text-align:center;margin-top:18px;">
          <span>Bạn chưa có tài khoản?</span>
          <a href="register.php" style="color:#43a047;font-weight:500;text-decoration:none;">Đăng ký</a>
        </div>
      </div>
    </div>
</body>
</html>
