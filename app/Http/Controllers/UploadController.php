<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    // Display a listing of the uploads
    public function index()
    {
        $uploads = Upload::with(['user', 'category'])->get();
        return view('uploads.index', compact('uploads'));
    }

    // Show the form for creating a new upload
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('uploads.create', compact('users', 'categories'));
    }

    // Store a newly created upload in storage
    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|file',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $file = $request->file('file_path');
        $fileExtension = strtoupper($file->getClientOriginalExtension()); // lấy đuôi file, viết hoa
        $filePath = $file->store('uploads', 'public');
        $upload = new Upload();
        $upload->file_name = $file->getClientOriginalName();
        $upload->file_path = $filePath;
       
         

        $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('img', 'public');
    }

        Upload::create([
            'file_name' => $request->input('file_name'),
            'file_path' => $filePath,
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
            'image' => $imagePath,
            'type' => $fileExtension,
        ]);

        return redirect()->route('uploads.index')->with('success', 'Upload created successfully!');
    }

    // Show the form for editing the specified upload
    public function edit(Upload $upload)
    {
        $users = User::all();
        $categories = Category::all();
        return view('uploads.edit', compact('upload', 'users', 'categories'));
    }

    // Update the specified upload in storage
    public function update(Request $request, Upload $upload)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_path' => 'nullable|file',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('uploads');
            $upload->file_path = $filePath;
        }

        $upload->file_name = $request->input('file_name');
        $upload->user_id = $request->input('user_id');
        $upload->category_id = $request->input('category_id');
        $upload->save();

        return redirect()->route('uploads.index')->with('success', 'Upload updated successfully!');
    }


    public function download($id)
{
    $upload = Upload::findOrFail($id);
    $filePath = storage_path('app/public/' . $upload->file_path);

    if (!file_exists($filePath)) {
        abort(404, 'File không tồn tại');
    }

    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $mimeType = match (strtolower($extension)) {
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'txt' => 'text/plain',
        default => 'application/octet-stream',
    };

    // 🔧 Gắn đuôi mở rộng đúng với tên file
    $downloadName = $upload->file_name;
    if (!str_ends_with(strtolower($downloadName), '.' . strtolower($extension))) {
        $downloadName .= '.' . $extension;
    }

    return response()->download($filePath, $downloadName, [
        'Content-Type' => $mimeType,
    ]);
}



    // Remove the specified upload from storage
    public function destroy(Upload $upload)
    {
        $upload->delete();
        return redirect()->route('uploads.index')->with('success', 'Upload deleted successfully!');
    }
}