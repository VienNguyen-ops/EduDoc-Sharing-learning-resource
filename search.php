<?php
require_once 'includes/header.php';
require_once 'includes/db_connect.php';

$search = trim($_GET['q'] ?? '');
$docs = [];
if ($search !== '') {
    $stmt = $conn->prepare('SELECT id, title, filename, image FROM uploads WHERE approved = 1 AND title LIKE ? ORDER BY id ASC');
    $like = '%' . $search . '%';
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $docs[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>
<main style="max-width:1100px;margin:40px auto 0 auto;padding:0 20px;">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:28px;">
        <?php if ($search !== '' && empty($docs)): ?>
            <div style="grid-column:1/-1;text-align:center;color:#e53935;font-weight:500;">Không tìm thấy tài liệu phù hợp.</div>
        <?php endif; ?>
        <?php foreach ($docs as $doc): ?>
            <div style="background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:18px;text-align:center;">
                <img src="uploads/img/<?php echo htmlspecialchars($doc['image']); ?>" alt="Ảnh tài liệu" style="width:120px;height:120px;object-fit:cover;border-radius:8px;margin-bottom:12px;border:1px solid #eee;">
                <div style="font-size:1.08em;font-weight:600;color:#388e3c;margin-bottom:8px;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:auto;">
                    <?php 
                        $title = htmlspecialchars($doc['title']);
                        echo mb_strlen($title) > 30 ? mb_substr($title,0,27).'...' : $title;
                    ?>
                </div>
                <a href="uploads/doc/<?php echo htmlspecialchars($doc['filename']); ?>" target="_blank" style="display:inline-block;background:#43a047;color:#fff;padding:7px 18px;border-radius:5px;text-decoration:none;font-weight:500;">Tải về</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
