<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục</title>
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
        .btn-add {  display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .form-inline { display: flex; gap: 8px; margin-bottom: 16px; }
        .form-inline input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        .form-inline button { padding: 10px 24px; border-radius: 6px; border: none; background: #3ca23c; color: #fff; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-add" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <h2>Quản lý danh mục</h2>
        <!-- Form thêm mới -->
        <form method="POST" action="{{ route('categories.store') }}" class="form-inline">
            @csrf
            <input type="text" name="name" placeholder="Tên danh mục mới" required>
            <button type="submit">Thêm</button>
        </form>
        <!-- Danh sách -->
        <table>
            <thead>
                <tr>
                    
                    <th>Tên danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    
                    <td>
                        @if(request('edit') == $category->id)
                        <form method="POST" action="{{ route('categories.update', $category->id) }}" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" required>
                            <button type="submit" class="btn btn-edit">Lưu</button>
                        </form>
                        @else
                        {{ $category->name }}
                        @endif
                    </td>
                    <td class="actions">
                        @if(request('edit') != $category->id)
                        <a href="?edit={{ $category->id }}" class="btn btn-edit">Sửa</a>
                        @endif
                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" style="display:inline;">
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
