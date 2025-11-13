<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khảo sát thông tin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .survey-container { width: 400px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #3ca23c; text-align: center; }
        label { display: block; margin-top: 12px; }
        input, select { width: 100%; padding: 10px; margin-top: 4px; border-radius: 6px; border: 1px solid #ccc; }
        button { margin-top: 16px; width: 100%; padding: 12px; background: #3ca23c; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #2e8b2e; }
    </style>
</head>
<body>
    <div class="survey-container">
        <h2>Khảo sát thông tin</h2>
        <form method="POST" action="{{ route('survey.submit') }}" enctype="multipart/form-data">
            @csrf
            <label for="full_name">Họ và tên</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="birth_date">Ngày sinh</label>
            <input type="date" id="birth_date" name="birth_date" required>

            <label for="position">Chức vụ</label>
            <select id="position" name="position" required onchange="toggleDocumentUpload()">
                <option value="">-- Chọn chức vụ --</option>
                <option value="student">Học sinh / Sinh viên</option>
                <option value="teacher">Giáo viên</option>
            </select>

            <div id="verification-section" style="display:none;">
                <label for="verification_document">Tài liệu xác minh (ảnh hoặc PDF)</label>
                <input type="file" id="verification_document" name="verification_document" accept=".jpg,.jpeg,.png,.pdf">
                <small style="color: gray;">* Bắt buộc đối với giáo viên</small>
            </div>

            <label for="academic_title">Học vị (nếu có)</label>
            <input type="text" id="academic_title" name="academic_title" placeholder="VD: Cử nhân, Thạc sĩ...">

            <button type="submit">Hoàn tất khảo sát</button>
        </form>

        <script>
        function toggleDocumentUpload() {
            const pos = document.getElementById('position').value;
            document.getElementById('verification-section').style.display =
                (pos === 'teacher') ? 'block' : 'none';
        }
        </script>

    </div>
</body>
</html>
