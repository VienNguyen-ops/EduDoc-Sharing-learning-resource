<?php include 'includes/header.php'; ?>
<?php
require_once 'includes/db_connect.php';
$message = '';

// Lấy danh sách tài liệu
$docs = [];
$result = $conn->query('SELECT id, title, filename, image FROM uploads WHERE approved = 1 ORDER BY id DESC');
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $docs[] = $row;
    }
    $result->close();
}
$conn->close();
?>


<main style="max-width:1100px;margin:40px auto 0 auto;padding:0 20px;">
  <h1 style="color:#43a047;font-size:2.2em;font-weight:700;text-align:center;margin-bottom:24px;">Chào mừng đến với EduDoc!</h1>
  <p style="font-size:1.2em;text-align:center;">Nền tảng chia sẻ tài liệu học tập cho sinh viên và giáo viên. Tìm kiếm, tải lên, và chia sẻ tài liệu dễ dàng.</p>

  <!-- Hiển thị danh sách tài liệu như sản phẩm -->
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:28px;margin:40px 0;">
    <?php foreach ($docs as $doc): ?>
      <div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:18px;text-align:center;">
        <img src="uploads/img/<?php echo htmlspecialchars($doc['image']); ?>" alt="Ảnh tài liệu" style="width:120px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:12px;border:1px solid #eee;">
        <div style="font-size:1.08em;font-weight:600;color:#388e3c;margin-bottom:8px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:auto;">
          <?php 
            $title = htmlspecialchars($doc['title']);
            echo mb_strlen($title) > 30 ? mb_substr($title,0,27).'...' : $title;
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
