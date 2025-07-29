<?php
session_start();
require_once '../includes/db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Lấy thông tin admin
$admin_name = $_SESSION['name'];
$admin_email = '';
$admin_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$stmt->bind_result($admin_email);
$stmt->fetch();
$stmt->close();

// Lấy số lượng user
$result = $conn->query("SELECT COUNT(*) FROM users");
$user_count = $result->fetch_row()[0];
$result->close();

// Lấy số lượng tài liệu
$result = $conn->query("SELECT COUNT(*) FROM uploads");
$doc_count = $result ? $result->fetch_row()[0] : 0;
if ($result) $result->close();

// Lấy số lượng đề thi
$result = $conn->query("SELECT COUNT(*) FROM uploads WHERE type = 'dethi'");
$exam_count = $result ? $result->fetch_row()[0] : 0;
if ($result) $result->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { margin:0; background:#f5f5f5; font-family:sans-serif; }
        .sidebar {
            width:260px; background:#43a047; color:#fff; height:100vh; position:fixed; left:0; top:0; display:flex; flex-direction:column; align-items:flex-start; padding:32px 0 32px 0; box-shadow:2px 0 8px rgba(0,0,0,0.05); z-index:100;
        }
        .sidebar .admin-info { padding:0 0 24px 0; border-bottom:1px solid #388e3c; width:100%; }
        .sidebar .admin-info .name { font-size:1.2em; font-weight:700; margin-bottom:4px; padding-left: 20px;}
        .sidebar .admin-info .email { font-size:0.98em; opacity:0.85; padding-left: 20px;}
        .sidebar .admin-info .logout-btn {
            display:block; color:#fff; text-decoration:none; padding:12px 0; font-size:1.08em; border:2px solid #fff; text-align:center; border-radius:6px; transition:background 0.2s, color 0.2s;
        }
        .sidebar nav { width:100%; margin-top:2px; }
        .sidebar nav a {
            display:block; color:#fff; text-decoration:none; padding:14px 32px; font-size:1.08em; border-bottom:1px solid #388e3c; transition:background 0.2s;
        }
        .sidebar nav a:hover { background:#388e3c; }
        .sidebar .logout {
            margin-top:auto; width:100%;
        }
        .sidebar .logout a {
            display:block; color:#e53935; background:#fff; text-decoration:none; padding:12px 0; font-size:1.08em; border:2px solid #e53935; text-align:center; border-radius:6px; transition:background 0.2s, color 0.2s;
        }
        .sidebar .logout a:hover {
            background:#e53935; color:#fff;
        }
        .main {
            margin-left:260px; padding:40px 32px;
        }
        .stats {
            display:flex; gap:32px; margin-bottom:32px;
        }
        .stat-box {
            background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:32px 40px; text-align:center; flex:1;
        }
        .stat-box h3 { color:#43a047; font-size:2em; margin:0 0 12px 0; }
        .stat-box p { font-size:1.08em; color:#333; margin:0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-info">
            <div class="name">👤 <?php echo htmlspecialchars($admin_name); ?></div>
            <div class="email">✉️ <?php echo htmlspecialchars($admin_email); ?></div>
            <a href="../auth/logout.php" class="logout-btn">Đăng xuất</a>
        </div>
        <nav>
            <a href="manage_subject.php">Quản lý danh mục</a>
            <a href="#">Quản lý người dùng</a>
            <a href="manage_docs.php">Quản lý tài liệu</a>
            <a href="manage_roles.php">Quản lý phân quyền</a>
            <a href="#">Quản lý nhận xét</a>
        </nav>
        <!-- Xóa nút đăng xuất phía dưới -->
    </div>
    <div class="main">
        <h1 style="color:#43a047;font-size:2.2em;font-weight:700;margin-bottom:32px;">Dashboard Admin</h1>
        <div class="stats">
            <div class="stat-box">
                <h3><?php echo $user_count; ?></h3>
                <p>Số lượng người dùng</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $doc_count; ?></h3>
                <p>Số lượng tài liệu đã tải lên</p>
            </div>
            <div class="stat-box">
                <h3><?php echo $exam_count; ?></h3>
                <p>Số lượng đề thi đã tải lên</p>
            </div>
        </div>
        <!-- Thêm nội dung dashboard khác tại đây -->
    </div>
</body>
</html>
