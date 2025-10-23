<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(session('user_id'));

        if (!$user) {
            return back()->with('error', 'Không tìm thấy người dùng.');
        }

        // Xóa ảnh cũ nếu có
        if ($user->avt && Storage::exists('public/' . $user->avt)) {
            Storage::delete('public/' . $user->avt);
        }

        // Lưu ảnh mới vào thư mục public/storage/avatars
        $path = $request->file('avatar')->store('avatars', 'public');

        // Cập nhật DB
        $user->avt = $path;
        $user->save();

        return back()->with('success', 'Ảnh đại diện đã được cập nhật thành công!');
    }
}
