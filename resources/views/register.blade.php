<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5 url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80') no-repeat center center fixed; background-size: cover; }
        .register-container { width: 370px; margin: 80px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { text-align: center; color: #3ca23c; margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; color: #222; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #3ca23c;
            box-shadow: 0 0 8px #3ca23c44;
            outline: none;
        }
        .show-password { margin-bottom: 16px; }
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
        .login-link { text-align: center; margin-top: 16px; }
        .login-link a { color: #3ca23c; text-decoration: none; font-weight: bold; }
        .error { color: red; text-align: center; margin-bottom: 12px; }
        .register-container {
            animation: fadeIn 0.7s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        function togglePassword() {
            var pwd = document.getElementById('password');
            pwd.type = pwd.type === 'password' ? 'text' : 'password';
        }
    </script>
</head>
<body>
    <div class="register-container">
        <h2>Đăng ký</h2>
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('register.check') }}">
            @csrf
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
            <div class="show-password">
                <input type="checkbox" onclick="togglePassword()"> Hiển thị mật khẩu
            </div>
            <button type="submit">Đăng ký</button>
        </form>
        <div class="login-link">
            Đã có tài khoản? <a href="{{ route('login') }}">Quay lại đăng nhập</a>
        </div>
    </div>
</body>
</html>
