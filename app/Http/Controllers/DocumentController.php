<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    // Display a listing of the documents
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    // Show the form for creating a new document
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('documents.create', compact('categories'));
    }

    // Store a newly created document in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file',
            'type' => 'required|string',
            'subject_id' => 'required|exists:categories,id',
            'image' => 'nullable|file',
        ]);

        $filePath = $request->file('file')->store('documents');
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('images') : null;

        Document::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $filePath,
            'type' => $request->input('type'),
            'subject_id' => $request->input('category'),
            'image' => $imagePath,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document added successfully!');
    }

    // Show the form for editing the specified document
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    // Update the specified document in storage
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents');
            $document->file_path = $filePath;
        }

        $document->title = $request->input('title');
        $document->description = $request->input('description');
        $document->save();

        return redirect()->route('documents.index')->with('success', 'Document updated successfully!');
    }

    // Remove the specified document from storage
    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully!');
    }
}
