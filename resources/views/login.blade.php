<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5 url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') no-repeat center center fixed; background-size: cover; }
        .login-container { width: 350px; margin: 80px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { text-align: center; color: #3ca23c; margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; color: #222; }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #3ca23c;
            box-shadow: 0 0 8px #3ca23c44;
            outline: none;
        }
        button {
            width: 100%;
            background: #3ca23c;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }
        button:hover {
            background: #319a31;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 12px rgba(60,162,60,0.15);
        }
        .login-container {
            animation: fadeIn 0.7s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error { color: red; text-align: center; margin-bottom: 12px; }
        .login-link { text-align: center; margin-top: 16px; }
        .login-link a { color: #3ca23c; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('login.check') }}">
            @csrf
            <label for="login">Tên hoặc email đăng nhập</label>
            <input type="text" id="login" name="login" required>
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <div class="login-link">
            <a href="#">Quên mật khẩu?</a>
        </div>
        <div class="login-link">
            Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
        </div>
    </div>
</body>
</html>
