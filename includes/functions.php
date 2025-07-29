<?php
// Hàm kiểm tra đăng nhập
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Hàm kiểm tra quyền admin
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Hàm chuyển hướng nếu chưa đăng nhập
function require_login() {
    if (!is_logged_in()) {
        header('Location: /auth/login.php');
        exit();
    }
}

// Hàm chuyển hướng nếu không phải admin
function require_admin() {
    if (!is_admin()) {
        header('Location: /index.php');
        exit();
    }
}

// Hàm định dạng ngày giờ
function format_date($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}

// Hàm hiển thị thông báo
function show_alert($message, $type = 'success') {
    $color = $type === 'success' ? '#43a047' : ($type === 'error' ? '#e53935' : '#333');
    echo '<div style="color:' . $color . ';text-align:center;margin-bottom:16px;">' . htmlspecialchars($message) . '</div>';
}

// Hàm kiểm tra email hợp lệ
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Hàm kiểm tra file upload
function is_valid_upload($file) {
    $allowed = ['pdf','doc','docx','ppt','pptx','xls','xlsx','jpg','jpeg','png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    return in_array($ext, $allowed) && $file['size'] <= 10*1024*1024; // <=10MB
}
?>
