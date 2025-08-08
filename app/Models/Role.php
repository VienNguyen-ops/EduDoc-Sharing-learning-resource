<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
    protected $table = 'role';

    // Quan hệ: lấy danh sách user thuộc role này
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'role_id');
    }
}
