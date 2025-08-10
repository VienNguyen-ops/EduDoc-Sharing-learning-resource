<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f8f8; }
        .actions { display: flex; gap: 8px; }
        .btn { padding: 6px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-edit { background: #3ca23c; color: #fff; }
        .btn-delete { background: #e74c3c; color: #fff; }
        .btn-add { background: #319a31; color: #fff; margin-bottom: 16px; }
        .form-inline { display: flex; gap: 8px; margin-bottom: 16px; }
        .form-inline input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        .form-inline button { padding: 10px 24px; border-radius: 6px; border: none; background: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }

    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-add" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <h2>Danh sách người dùng</h2>
        <!-- Toolbar: nút thêm + tìm kiếm -->
        <div class="user-management-toolbar" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <form method="GET" action="{{ route('user.create') }}" class="form-inline">
            @csrf
            <button type="submit">Thêm</button>
        </form>
            <form method="GET" action="{{ route('users_management') }}" style="display: flex; flex: 2; gap: 8px;">
                <input type="text" name="search" placeholder="Tìm kiếm tên hoặc email..." value="{{ request('search') }}" style="flex: 2; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem;">
                <button type="submit" class="btn btn-add">Tìm kiếm</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name ?? 'Thành viên' }}</td>
                    <td class="actions">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-edit">Sửa</a>
                        <form method="POST" action="{{ route('user.destroy', $user->id) }}" style="display:inline;">
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
