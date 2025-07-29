
<?php
require_once '../includes/functions.php';
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã đăng xuất</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background:#7fc97f;display:flex;align-items:center;justify-content:center;min-height:100vh;">
  <div style="background:#fff;padding:40px 30px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);width:350px;text-align:center;">
    <h2 style="color:#43a047;margin-bottom:24px;">Cảm ơn đã sử dụng dịch vụ của chúng tôi!</h2>
    <a href="../index.php" style="display:inline-block;background:#43a047;color:#fff;padding:12px 32px;border-radius:4px;text-decoration:none;font-weight:500;font-size:1em;">Về trang chủ</a>
  </div>
</body>
</html>
