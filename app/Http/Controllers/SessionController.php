<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller {
    //登录表单

    public function create () {
        return view( 'sessions.create' );
    }

    // 验证用户数据

    public function store( Request $request ) {
        // 取得数据
        $credentials = $this->validate( $request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ] );
        // dd( $credentials );
        // 验证数据是否存在数据库
        if ( Auth::attempt( $credentials, $request->has( 'remember' ) ) ) {
            // 登录成功
            session()->flash( 'success', '欢迎回来！' );
            return redirect()->route( 'users.show', [Auth::user()] );
        } else {
            // 登录失败
            session()->flash( 'danger', '很抱歉，您的邮箱或者是密码不正确' );
            return redirect()->back()->withInput();
        }
    }

    // 用户退出

    public function destroy() {
        Auth::logout();
        //用户退出
        session()->flash( 'success', '您已成功退出!' );
        return redirect( 'login' );
    }
}
