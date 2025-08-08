<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function loginCheck(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Kiểm tra tài khoản admin mặc định
        if ($username === 'vien' && $password === '1234') {
            session(['role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // Kiểm tra tài khoản student trong bảng users
        $user = User::where('name', $username)->first();
        if ($user && Hash::check($password, $user->password) && $user->role_id) {
            // Giả sử role_id = 2 là student
            $role = $user->role_id == 2 ? 'student' : 'other';
            session(['role' => $role, 'user_id' => $user->id]);
            if ($role === 'student') {
                return redirect('/');
            }
        }

        return redirect()->route('login')->with('error', 'Sai thông tin đăng nhập!');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function registerCheck(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        $user = new User();
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role_id = 2; // Mặc định là student
        $user->save();

        return redirect()->route('login')->with('error', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
