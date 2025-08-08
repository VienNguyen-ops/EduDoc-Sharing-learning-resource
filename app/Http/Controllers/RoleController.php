<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Hiển thị danh sách người dùng
    public function index()
    {
        $role = Role::all();
        return view('role.index', compact('role'));
    }

    // Hiển thị form chỉnh sửa người dùng
    
    // Hiển thị form thêm người dùng mới
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:role,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    // Cập nhật thông tin người dùng
    

    // Xóa người dùng
    
}
