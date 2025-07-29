<?php

require_once 'includes/db_connect.php';
$message = '';
// Lấy danh sách môn học cho menu
$subjects = [];
$result = $conn->query('SELECT id, name FROM subjects ORDER BY name ASC');
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $result->close();
}

if (isset($_POST['add_doc'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $file = $_FILES['file'] ?? null;
    $image = $_FILES['image'] ?? null;
    $subject_id = $_POST['subject_id'] ?? null;
    if ($title === '' || !$file || $file['error'] !== UPLOAD_ERR_OK || !$image || $image['error'] !== UPLOAD_ERR_OK || !$subject_id) {
        $message = 'Vui lòng nhập tiêu đề, chọn môn học, file và ảnh hợp lệ.';
    } else {
        $allowed = ['pdf','doc','docx','ppt','pptx','xls','xlsx','txt'];
        $allowed_img = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $ext_img = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $message = 'Định dạng file không được hỗ trợ.';
        } elseif (!in_array($ext_img, $allowed_img)) {
            $message = 'Định dạng ảnh không được hỗ trợ.';
        } else {
            $newName = uniqid('doc_', true) . '.' . $ext;
            $newImg = uniqid('img_', true) . '.' . $ext_img;
            $target = 'uploads/doc/' . $newName;
            $targetImg = 'uploads/img/' . $newImg;
            if (move_uploaded_file($file['tmp_name'], $target) && move_uploaded_file($image['tmp_name'], $targetImg)) {
                $stmt = $conn->prepare('INSERT INTO uploads (title, description, filename, image, approved, subject_id) VALUES (?, ?, ?, ?, 0, ?)');
                $stmt->bind_param('ssssi', $title, $description, $newName, $newImg, $subject_id);
                if ($stmt->execute()) {
                    $message = 'Thêm tài liệu thành công!';
                } else {
                    $message = 'Lỗi khi lưu thông tin tài liệu.';
                }
                $stmt->close();
            } else {
                $message = 'Lỗi khi upload file hoặc ảnh.';
            }
        }
    }
}
?>
<main style="max-width:600px;margin:40px auto 0 auto;padding:0 20px;">
    <h2 style="color:#43a047;text-align:center;margin-bottom:28px;">Thêm tài liệu mới</h2>
    <?php if ($message): ?>
        <div style="color:#fff;background:<?php echo strpos($message,'thành công')!==false?'#43a047':'#e53935'; ?>;padding:12px 18px;border-radius:6px;text-align:center;font-weight:500;margin-bottom:18px;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" style="background:#e0f2f1;padding:18px 24px;border-radius:8px;">
        <div style="margin-bottom:12px;">
            <label for="title" style="font-weight:500;">Tiêu đề:</label><br>
            <input type="text" name="title" id="title" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
        </div>
        <div style="margin-bottom:12px;">
            <label for="subject_id" style="font-weight:500;">Môn học:</label><br>
            <select name="subject_id" id="subject_id" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
                <option value="">-- Chọn môn học --</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo $subject['id']; ?>"><?php echo htmlspecialchars($subject['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="margin-bottom:12px;">
            <label for="description" style="font-weight:500;">Mô tả:</label><br>
            <input type="text" name="description" id="description" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
        </div>
        <div style="margin-bottom:12px;">
            <label for="file" style="font-weight:500;">Chọn file:</label><br>
            <input type="file" name="file" id="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt" style="padding:8px;">
        </div>
        <div style="margin-bottom:12px;">
            <label for="image" style="font-weight:500;">Chọn ảnh đại diện:</label><br>
            <input type="file" name="image" id="image" required accept=".jpg,.jpeg,.png,.gif" style="padding:8px;">
        </div>
        <button type="submit" name="add_doc" style="background:#43a047;color:#fff;border:none;padding:8px 20px;border-radius:4px;cursor:pointer;font-weight:500;">Thêm tài liệu</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>
