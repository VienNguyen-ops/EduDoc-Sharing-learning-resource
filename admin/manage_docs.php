<?php
require_once '../includes/functions.php';
require_once '../includes/db_connect.php';
session_start();
require_admin();

$message = '';

// Xử lý duyệt tài liệu
if (isset($_GET['approve'])) {
    $doc_id = intval($_GET['approve']);
    $stmt = $conn->prepare('UPDATE uploads SET approved = 1 WHERE id = ?');
    $stmt->bind_param('i', $doc_id);
    if ($stmt->execute()) {
        $message = 'Tài liệu đã được duyệt!';
    } else {
        $message = 'Lỗi khi duyệt tài liệu.';
    }
    $stmt->close();
}

// Xử lý không duyệt tài liệu
if (isset($_GET['reject'])) {
    $doc_id = intval($_GET['reject']);
    $stmt = $conn->prepare('UPDATE uploads SET approved = 0 WHERE id = ?');
    $stmt->bind_param('i', $doc_id);
    if ($stmt->execute()) {
        $message = 'Tài liệu đã bị từ chối!';
    } else {
        $message = 'Lỗi khi từ chối tài liệu.';
    }
    $stmt->close();
}

// Xử lý xóa tài liệu
if (isset($_GET['delete'])) {
    $doc_id = intval($_GET['delete']);
    $stmt = $conn->prepare('DELETE FROM uploads WHERE id = ?');
    $stmt->bind_param('i', $doc_id);
    if ($stmt->execute()) {
        $message = 'Xóa tài liệu thành công!';
    } else {
        $message = 'Lỗi khi xóa tài liệu.';
    }
    $stmt->close();
}

// Xử lý sửa tài liệu
if (isset($_POST['edit_doc'])) {
    $doc_id = intval($_POST['doc_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    if ($title !== '') {
        $stmt = $conn->prepare('UPDATE uploads SET title = ?, description = ? WHERE id = ?');
        $stmt->bind_param('ssi', $title, $description, $doc_id);
        if ($stmt->execute()) {
            $message = 'Cập nhật tài liệu thành công!';
        } else {
            $message = 'Lỗi khi cập nhật tài liệu.';
        }
        $stmt->close();
    }
}

// Lấy toàn bộ dữ liệu bảng uploads kèm tên người đăng và tên môn học
$docs = [];
$sql = 'SELECT u.id, u.title, u.description, u.filename, u.image, u.approved, u.uploader_id, u.subject_id, 
        us.name AS uploader_name, s.name AS subject_name
        FROM uploads u
        LEFT JOIN users us ON u.uploader_id = us.id
        LEFT JOIN subjects s ON u.subject_id = s.id
        ORDER BY u.id DESC';
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $docs[] = $row;
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
    <title>Quản lý tài liệu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { margin:0; background:#f5f5f5; font-family:sans-serif; }
        .sidebar {
            width:260px; background:#43a047; color:#fff; height:100vh; position:fixed; left:0; top:0; display:flex; flex-direction:column; align-items:flex-start; padding:32px 0 32px 0; box-shadow:2px 0 8px rgba(0,0,0,0.05); z-index:100;
        }
        .sidebar .admin-info { padding:0 0 24px 0; border-bottom:1px solid #388e3c; width:100%; }
        .sidebar .admin-info .name { font-size:1.2em; font-weight:700; margin-bottom:4px; padding-left: 20px; }
        .sidebar .admin-info .email { font-size:0.98em; opacity:0.85; padding-left: 20px; }
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
            <a href="manage_docs.php" style="background:#388e3c;">Quản lý tài liệu</a>
            <a href="manage_roles.php">Quản lý phân quyền</a>
            <a href="#">Quản lý nhận xét</a>
        </nav>
    </div>
    <div class="main">
        <h2 style="color:#43a047;text-align:center;margin-bottom:28px;">Quản lý tài liệu</h2>
        <?php if ($message) show_alert($message, strpos($message,'thành công')!==false?'success':'error'); ?>

        <!-- Nút chuyển sang trang upload -->
        <a href="../upload.php" style="display:inline-block;margin-bottom:24px;background:#43a047;color:#fff;padding:10px 24px;border-radius:6px;font-weight:500;text-decoration:none;">+ Thêm tài liệu mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>File</th>
                    <th>Ảnh đại diện</th>
                    <th>Môn học</th>
                    <th>Người đăng</th>
                    <th>Duyệt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docs as $doc): ?>
                <tr>
                    <td><?php echo $doc['id']; ?></td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $doc['id']): ?>
                        <form method="post" style="display:flex;gap:8px;align-items:center;">
                            <input type="hidden" name="doc_id" value="<?php echo $doc['id']; ?>">
                            <input type="text" name="title" value="<?php echo htmlspecialchars($doc['title']); ?>" required style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                            <input type="text" name="description" value="<?php echo htmlspecialchars($doc['description']); ?>" style="padding:6px 10px;border:1px solid #ccc;border-radius:4px;">
                            <button type="submit" name="edit_doc" style="background:#43a047;color:#fff;border:none;padding:6px 14px;border-radius:4px;cursor:pointer;font-weight:500;">Lưu</button>
                        </form>
                        <?php else: ?>
                            <?php echo htmlspecialchars($doc['title']); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($doc['description']); ?></td>
                    <td><a href="../uploads/doc/<?php echo htmlspecialchars($doc['filename']); ?>" target="_blank">Xem file</a></td>
                    <td>
                        <?php if (!empty($doc['image'])): ?>
                            <img src="../uploads/img/<?php echo htmlspecialchars($doc['image']); ?>" alt="Ảnh tài liệu" style="width:60px;height:60px;object-fit:cover;border-radius:6px;margin-bottom:6px;border:1px solid #eee;display:block;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo !empty($doc['subject_name']) ? htmlspecialchars($doc['subject_name']) : ''; ?></td>
                    <td><?php echo !empty($doc['uploader_name']) ? htmlspecialchars($doc['uploader_name']) : ($doc['uploader_id'] == null ? '' : 'Admin'); ?></td>
                    <td>
                        <?php if ($doc['approved']): ?>
                            <span style="color:#43a047;font-weight:500;">Đã duyệt</span>
                            <a href="?reject=<?php echo $doc['id']; ?>" class="action-btn reject">Không duyệt</a>
                        <?php else: ?>
                            <span style="color:#e53935;font-weight:500;">Chưa duyệt</span>
                            <a href="?approve=<?php echo $doc['id']; ?>" class="action-btn">Duyệt</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?edit=<?php echo $doc['id']; ?>" class="action-btn">Sửa</a>
                        <a href="?delete=<?php echo $doc['id']; ?>" class="action-btn reject" onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

