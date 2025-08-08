<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng xuất</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .logout-container { width: 370px; margin: 80px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; text-align: center; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        button { background: #3ca23c; color: #fff; border: none; padding: 12px 32px; border-radius: 6px; font-size: 1.1rem; cursor: pointer; font-weight: bold; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2 style="color:#3ca23c;">Cảm ơn đã sử dụng dịch vụ của chúng tôi</h2>
        <a href="{{ url('/') }}">
            <button style="background:#3ca23c;color:#fff;border:none;padding:12px 32px;border-radius:6px;font-size:1.1rem;font-weight:bold;">Về trang chủ</button>
        </a>
    </div>
</body>
</html>
