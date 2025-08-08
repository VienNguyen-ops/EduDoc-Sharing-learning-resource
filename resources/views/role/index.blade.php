<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phân quyền</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f8f8; }
        .actions { display: flex; gap: 8px; }
        .btn { padding: 6px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-edit { background: #3ca23c; color: #fff; }
        .btn-delete { background: #e74c3c; color: #fff; }
        .btn-add { background: #319a31; color: #fff; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-add" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <h2>Quản lý phân quyền</h2>
        <a href="{{ route('role.create') }}" class="btn btn-add">Thêm quyền</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($role as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="actions">
                        <a href="{{ route('role.edit', $role->id) }}" class="btn btn-edit">Sửa</a>
                        <form method="POST" action="{{ route('role.destroy', $role->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
