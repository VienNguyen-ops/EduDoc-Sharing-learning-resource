<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Tài liệu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9; }
        .container { max-width: 1200px; margin: 0 auto; padding: 32px; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);} 
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
        <h1>Danh sách Tài liệu</h1>
        <a href="{{ route('admin.dashboard') }}" class="add-btn" style="float:right; margin-bottom:8px;">Quay lại trang admin</a>
        <a href="{{ route('uploads.create') }}" class="add-btn">Thêm Tài liệu</a>
        <table>
            <thead>
                <tr>
                    
                    <th>Tên tệp</th>
                    <th>Đường dẫn</th>
                    <th>Người đăng</th>
                    <th>Chủ đề</th>
                    <th>Hình ảnh</th>
                    <th>Loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uploads as $upload)
                    <tr>
                        
                        <td>{{ $upload->file_name }}</td>
                        <td><a href="{{ route('uploads.download', $upload->id) }}">Tải xuống</a></td>
                        <td>{{ $upload->user->name ?? 'Không rõ' }}</td>
                        <td>{{ $upload->category->name ?? 'Không có chủ đề' }}</td>
                        <td>
                            @if($upload->image)
                                <img src="{{ asset('storage/' . $upload->image) }}" alt="{{ $upload->file_name }}" style="width:100px;height:auto;">
                            @else
                                Không có hình ảnh
                            @endif
                        </td>
                        
                            @php
                            $fileType = 'Không xác định';
                            if (!empty($upload->type)) {
                                $mime = strtolower($upload->type);
                                if (str_contains($mime, 'pdf')) {
                                    $fileType = 'PDF';
                                } elseif (str_contains($mime, 'doc') || str_contains($mime, 'msword') || str_contains($mime, 'officedocument.wordprocessingml')) {
                                    $fileType = 'Word';
                                } elseif (str_contains($mime, 'xlsx') || str_contains($mime, 'spreadsheet') || str_contains($mime, 'officedocument.spreadsheetml')) {
                                    $fileType = 'Excel';
                                } elseif (str_contains($mime, 'pptx') || str_contains($mime, 'presentation')) {
                                    $fileType = 'PowerPoint';
                                } elseif (str_contains($mime, 'img') || str_contains($mime, 'jpeg') || str_contains($mime, 'png')) {
                                    $fileType = 'Hình ảnh';
                                } else {
                                    $fileType = strtoupper(pathinfo($upload->file_name, PATHINFO_EXTENSION) ?: 'Không xác định');
                                }
                            } else {
                                $ext = pathinfo($upload->file_name, PATHINFO_EXTENSION);
                                $fileType = $ext ? strtoupper($ext) : 'Không xác định';
                            }
                        @endphp
                        <td>{{ $fileType }}</td>

                        <td class="action-btns">
                            <a href="{{ route('uploads.edit', $upload->id) }}" class="edit-btn">Sửa</a>
                            <form action="{{ route('uploads.destroy', $upload->id) }}" method="POST" style="display:inline;">
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