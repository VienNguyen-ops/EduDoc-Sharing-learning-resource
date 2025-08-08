<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm quyền mới</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; margin-bottom: 16px; }
        .btn { padding: 10px 24px; border-radius: 6px; border: none; background: #319a31; color: #fff; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thêm quyền mới</h2>
        <form method="POST" action="{{ route('role.store') }}">
            @csrf
            <label for="name">Tên quyền</label>
            <input type="text" id="name" name="name" required>
            <button type="submit" class="btn">Thêm quyền</button>
        </form>
        
    </div>
</body>
</html>
