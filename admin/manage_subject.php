<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
session_start();
require_admin();

$message = '';
// Thêm môn học
if (isset($_POST['add_subjects'])) {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare('INSERT INTO subjects (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $message = 'Thêm môn học thành công!';
        } else {
            $message = 'Lỗi khi thêm môn học.';
        }
        $stmt->close();
    }
}
// Sửa môn học
if (isset($_POST['edit_subjects'])) {
    $id = intval($_POST['subjects_id']);
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare('UPDATE subjects SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        if ($stmt->execute()) {
            $message = 'Cập nhật môn học thành công!';
        } else {
            $message = 'Lỗi khi cập nhật môn học.';
        }
        $stmt->close();
    }
}
// Xóa môn học
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare('DELETE FROM subjects WHERE id = ?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $message = 'Xóa môn học thành công!';
    } else {
        $message = 'Lỗi khi xóa môn học.';
    }
    $stmt->close();
}
// Lấy danh sách môn học
$subjects = [];
$result = $conn->query('SELECT id, name FROM subjects ORDER BY id ASC');
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $result->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý môn học</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { margin:0; background:#f5f5f5; font-family:sans-serif; }
        .sidebar { width:260px; background:#43a047; color:#fff; height:100vh; position:fixed; left:0; top:0; display:flex; flex-direction:column; align-items:flex-start; padding:32px 0 32px 0; box-shadow:2px 0 8px rgba(0,0,0,0.05); z-index:100; }
        .sidebar .admin-info { padding:0 0 24px 0; border-bottom:1px solid #388e3c; width:100%; }
        .sidebar .admin-info .name { font-size:1.2em; font-weight:700; margin-bottom:4px; padding-left: 20px; }
        .sidebar .admin-info .email { font-size:0.98em; opacity:0.85; padding-left: 20px; }
        .sidebar .admin-info .logout-btn { display:block; color:#fff; text-decoration:none; padding:12px 0; font-size:1.08em; border:2px solid #fff; text-align:center; border-radius:6px; transition:background 0.2s, color 0.2s; }
        .sidebar nav { width:100%; margin-top:2px; }
        .sidebar nav a { display:block; color:#fff; text-decoration:none; padding:14px 32px; font-size:1.08em; border-bottom:1px solid #388e3c; transition:background 0.2s; }
        .sidebar nav a:hover { background:#388e3c; }
        .main { margin-left:260px; padding:40px 32px; }
        table { width:100%; border-collapse:collapse; margin-top:18px; }
        th, td { padding:10px 8px; border:1px solid #ccc; }
        th { background:#e0f2f1; }
        .action-btn { margin-right:8px; color:#388e3c; text-decoration:none; font-weight:500; }
        .action-btn.reject { color:#e53935; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="admin-info">
            <div class="name">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></div>
            <div class="email">✉️ <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?></div>
            <a href="../auth/logout.php" class="logout-btn">Đăng xuất</a>
        </div>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="manage_subject.php">Quản lý danh mục</a>
            <a href="#">Quản lý người dùng</a>
            <a href="manage_docs.php">Quản lý tài liệu</a>
            <a href="manage_roles.php">Quản lý phân quyền</a>
            <a href="#">Quản lý nhận xét</a>
        </nav>
    </div>
    <div class="main">
        <h2 style="color:#43a047;text-align:center;margin-bottom:28px;">Quản lý môn học</h2>
        <?php if ($message) show_alert($message, strpos($message,'thành công')!==false?'success':'error'); ?>
        <form method="post" style="margin-bottom:24px;background:#e0f2f1;padding:18px 24px;border-radius:8px;max-width:500px;">
            <h3 style="margin-top:0;color:#388e3c;">Thêm môn học mới</h3>
            <div style="margin-bottom:12px;">
                <label for="name" style="font-weight:500;">Tên môn học:</label><br>
                <input type="text" name="name" id="name" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
            </div>
            <button type="submit" name="add_subjects" style="background:#43a047;color:#fff;border:none;padding:8px 20px;border-radius:4px;cursor:pointer;font-weight:500;">Thêm môn học</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên môn học</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?php echo $subject['id']; ?></td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $subject['id']): ?>
                        <form method="post" style="display:flex;gap:8px;align-items:center;">
                            <input type="hidden" name="subjects_id" value="<?php echo $subject['id']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" required style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                            <button type="submit" name="edit_subjects" style="background:#43a047;color:#fff;border:none;padding:6px 14px;border-radius:4px;cursor:pointer;font-weight:500;">Lưu</button>
                        </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars($subject['name']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?edit=<?php echo $subject['id']; ?>" class="action-btn">Sửa</a>
                        <a href="?delete=<?php echo $subject['id']; ?>" class="action-btn reject" onclick="return confirm('Bạn có chắc muốn xóa môn học này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
