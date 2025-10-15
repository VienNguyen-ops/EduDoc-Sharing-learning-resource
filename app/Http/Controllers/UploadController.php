<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\User;
use App\Models\Category;

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

        $fileExtension = $request->file('file_path')->getClientOriginalExtension();
        $filePath = $request->file('file_path')->store('uploads');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('img', 'public');
        } else {
            $imagePath = null;
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

    // Remove the specified upload from storage
    public function destroy(Upload $upload)
    {
        $upload->delete();
        return redirect()->route('uploads.index')->with('success', 'Upload deleted successfully!');
    }
}