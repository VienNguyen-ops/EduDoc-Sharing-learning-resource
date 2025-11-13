<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminTeacherController extends Controller
{
    // Hiển thị danh sách người chờ duyệt
    public function index()
    {
        $pendingUsers = User::whereIn('position', ['teacher', 'master', 'doctor'])
            ->where('is_verified_teacher', false)
            ->get();

        return view('admin_pending_teachers', compact('pendingUsers'));
    }

    // Duyệt người dùng
    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->is_verified_teacher = true;
        $user->save();

        return redirect()->route('admin.pending-teachers')
            ->with('success', "Đã duyệt xác minh cho {$user->full_name}.");
    }
}
