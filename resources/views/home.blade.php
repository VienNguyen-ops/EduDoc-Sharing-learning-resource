<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduDoc - Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #fff; margin: 0; }
        .header { background: #f8f8f8; padding: 16px 0; border-bottom: 1px solid #eee; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        .logo { color: #3ca23c; font-size: 2rem; font-weight: bold; float: left; }
        .nav { float: right; }
        .nav a { color: #444; text-decoration: none; margin-left: 24px; font-size: 1rem; }
        .search-bar { display: flex; align-items: center; margin: 32px 0 0 0; }
        .search-bar input { padding: 8px 12px; font-size: 1rem; border: 1px solid #ccc; border-radius: 4px; width: 250px; margin-right: 8px; }
        .search-bar button { background: #3ca23c; color: #fff; border: none; padding: 8px 24px; border-radius: 4px; font-size: 1rem; cursor: pointer; }
        .category-btn { background: #fff; border: 1px solid #3ca23c; color: #3ca23c; padding: 8px 16px; border-radius: 4px; font-size: 1rem; margin-right: 16px; cursor: pointer; display: flex; align-items: center; }
        .category-btn i { margin-right: 8px; }
        .welcome { text-align: center; margin: 48px 0 24px 0; }
        .welcome h1 { color: #3ca23c; font-size: 2.5rem; margin-bottom: 16px; }
        .welcome p { font-size: 1.2rem; color: #222; }
        .doc-list { display: flex; justify-content: center; margin-top: 32px; }
        .doc-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; width: 350px; text-align: center; }
        .doc-card img { width: 100px; height: auto; margin-bottom: 16px; border-radius: 8px; }
        .doc-card a { color: #3ca23c; font-weight: bold; font-size: 1.1rem; text-decoration: none; }
        @media (max-width: 600px) {
            .container { width: 98%; }
            .doc-list { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <span class="logo">EduDoc</span>
            <div class="nav">
                <a href="#">Chăm sóc khách hàng</a>
                <a href="#">Về chúng tôi</a>
                @if(session('role') && session('role') === 'student')
                    <span style="margin-left:24px;">
                        <img src="https://i.imgur.com/0y0F0y0.png" alt="Profile" style="width:32px;height:32px;border-radius:50%;vertical-align:middle;">
                        <strong>{{ optional(App\Models\User::find(session('user_id')))->name }}</strong>
                        <a href="{{ route('logout') }}" style="margin-left:16px;color:#3ca23c;font-weight:bold;">Đăng xuất</a>
                    </span>
                @else
                    <a href="{{ route('login') }}">Đăng nhập</a>
                    <a href="{{ route('register') }}">Đăng ký</a>
                @endif
                
            </div>
            <div style="clear: both;"></div>
            <div class="search-bar">
                <button class="category-btn"><i class="fa fa-bars"></i> Danh mục</button>
                <input type="text" placeholder="Tìm kiếm tài liệu...">
                <button>Tìm kiếm</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="welcome">
            <h1>Chào mừng đến với EduDoc!</h1>
            <p>Nền tảng chia sẻ tài liệu học tập cho sinh viên và giáo viên. Tìm kiếm, tải lên, và chia sẻ tài liệu dễ dàng.</p>
        </div>
        <div class="doc-list">
            <div class="doc-card">
                <img src="https://i.imgur.com/0y0F0y0.png" alt="Báo cáo Thực tập">
                <a href="#">Báo cáo Thực tập</a>
            </div>
        </div>
    </div>
</body>
</html>
