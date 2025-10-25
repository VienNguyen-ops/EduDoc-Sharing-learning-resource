<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = [
        'file_name',
        'file_path',
        'user_id',
        'category_id',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // App\Models\Upload.php
    /* public function getDisplayTypeAttribute()
    {
        $ext = strtolower($this->type ?? pathinfo($this->file_name, PATHINFO_EXTENSION));

        return match (true) {
            str_contains($ext, 'pdf') => 'PDF',
            str_contains($ext, 'doc') || str_contains($ext, 'docx') => 'Word',
            str_contains($ext, 'xls') || str_contains($ext, 'xlsx') => 'Excel',
            str_contains($ext, 'ppt') || str_contains($ext, 'pptx') => 'PowerPoint',
            str_contains($ext, 'jpg') || str_contains($ext, 'jpeg') || str_contains($ext, 'png') => 'Hình ảnh',
            default => strtoupper($ext ?: 'Không xác định'),
        };
    } */

}