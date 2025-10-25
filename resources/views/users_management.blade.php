<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 32px; }
        h2 { color: #3ca23c; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; vertical-align: middle;}
        th { background: #f8f8f8; }
        .actions { display: flex; gap: 8px; }
        .btn { padding: 6px 16px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-edit { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn-delete { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background: #e74c3c; color: #fff; text-decoration: none; border-radius: 5px; }
        .btn-add {  display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .form-inline { display: flex; gap: 8px; margin-bottom: 16px; }
        .form-inline input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        .form-inline button { padding: 10px 24px; border-radius: 6px; border: none; background: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }
        
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-add" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
    <h2>Quản lý người dùng</h2>
    
        <!-- Toolbar: nút thêm + tìm kiếm -->
        <div class="user-management-toolbar" 
            style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">

            <!-- Nút thêm -->
            <a href="{{ route('user.create') }}" 
            style="background-color:#3ca23c; color:white; border:none; border-radius:6px; 
                    padding:10px 20px; text-decoration:none; font-weight:bold;">
                Thêm
            </a>

            <!-- Form tìm kiếm -->
            <form method="GET" action="{{ route('users_management') }}" 
                style="display: flex; align-items: center; gap: 8px;">
                <input type="text" name="search" placeholder="Tìm kiếm tên hoặc email..." 
                    value="{{ request('search') }}"
                    style="padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; width: 250px;">
                <button type="submit" 
                        style="background-color:#3ca23c; color:white; border:none; border-radius:6px; 
                            padding:10px 20px; font-weight:bold;">
                    Tìm kiếm
                </button>
            </form>

        </div>

        <!-- Danh sách người dùng -->
        <table>
            <thead>
                <tr>
                    
                    <th>Avatar</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    
                    <td>
                        @if($user->avt)
                            <img src="{{ asset('storage/' . $user->avt) }}" alt="avatar" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="avatar" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role ? $user->role->name : 'Thành viên' }}</td>
                    <td class="actions">
                        <a href="{{ route('user.edit', $user->id) }}" class=" btn-edit">Sửa</a>
                        <form method="POST" action="{{ route('user.destroy', $user->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
