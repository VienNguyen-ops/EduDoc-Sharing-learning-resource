<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f5f5f5; }
        .sidebar { width: 270px; background: #3ca23c; color: #fff; height: 100vh; position: fixed; left: 0; top: 0; padding-top: 32px; }
        .sidebar .admin-info { text-align: left; padding: 0 32px 24px 32px; border-bottom: 1px solid #fff2; }
        .sidebar .admin-info .fa-user { font-size: 2rem; margin-bottom: 8px; }
        .sidebar .admin-info .fa-envelope { margin-right: 8px; }
        .sidebar .admin-info .admin-name { font-weight: bold; font-size: 1.2rem; margin-bottom: 4px; }
        .sidebar .admin-info .admin-email { font-size: 1rem; margin-bottom: 12px; }
        .sidebar .logout-btn { background: #fff; color: #3ca23c; border: none; border-radius: 6px; padding: 10px 0; width: 100%; font-size: 1.1rem; font-weight: bold; margin-bottom: 24px; cursor: pointer; border: 2px solid #fff; }
        .sidebar .menu { list-style: none; padding: 0 0 0 0; margin: 0; }
        .sidebar .menu li { margin: 0; }
        .sidebar .menu li a { display: block; color: #fff; text-decoration: none; padding: 16px 32px; font-size: 1.1rem; border-bottom: 1px solid #fff2; transition: background 0.2s; }
        .sidebar .menu li a:hover, .sidebar .menu li a.active { background: #319a31; }
        .main { margin-left: 270px; padding: 32px; }
        .main h1 { color: #3ca23c; font-size: 2.2rem; margin-bottom: 32px; }
        .stats { display: flex; gap: 32px; }
        .stat-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; width: 320px; text-align: center; }
        .stat-card .stat-number { color: #3ca23c; font-size: 2.5rem; font-weight: bold; margin-bottom: 8px; }
        .stat-card .stat-label { font-size: 1.1rem; color: #222; }
        @media (max-width: 900px) {
            .main { margin-left: 0; padding: 16px; }
            .sidebar { position: static; width: 100%; height: auto; }
            .stats { flex-direction: column; gap: 16px; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-info">
            <div><i class="fa fa-user"></i> <span class="admin-name">Admin</span></div>
            <div><i class="fa fa-envelope"></i> <span class="admin-email">vien@gmail.com</span></div>
            <form method="GET" action="{{ route('logout') }}">
                <button type="submit" class="logout-btn">Đăng xuất</button>
            </form>
        </div>
        <ul class="menu">
            <li><a href="{{ route('categories_management') }}">Quản lý danh mục</a></li>
            <li><a href="{{ route('users_management') }}">Quản lý người dùng</a></li>
            <li><a href="#">Quản lý tài liệu</a></li>
            <li><a href="{{ route('roles_management') }}">Quản lý phân quyền</a></li>
            <li><a href="#">Quản lý nhận xét</a></li>
        </ul>
    </div>
    <div class="main">
        <h1>Dashboard Admin</h1>
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ $userCount }}</div>
                <div class="stat-label">Số lượng người dùng</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $documentCount }}</div>
                <div class="stat-label">Số lượng tài liệu đã tải lên</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $examCount }}</div>
                <div class="stat-label">Số lượng đề thi đã tải lên</div>
            </div>
        </div>
        <!-- Biểu đồ thống kê số người dùng và tài liệu tải nhiều nhất trong 1 tuần -->
        <div style="margin-top:40px; background:#fff; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:32px;">
            <h2 style="color:#3ca23c; margin-bottom:24px;">Thống kê truy cập & tài liệu tải nhiều nhất trong 1 tuần</h2>
            <canvas id="userChart" height="80"></canvas>
            <div style="margin-top:24px;">
                <ul style="font-size:1.1rem;">
                    <li><b>Toán cao cấp A1.pdf</b> - 32 lượt tải</li>
                    <li><b>Lập trình C cơ bản.docx</b> - 27 lượt tải</li>
                    <li><b>Tiếng Anh chuyên ngành.pdf</b> - 19 lượt tải</li>
                </ul>
            </div>
        </div>
        <!-- Tài liệu được xem nhiều nhất -->
        <div style="margin-top:32px; background:#fff; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:32px;">
            <h2 style="color:#3ca23c; margin-bottom:24px;">Tài liệu được xem nhiều nhất</h2>
            <ul style="font-size:1.1rem;">
                <li><b>Toán cao cấp A1.pdf</b> - 120 lượt xem</li>
                <li><b>Lập trình C cơ bản.docx</b> - 98 lượt xem</li>
                <li><b>Tiếng Anh chuyên ngành.pdf</b> - 85 lượt xem</li>
            </ul>
        </div>
        <!-- Bình luận nhiều cảm xúc nhất -->
        <div style="margin-top:32px; background:#fff; border-radius:16px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:32px;">
            <h2 style="color:#3ca23c; margin-bottom:24px;">Bình luận nhiều người thả cảm xúc nhất</h2>
            <ul style="font-size:1.1rem;">
                <li><b>"Tài liệu này quá hữu ích!"</b> - 32 cảm xúc 👍❤️😂</li>
                <li><b>"Cảm ơn admin đã chia sẻ!"</b> - 27 cảm xúc 👍❤️</li>
                <li><b>"Ai có đáp án không?"</b> - 19 cảm xúc 😂👍</li>
            </ul>
        </div>
    </div>
</body>

<!-- Thêm Chart.js cho biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
            datasets: [
                {
                    label: 'Số người dùng',
                    data: [12, 19, 15, 22, 18, 25, 20], // số liệu ảo
                    backgroundColor: 'rgba(60,162,60,0.2)',
                    borderColor: '#3ca23c',
                    borderWidth: 3,
                    pointBackgroundColor: '#3ca23c',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Tài liệu tải nhiều nhất',
                    data: [5, 8, 6, 10, 7, 12, 9], // số liệu ảo
                    backgroundColor: 'rgba(231,76,60,0.15)',
                    borderColor: '#e74c3c',
                    borderWidth: 3,
                    pointBackgroundColor: '#e74c3c',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 5
                }
            }
        }
    });
</script>
</html>
