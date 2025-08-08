<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; color: #222; }
        input[type="text"] { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        button { width: 100%; background: #3ca23c; color: #fff; border: none; padding: 12px; border-radius: 6px; font-size: 1.1rem; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa danh mục</h2>
        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')
            <label for="name">Tên danh mục</label>
            <input type="text" id="name" name="name" value="{{ $category->name }}" required>
            <button type="submit">Cập nhật</button>
        </form>
    </div>
</body>
</html>
