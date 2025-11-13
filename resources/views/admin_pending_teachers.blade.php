<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách chờ duyệt</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; }
        .container { max-width: 900px; margin: 40px auto; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:32px; }
        table { width:100%; border-collapse: collapse; margin-top: 16px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; }
        th { background: #f8f8f8; }
        .btn-approve {
            background-color:#3ca23c; color:white; border:none; border-radius:6px;
            padding:8px 16px; cursor:pointer; font-weight:bold;
        }
        .back-link {
            display:inline-block; margin-bottom:12px; color:#3ca23c; text-decoration:none;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="back-link">← Quay lại trang admin</a>
        <h2>Người dùng chờ duyệt xác minh</h2>

        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:10px;">
                {{ session('success') }}
            </div>
        @endif

        @if($pendingUsers->isEmpty())
            <p>✅ Hiện không có người dùng nào đang chờ duyệt.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Họ tên</th>
                        <th>Chức vụ</th>
                        <th>Học vị</th>
                        <th>Email</th>
                        <th>Tài liệu xác minh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingUsers as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ ucfirst($user->position) }}</td>
                        <td>{{ $user->academic_title ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->verification_document)
                                <a href="{{ asset('storage/'.$user->verification_document) }}" target="_blank">Xem</a>
                            @else
                                Không có
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.verify-teacher', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn-approve">Duyệt</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
