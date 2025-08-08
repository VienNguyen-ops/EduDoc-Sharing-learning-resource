<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::with('role')->get();
        return view('user.index', compact('users'));
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('user.edit', compact('user'));
    }
    // Hiển thị form thêm người dùng mới
    public function create()
    {
        return view('user.create');
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return redirect()->route('user.index')->with('success', 'Cập nhật thành công!');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Xóa người dùng thành công!');
    }
}
