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
        form label { display: block; margin-bottom: 8px; font-weight: bold; }
        form input, form select, form button { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        form button { background-color: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }
        form button:hover { background-color: #319a31; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thêm Tài liệu</h2>
        <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="file_name">Tên tệp:</label>
            <input type="text" name="file_name" id="file_name" required>

            <label for="file_path">Tệp:</label>
            <input type="file" name="file_path" id="file_path" required>

            <label for="user_id">Người đăng:</label>
            <select name="user_id" id="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            <label for="category_id">Danh mục:</label>
            <select name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <label for="image">Hình ảnh:</label>
            <input type="file" name="image" id="image">

            <button type="submit">Thêm</button>
        </form>
    </div>
</body>
</html>