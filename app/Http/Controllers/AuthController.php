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
        $login = $request->input('login');
        $password = $request->input('password');

        // Admin mặc định
        if ($login === 'vien' && $password === '1234') {
            session(['role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // Xác định login là email hay tên
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($field, $login)->first();
            if ($user && Hash::check($password, $user->password) && $user->role_id) {
            // Đặt session chung
            session(['role' => $user->role_id == 2 ? 'student' : ($user->role_id == 3 ? 'teacher' : 'other'), 'user_id' => $user->id]);

            // Đặt flag cho hiệu ứng
            if ($user->role_id == 3) { 
                session(['welcome_type' => true]);
                session()->save(); // Ensure session is saved immediately
            }

            return redirect('/');
            }

        return redirect()->route('login')->with('error', 'Sai thông tin đăng nhập!');
    }

    

    public function logout()
    {
        session()->flush();
        return view('logout');
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

        session(['is_new_user' => true, 'role' => 'student', 'user_id' => $user->id]);
        return redirect()->route('survey.show');

    }

    
}
