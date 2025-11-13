<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SurveyController extends Controller
{
    public function showSurvey()
    {
        // Kiểm tra nếu chưa đăng ký thì không cho vào khảo sát
        if (!session('user_id')) {
            return redirect()->route('register')->with('error', 'Vui lòng đăng ký trước khi làm khảo sát.');
        }

        return view('survey');
    }

    public function submitSurvey(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position' => 'required|string',
            'academic_title' => 'nullable|string|max:255',
            'verification_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = User::find(session('user_id'));
        if (!$user) {
            return redirect()->route('register')->with('error', 'Không tìm thấy người dùng.');
        }

        $user->full_name = $request->full_name;
        $user->birth_date = $request->birth_date;
        $user->position = $request->position;
        $user->academic_title = $request->academic_title;

        // Cập nhật role_id dựa trên vị trí
        if ($request->position === 'teacher') {
            $user->role_id = 3; // Giáo viên
        } elseif ($request->position === 'student') {
            $user->role_id = 2; // Sinh viên
        }

        // Nếu có file xác minh
        if ($request->hasFile('verification_document')) {
            $file = $request->file('verification_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('verification_docs', $filename, 'public');
            $user->verification_document = $path;
        }

        // Giáo viên cần xác minh
        if (in_array($request->position, ['teacher'])) {
            $user->is_verified_teacher = false; // chờ duyệt
        } else {
            $user->is_verified_teacher = true; // sinh viên không cần duyệt
        }

        $user->save();

        session()->forget('is_new_user');

        return redirect()->route('login')->with('error', 'Khảo sát thành công! Vui lòng đăng nhập.');
    }

    public function checkApprovalStatus()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('register')->with('error', 'Không tìm thấy người dùng.');
        }

        // Kiểm tra trạng thái "đang duyệt" của giáo viên
        if ($user->role_id === 3 && $user->is_verified_teacher === false) {
            return view('approval_pending'); // Hiển thị màn hình đang duyệt
        }

        // Nếu đã được duyệt hoặc không phải giáo viên
        return redirect()->route('login')->with('success', 'Trạng thái đã được duyệt. Vui lòng đăng nhập.');
    }
}
