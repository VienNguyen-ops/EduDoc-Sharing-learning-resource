<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phân quyền</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f8f8; }
        .btn-add {  display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn { padding: 6px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .form-inline { display: flex; gap: 8px; margin-bottom: 16px; }
        .form-inline input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        .form-inline button { padding: 10px 24px; border-radius: 6px; border: none; background: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }

    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-add" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <h2>Quản lý phân quyền</h2>
        <form method="POST" action="{{ route('role.store') }}" class="form-inline">
            @csrf
            <input type="text" name="name" placeholder="Tên danh mục mới" required>
            <button type="submit">Thêm</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên quyền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
