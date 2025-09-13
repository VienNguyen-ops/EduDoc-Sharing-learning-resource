<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tài liệu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        h1 { color: #3ca23c; text-align: center; margin-bottom: 20px; }
        .add-btn { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #3ca23c; color: #fff; text-decoration: none; border-radius: 5px; }
        .add-btn:hover { background-color: #319a31; }
        table { width: 100%; border-collapse: collapse; background-color: #fff; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #3ca23c; color: #fff; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .action-btns a, .action-btns button { margin-right: 5px; padding: 5px 10px; border: none; border-radius: 3px; text-decoration: none; color: #fff; }
        .edit-btn { background-color: #007bff; }
        .edit-btn:hover { background-color: #0056b3; }
        .delete-btn { background-color: #dc3545; }
        .delete-btn:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="add-btn" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <h1>Quản lý Tài liệu</h1>
        <a href="{{ route('documents.create') }}" class="add-btn">Thêm Tài liệu</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
                    <th>Loại tài liệu</th>
                    <th>Danh mục</th>
                    <th>Người đăng</th>
                    <th>Ảnh</th>
                    <th>Đường dẫn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $document)
                    <tr>
                        <td>{{ $document->id }}</td>
                        <td>{{ $document->title }}</td>
                        <td>{{ $document->description }}</td>
                        <td>{{ $document->type }}</td>
                        <td>{{ $document->category->name ?? 'Không có danh mục' }}</td>
                        <td>{{ $document->user->name ?? 'Không rõ' }}</td>
                        <td><img src="{{ asset('storage/' . $document->image) }}" alt="{{ $document->title }}" style="width:100px;height:auto;"></td>
                        <td><a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">Tải xuống</a></td>
                        <td class="action-btns">
                            <a href="{{ route('documents.edit', $document->id) }}" class="edit-btn">Sửa</a>
                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
