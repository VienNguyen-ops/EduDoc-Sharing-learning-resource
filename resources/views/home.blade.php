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
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTlurI7fy8fbvbUSDYRBBBXi6scHFwQQ3xyQ&s" alt="Profile"
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
                    <div class="search-bar" style="display: flex; justify-content: center; align-items: center; gap: 8px; margin: 16px 0;">
                        <button class="category-btn" style="padding: 8px 16px; background-color: #3ca23c; color: #fff; border: none; border-radius: 4px; cursor: pointer;"><i class="fa fa-bars"></i> Danh mục</button>
                        <input type="text" placeholder="Tìm kiếm tài liệu..." style="flex: 1; max-width: 600px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <button style="padding: 8px 16px; background-color: #3ca23c; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Tìm kiếm</button>
                    </div>
            
               
    <div class="container">
        <div class="welcome">
            <h1>Chào mừng đến với EduDoc!</h1>
            <p>Nền tảng chia sẻ tài liệu học tập cho sinh viên và giáo viên. Tìm kiếm, tải lên, và chia sẻ tài liệu dễ dàng.</p>
        </div>
        
        <div class="doc-list" style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
            @foreach($uploads as $upload)
                <div class="doc-card" style="background-color: #fff; padding: 16px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 250px; text-align: left; position: relative;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($upload->type === 'PDF')
                            <img src="https://surl.li/eixixz" alt="PDF" style="width: 40px; height: auto;">
                        @elseif($upload->file_type === 'word')
                            <img src="https://surl.li/nwiwah" alt="Word" style="width: 40px; height: auto;">
                        @elseif($upload->file_type === 'ppt')
                            <img src="https://surl.lu/vheiua" alt="PowerPoint" style="width: 40px; height: auto;">
                        @else
                            <img src="https://surl.li/ovblbz" alt="File" style="width: 40px; height: auto;">
                        @endif
                        
                    </div>
                    <img src="{{ asset('storage/' . $upload->image) }}" alt="{{ $upload->file_name }}" style="width:100%; height:auto; margin-top: 8px; border-radius: 4px;">
                    <span style="font-weight: bold; color: #333; ">{{ $upload->file_name }}</span>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #999; font-size: 12px;">{{ $upload->page_count ?? 'N/A' }} trang</span>
                        <a href="{{ route('detail', $upload->id) }}" target="_blank" style="text-decoration: none; color: #3ca23c; font-weight: bold;">Xem chi tiết</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <footer style="background-color: #f9f9f9; padding: 20px 0; border-top: 1px solid #ddd;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between;">
            <div>
                <h4>Giới thiệu</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #333;">Về chúng tôi</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Việc làm</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Quảng cáo</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Liên hệ</a></li>
                </ul>
            </div>
            <div>
                <h4>Chính sách</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #333;">Thỏa thuận sử dụng</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Chính sách bảo mật</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Chính sách hoàn tiền</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">DMCA</a></li>
                </ul>
            </div>
            <div>
                <h4>Hỗ trợ</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #333;">Hướng dẫn sử dụng</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Đăng ký tài khoản VIP</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Zalo/Tel: 098 765 4321</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Email: demo@edudoc.vn</a></li>
                </ul>
            </div>
            <div>
                <h4>Phương thức thanh toán</h4>
                <ul style="list-style: none; padding: 0; display: flex; gap: 20px; justify-content: center;">
                    <li><img src="https://surl.li/quslfc" alt="VNPay" style="width: 30px; height: auto;"></li>
                    <li><img src="https://surl.lt/woqqac" alt="MoMo" style="width: 30px; height: auto;"></li>
                    <li><img src="https://surl.li/tsbgnc" alt="Visa" style="width: 30px; height: auto;"></li>
                    <li><img src="https://surl.li/rnjlgy" alt="MasterCard" style="width: 30px; height: auto;"></li>
                </ul>
            </div>
            <div>
                <h4>Theo dõi chúng tôi</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #333;">Facebook</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">Youtube</a></li>
                    <li><a href="#" style="text-decoration: none; color: #333;">TikTok</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
