<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduDoc - Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <!-- @if(session('role') === 'teacher' && session('welcome_type', true))
        <div class="welcome-overlay">
            <h2>Xin chào, {{ optional(App\Models\User::find(session('user_id')))->name }} 👋</h2>
        </div>
        @php
            session(['welcome_type' => false]);
            session()->save();
        @endphp
    @elseif(session('is_new_user'))
        <div class="welcome-overlay">
            <h2>Chào mừng bạn! Bạn là người mới, hãy cùng khám phá nhé 🎉</h2>
        </div>
    @endif -->

    <div class="header">
        <div class="container">            
            <div class="nav">
                <span class="logo">EduDoc</span>
                <div class="menu">
                    <a href="#">Chăm sóc khách hàng</a>
                    <a href="#">Về chúng tôi</a>

                    @if(session('role') === 'teacher')
                        <a href="#">➕ Tạo khóa học</a>
                    @endif

                    @if(session('role') === 'student')
                        <a href="#">🎯 Định hướng nghề nghiệp</a>
                        <a href="#">📚 Tham gia khóa học</a>
                    @endif

                    <div class="user-info">
                        @if(session('role') === 'student' || session('role') === 'teacher')
                            <span style="display:inline-flex; align-items:center; margin-left:24px;">
                                <img src="https://i.imgur.com/0y0F0y0.png" alt="Profile"
                                    style="width:32px;height:32px;border-radius:50%;vertical-align:middle; margin-right: 8px;">
                                <strong>{{ optional(App\Models\User::find(session('user_id')))->name }}</strong>
                                <a href="{{ route('logout') }}" class="logout-link">Đăng xuất</a>
                            </span>
                        
                        @else
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            <a href="{{ route('register') }}">Đăng ký</a>
                        @endif
                    </div>
                </div>
            </div>
                <div style="clear: both;"></div>
                    <div class="search-bar">
                        <button class="category-btn"><i class="fa fa-bars"></i> Danh mục</button>
                        <input type="text" placeholder="Tìm kiếm tài liệu...">
                        <button>Tìm kiếm</button>
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
