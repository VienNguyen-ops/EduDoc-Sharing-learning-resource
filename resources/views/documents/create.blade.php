<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài liệu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        .btn { padding: 6px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-edit { background: #3ca23c; color: #fff; }
        .btn-delete { background: #e74c3c; color: #fff; }
        .add-btn { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .add-btn:hover { background-color: #319a31; }
        form label { display: block; margin-bottom: 8px; font-weight: bold; }
        form input, form textarea, form select, form button { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        form button { background-color: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }
        form button:hover { background-color: #319a31; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('manage') }}" class="add-btn" style="float:right; margin-bottom:8px;">Quay lại</a>
        <h2>Thêm Tài liệu</h2>
        </a>
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="title">Tiêu đề:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Mô tả:</label>
            <textarea name="description" id="description"></textarea>

            <label for="file">Tệp:</label>
            <input type="file" name="file" id="file" required>

            <label for="type">Loại tài liệu:</label>
            <select name="type" id="type" required>
                <option value="Document">Document</option>
                <option value="Exam">Exam</option>
            </select>

            <label for="category">Danh mục:</label>
            <select name="category" id="category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <label for="image">Ảnh:</label>
            <input type="file" name="image" id="image">

            <button type="submit">Thêm</button>
        </form>
    </div>
</body>
</html>
