<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thông tin tài khoản</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
      color: #333;
    }

    .container {
      max-width: 1100px;
      margin: 50px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 32px 40px;
    }

    .header {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 32px;
    }

    .avatar {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background-color: #e0e7ff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 28px;
      color: #4f46e5;
      font-weight: 600;
    }

    .header h1 {
      font-size: 22px;
      font-weight: 700;
      color: #1e293b;
      margin: 0;
    }

    .grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 24px;
    }

    .card {
      background: #fafafa;
      border-radius: 12px;
      padding: 20px 24px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .card h2 {
      font-size: 18px;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 16px;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid #e5e7eb;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-item span {
      font-size: 15px;
      color: #555;
    }

    .edit-link {
      font-size: 14px;
      color: #2563eb;
      cursor: pointer;
      text-decoration: none;
    }

    .edit-link:hover {
      text-decoration: underline;
    }

    .btn {
      display: inline-block;
      background-color: #f59e0b;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
      text-align: center;
    }

    .btn:hover {
      background-color: #d97706;
    }

    .stats {
      margin-top: 8px;
      font-size: 14px;
      color: #555;
    }

    @media (max-width: 768px) {
      .grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="{{ url('/') }}" class="back-btn" title="Quay về trang chủ">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <div class="avatar">
    <img src="{{ optional(App\Models\User::find(session('user_id')))->avt ? asset('storage/' . optional(App\Models\User::find(session('user_id')))->avt) : 'https://via.placeholder.com/64' }}" alt="Avatar" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover;">
  </div>
      <h1>Thông tin tài khoản</h1>
    </div>

    <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
      @csrf
      <label for="avatar">Cập nhật ảnh đại diện:</label>
      <input type="file" name="avatar" id="avatar" accept="image/*" required>
      <button type="submit" class="btn">Cập nhật</button>
    </form>

    <div class="grid">
      <!-- Cột trái -->
      <div class="card">
        <h2>Thông tin cá nhân</h2>
        <div class="info-item">
          <span><strong>Họ tên:</strong></span>
          <span>{{ optional(App\Models\User::find(session('user_id')))->name }}</span>
        </div>
        <div class="info-item">
          <span><strong>Email:</strong></span>
          <span>{{ optional(App\Models\User::find(session('user_id')))->email }}</span>
        </div>
        <div class="info-item">
          <span><strong>Tài khoản:</strong></span>
          <span>{{ session('role') }}</span>
        </div>
        <div class="info-item">
          <span><strong>Mật khẩu:</strong></span>
          <a href="#" class="edit-link">Chỉnh sửa</a>
        </div>
      </div>

      <!-- Cột phải -->
      <div class="card">
        <h2>Gói thành viên</h2>
        <p>Chỉ với một gói đăng ký, bạn được phép tải không giới hạn hàng nghìn tài liệu học tập, bài giảng, và đề thi chất lượng.</p>
        <a href="#" class="btn"><i class="fa-solid fa-crown"></i> Nâng cấp VIP</a>

        <div class="stats">
          <p><strong>Tài liệu đã up:</strong> {{ App\Models\Upload::where('user_id', session('user_id'))->count() }}</p>
          <p><strong>Lượt tải:</strong> còn 0 lượt tải</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
