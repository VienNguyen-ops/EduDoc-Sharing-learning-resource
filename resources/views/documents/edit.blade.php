<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tài liệu</title>
</head>
<body>
    <h1>Sửa Tài liệu</h1>
    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" id="title" value="{{ $document->title }}" required>
        <br>
        <label for="description">Mô tả:</label>
        <textarea name="description" id="description">{{ $document->description }}</textarea>
        <br>
        <label for="file">Tệp:</label>
        <input type="file" name="file" id="file">
        <br>
        <label for="type">Loại tài liệu:</label>
        <select name="type" id="type" required>
            <option value="Document" {{ $document->type == 'Document' ? 'selected' : '' }}>Document</option>
            <option value="Exam" {{ $document->type == 'Exam' ? 'selected' : '' }}>Exam</option>
        </select>
        <br>
        <label for="category">Danh mục:</label>
        <select name="category" id="category">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $document->subject_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="image">Ảnh:</label>
        <input type="file" name="image" id="image">
        <br>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>
