<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tài liệu</title>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Danh sách Tài liệu</h1>
    <a href="{{ route('documents.create') }}">Thêm Tài liệu</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
                <th>Người đăng</th>
                <th>Loại tài liệu</th>
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
                    <td><img src="{{ asset('storage/' . $document->image) }}" alt="{{ $document->title }}" style="width:100px;height:auto;"></td>
                    <td>{{ $document->category->name ?? 'Không có danh mục' }}</td>
                    <td>{{ $document->user->name ?? 'Không rõ' }}</td>
                    <td>{{ $document->type }}</td>
                    <td><a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">Tải xuống</a></td>
                    <td>
                        <a href="{{ route('documents.edit', $document->id) }}">Sửa</a>
                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
