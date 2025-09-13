<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = [
        'file_name',
        'file_path',
        'user_id',
        'subject_id',
        'type',
        'title',
        'description',
        'approved',
        'uploaded_at',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
