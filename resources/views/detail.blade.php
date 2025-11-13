<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi tiết tài liệu | EduDoc</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body{font-family:sans-serif;background:#f4f5f7;margin:0;color:#333}
    header{background:#3ca23c;color:#fff;text-align:center;padding:12px 0;font-weight:600;}
    .container{max-width:1100px;margin:30px auto;display:flex;gap:20px;padding:0 10px}
    .sidebar,.main{background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 6px rgba(0,0,0,.1)}
    .sidebar{flex:1; position: sticky; top: 20px; height: fit-content;}
    .main{flex:3}
    h1,h2{color:#1b4332;margin-top:0}
    p,li{line-height:1.5;font-size:15px}
    ul{padding-left:20px}
    button{border:none;border-radius:6px;padding:6px 12px;margin:4px;color:#fff;cursor:pointer;font-size:14px}
    .save{background:#2d6a4f}
    .like{background:#007bff}
    .share{background:#f4a261}
    .report{background:#d62828}
    footer{text-align:center;color:#777;padding:20px;font-size:14px}
    @media(max-width:768px){.container{flex-direction:column}}
    .main canvas{width:100%;max-width:100%;height:auto;display:block;margin-bottom:10px;border:1px solid #ddd;border-radius:6px}
    .breadcrumb{font-size:13px;color:#999;margin-bottom:10px}.breadcrumb a{color:#3b82f6;text-decoration:none}.breadcrumb a:hover{text-decoration:underline}
  </style>
</head>
<body>

<header>EduDoc - Chi tiết tài liệu</header>

<div class="container">
  <aside class="sidebar">
    <div class="breadcrumb">
    <a href="{{ route('home') }}">Trang chủ</a> »
    <a href="{{ route('categories.show', $file->category->id ?? '') }}">
        {{ $file->category->name ?? 'Danh mục' }}
    </a> »
    <span>Led 7 đoạn</span>
</div>
    <h2>Bài giảng Tư duy phân tích</h2>
    <p>Tổng quan: khái niệm, lợi ích, rào cản và cách vượt qua trong tư duy phân tích.</p>
    <p>Chủ đề: <strong>Kỹ năng thế kỷ 21</strong></p>
    <div>
      <button class="save"><i class="fa-solid fa-bookmark"></i> Save</button>
      <button class="like"><i class="fa-solid fa-thumbs-up"></i> Like</button>
      <button class="share"><i class="fa-solid fa-share"></i> Share</button>
      <button class="report"><i class="fa-solid fa-flag"></i> Report</button>
    </div>
    <p style="margin-top:10px;color:#777;font-size:13px;">
      <span class="page-count">{{ $file->page_count ?? 'N/A' }} trang</span>
    </p>
  </aside>

  <main class="main">
    <h1>Chi tiết tài liệu</h1>
    @if(isset($content))
        <div class="word-content">
            {!! $content !!}
        </div>
    @else
        @php
            $fileUrl = asset('storage/'.$file->file_path);
            $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
        @endphp
        @if($ext === 'pdf')
            {{-- --- PDF PREVIEW --- --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
            <script>
                const url = "{{ $fileUrl }}";
                const pdfContainer = document.querySelector('.main');

                pdfjsLib.getDocument(url).promise.then(pdf => {
                    const pageCount = pdf.numPages;
                    document.querySelector('.page-count').innerText = `${pageCount} trang`;

                    // Gửi số trang lên server
                    fetch(`/update-page-count/{{ $file->id }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ page_count: pageCount })
                    });

                    // Render từng trang PDF
                    for (let i = 1; i <= pdf.numPages - 3; i++) {
                        pdf.getPage(i).then(page => {
                            const scale = 1.2;
                            const viewport = page.getViewport({ scale });
                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
                            pdfContainer.appendChild(canvas);
                            const renderContext = { canvasContext: context, viewport: viewport };
                            page.render(renderContext);
                        });
                    }
                }).catch(error => {
                    pdfContainer.innerHTML = '<p>Không thể tải PDF.</p>';
                    console.error(error);
                });
            </script>
        @elseif(in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
        {{-- --- OFFICE ONLINE VIEWER --- --}}
        <div style="text-align:center;">
            <iframe 
                src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}"
                width="100%"
                height="800px"
                frameborder="0">
            </iframe>
        </div>
        @else
            {{-- --- KHÔNG HỖ TRỢ --- --}}
            <p>Không hỗ trợ xem trước loại file này. 
                <a href="{{ $fileUrl }}" download>Tải xuống</a>
            </p>
        @endif
    @endif

  </main>
</div>

<footer>© 2025 EduDoc. All rights reserved.</footer>
</body>
</html>
