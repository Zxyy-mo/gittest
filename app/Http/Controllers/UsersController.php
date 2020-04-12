<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
    public function show(User $user)
    {
        //User用户模型接口 $user隐式路由绑定
        return view('users.show', compact('user'));
    }
    public function store(Request $request)
    {
        //验证用户信息
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);
        //调用模型的方式写入数据库
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->name)
        ]);
        //session->flash方法只在下一次的请求类中有效
        session()->flash('success','欢迎,您将在这里有一个新的开始');
        return redirect()->route('users.show',[$user]);
    }
}
