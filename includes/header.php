

<?php
session_start();
// Nếu truy cập trực tiếp header.php thì chuyển về index.php
if (basename($_SERVER['PHP_SELF']) === 'header.php') {
    header('Location: ../index.php');
    exit();
}
// Chỉ chuyển hướng login nếu vào các trang cần đăng nhập, không áp dụng cho index.php
if (!isset($_SESSION['user_id']) && !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'register.php', 'index.php', 'search.php'])) {
    header('Location: login.php');
    exit();
}
?>
<header>
  <div style="background:#f5f5f5;padding:8px 0;border-bottom:1px solid #e0e0e0;">
    <div style="max-width:1100px;margin:auto;display:flex;justify-content:flex-end;align-items:center;gap:28px;font-size:1em;">
      <a href="#" style="color:#333;text-decoration:none;">Chăm sóc khách hàng</a>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="../auth/login.php" style="color:#333;text-decoration:none;">Đăng nhập</a>
        <a href="../auth/register.php" style="color:#333;text-decoration:none;">Đăng ký</a>
      <?php endif; ?>
      <a href="#" style="color:#333;text-decoration:none;">Về chúng tôi</a>
    </div>
  </div>
  <div style="background:#fff;padding:18px 0;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
    <div style="max-width:1100px;margin:auto;display:flex;align-items:center;gap:32px;">
      <div style="font-size:2em;font-weight:700;color:#43a047;line-height:1;">EduDoc</div>
      <nav style="position:relative;display:flex;align-items:center;gap:24px;">
        <div style="position:relative;">
          <button id="menuBtn" style="display:flex;align-items:center;gap:8px;background:#fff;border:2px solid #43a047;color:#333;font-weight:500;font-size:1.1em;cursor:pointer;padding:8px 18px 8px 12px;border-radius:6px;transition:background 0.2s,border-color 0.2s;line-height:1;">
            <span style="display:inline-block;width:18px;height:18px;vertical-align:middle;">
              <svg width="18" height="18" viewBox="0 0 18 18"><rect y="3" width="18" height="2" rx="1" fill="#43a047"/><rect y="8" width="18" height="2" rx="1" fill="#43a047"/><rect y="13" width="18" height="2" rx="1" fill="#43a047"/></svg>
            </span>
            Danh mục
          </button>
            <div id="mainMenu" style="display:none;position:absolute;left:0;top:110%;background:#fff;border:2px solid #43a047;box-shadow:0 2px 8px rgba(0,0,0,0.08);min-width:180px;z-index:10;border-radius:6px;">
        <script>
        // Hiển thị/ẩn menu chính
        document.addEventListener('DOMContentLoaded', function() {
          var menuBtn = document.getElementById('menuBtn');
          var mainMenu = document.getElementById('mainMenu');
          var submenuBtns = document.querySelectorAll('.submenuBtn');
          var submenus = document.querySelectorAll('.submenu');

          menuBtn.onclick = function(e) {
            e.stopPropagation();
            var active = mainMenu.style.display === 'block';
            mainMenu.style.display = active ? 'none' : 'block';
            submenus.forEach(function(sm){ sm.style.display = 'none'; });
            // Hiệu ứng nút
            if (!active) {
              menuBtn.style.background = '#43a047';
              menuBtn.style.color = '#fff';
              menuBtn.style.borderColor = '#388e3c';
            } else {
              menuBtn.style.background = '#fff';
              menuBtn.style.color = '#333';
              menuBtn.style.borderColor = '#43a047';
            }
          };

          submenuBtns.forEach(function(btn){
            btn.onclick = function(e){
              e.stopPropagation();
              var id = btn.getAttribute('data-menu');
              submenus.forEach(function(sm){
                sm.style.display = 'none';
              });
              document.getElementById(id).style.display = 'block';
            };
          });

          document.addEventListener('click', function(){
            mainMenu.style.display = 'none';
            submenus.forEach(function(sm){ sm.style.display = 'none'; });
            menuBtn.style.background = '#fff';
            menuBtn.style.color = '#333';
            menuBtn.style.borderColor = '#43a047';
          });
        });
        </script>
            <div style="border-bottom:1px solid #eee;">
              <button class="submenuBtn" data-menu="monhoc" style="width:100%;background:none;border:none;text-align:left;padding:12px 18px;color:#333;font-size:1em;cursor:pointer;">Tài liệu môn học ▶</button>
              <div class="submenu" id="monhoc" style="display:none;position:absolute;left:100%;top:0;background:#fff;border:1px solid #e0e0e0;min-width:180px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">Ngoại ngữ</a>
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">Công nghệ</a>
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">Kiến thức chung</a>
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">Sư phạm</a>
              </div>
            </div>
            <div>
              <button class="submenuBtn" data-menu="dethi" style="width:100%;background:none;border:none;text-align:left;padding:12px 18px;color:#333;font-size:1em;cursor:pointer;">Đề thi ▶</button>
              <div class="submenu" id="dethi" style="display:none;position:absolute;left:100%;top:0;background:#fff;border:1px solid #e0e0e0;min-width:180px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">TOEIC</a>
                <a href="#" style="display:block;padding:12px 18px;color:#333;text-decoration:none;">IELTS</a>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <form action="../search.php" method="get" style="display:flex;align-items:center;gap:0;margin-left:24px;">
        <input type="text" name="q" placeholder="Tìm kiếm tài liệu..." style="padding:8px 12px;font-size:1.08em;border:1px solid #ccc;border-radius:4px 0 0 4px;outline:none;width:300px;">
        <button type="submit" style="background:#43a047;color:#fff;border:none;padding:8px 16px;border-radius:0 4px 4px 0;cursor:pointer;font-size:1.08em;">Tìm kiếm</button>
      </form>
      <div style="margin-left:auto;display:flex;align-items:center;gap:12px;">
        <?php if (isset($_SESSION['user_id'])): ?>
          <span style="font-weight:500;color:#43a047;">👤 <?php echo htmlspecialchars($_SESSION['name']); ?></span>
          <a href="auth/logout.php" style="color:#333;text-decoration:none;font-size:0.95em;">Đăng xuất</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
