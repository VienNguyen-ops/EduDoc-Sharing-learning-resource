
<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
session_start();
require_admin();

$message = '';
if (isset($_POST['add_role'])) {
    $role_name = trim($_POST['role_name']);
    if ($role_name !== '') {
        $stmt = $conn->prepare('INSERT INTO role (name) VALUES (?)');
        $stmt->bind_param('s', $role_name);
        if ($stmt->execute()) {
            $message = 'Thêm quyền thành công!';
        } else {
            $message = 'Lỗi khi thêm quyền.';
        }
        $stmt->close();
    }
}

if (isset($_GET['delete'])) {
    $role_id = intval($_GET['delete']);
    $stmt = $conn->prepare('DELETE FROM role WHERE id = ?');
    $stmt->bind_param('i', $role_id);
    if ($stmt->execute()) {
        $message = 'Xóa quyền thành công!';
    } else {
        $message = 'Lỗi khi xóa quyền.';
    }
    $stmt->close();
}

if (isset($_POST['edit_role'])) {
    $role_id = intval($_POST['role_id']);
    $role_name = trim($_POST['role_name']);
    if ($role_name !== '') {
        $stmt = $conn->prepare('UPDATE role SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $role_name, $role_id);
        if ($stmt->execute()) {
            $message = 'Cập nhật quyền thành công!';
        } else {
            $message = 'Lỗi khi cập nhật quyền.';
        }
        $stmt->close();
    }
}

$roles = [];
$result = $conn->query('SELECT id, name FROM role ORDER BY id ASC');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
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
    <title>Quản lý phân quyền</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
        .main {
            margin-left:260px; padding:40px 32px;
        }
        .back-btn {
            display:inline-block; margin-bottom:18px; background:#e0f2f1; color:#388e3c; border:none; border-radius:4px; padding:8px 18px; font-weight:500; text-decoration:none; transition:background 0.2s;
        }
        .back-btn:hover { background:#b2dfdb; }
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
            <a href="manage_roles.php" style="background:#388e3c;">Quản lý phân quyền</a>
            <a href="#">Quản lý nhận xét</a>
        </nav>
    </div>
    <div class="main">
        
        <h2 style="color:#43a047;text-align:center;margin-bottom:28px;">Quản lý phân quyền</h2>
        <?php if ($message) show_alert($message, strpos($message,'thành công')!==false?'success':'error'); ?>
        <form method="post" style="display:flex;gap:12px;margin-bottom:24px;">
            <input type="text" name="role_name" placeholder="Tên quyền mới" required style="flex:1;padding:10px 12px;border:1px solid #ccc;border-radius:4px;">
            <button type="submit" name="add_role" style="background:#43a047;color:#fff;border:none;padding:10px 18px;border-radius:4px;cursor:pointer;font-weight:500;">Thêm quyền</button>
        </form>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#e0f2f1;">
                    <th style="padding:10px 8px;border:1px solid #ccc;">ID</th>
                    <th style="padding:10px 8px;border:1px solid #ccc;">Tên quyền</th>
                    <th style="padding:10px 8px;border:1px solid #ccc;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $role): ?>
                <tr>
                    <td style="padding:8px;border:1px solid #eee;"><?php echo $role['id']; ?></td>
                    <td style="padding:8px;border:1px solid #eee;">
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $role['id']): ?>
                        <form method="post" style="display:flex;gap:8px;align-items:center;">
                            <input type="hidden" name="role_id" value="<?php echo $role['id']; ?>">
                            <input type="text" name="role_name" value="<?php echo htmlspecialchars($role['name']); ?>" required style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                            <button type="submit" name="edit_role" style="background:#43a047;color:#fff;border:none;padding:6px 14px;border-radius:4px;cursor:pointer;font-weight:500;">Lưu</button>
                        </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars($role['name']); ?>
                        <?php endif; ?>
                    </td>
                    <td style="padding:8px;border:1px solid #eee;">
                        <a href="?edit=<?php echo $role['id']; ?>" style="color:#388e3c;margin-right:10px;text-decoration:none;">Sửa</a>
                        <a href="?delete=<?php echo $role['id']; ?>" style="color:#e53935;text-decoration:none;" onclick="return confirm('Bạn có chắc muốn xóa quyền này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
