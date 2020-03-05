<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class SessionController extends Controller 
{
    //登录表单

    public function __construct() 
    {
        // middleware中间件
        $this->middleware( 'guest', [
            'only'=>['create']
        ] );
    }

    public function create () 
    {
        return view( 'sessions.create' );
    }

    // 验证用户数据

    public function store( Request $request ) 
    {
        // 取得数据
        $credentials = $this->validate( $request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ] );
        // dd( $credentials );
        // 验证数据是否存在数据库
        if ( Auth::attempt( $credentials, $request->has( 'remember' ) ) ) {
            if (Auth::user()->activated){
                // 登录成功
                session()->flash( 'success', $user->name . '欢迎回来！' );
                $fallback = route( 'users.show', Auth::user() );
                return redirect()->intended( $fallback );
            } else {
                Auth::logout();
                session()->flash('warning', $user->name . '您的账号未激活，请检查有邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
            
        } else {
            // 登录失败
            session()->flash( 'danger', '很抱歉，您的邮箱或者是密码不正确' );
            return redirect()->back()->withInput();
        }
    }

    // 用户退出

    public function destroy() 
    {
        Auth::logout();
        //用户退出
        session()->flash( 'success', '您已成功退出,再见！');
        return redirect( 'login' );
    }


    
}
