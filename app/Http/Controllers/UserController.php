<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;

class UserController extends Controller 
{
    //用户操作

    // 构造函数

    public function __construct() 
    {
        // middleware中间件
        $this->middleware( 'auth', [
            'except'=>['create', 'store', 'confirmEmail']
        ] );
        $this->middleware( 'guest', [
            'only'=>['store']
        ] );
    }

    public function create() 
    {
        // 用户
        return view( 'users.create' );
    }

    public function show( User $user ) 
    {
        // 用户个人页面显示
        return view( 'users.show', compact( 'user' ) );
    }

    public function store( Request $request ) 
    {
        // 用户注册
        $this->validate( $request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ] );

        $user = User::create( [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt( $request->password ),
        ] );

        // 自动登录
        $this->sendEmailConfirmationTo($user);

        session()->flash( 'success', '验证邮件已发送到你的邮箱上，请注意查收。' );

        return redirect('/');
    }

    // 用户更新资料入口

    public function edit( User $user ) 
    {
        $this->authorize( 'update', $user );
        return view( 'users.edit', compact( 'user' ) );
    }

    // 提交更新个人资料入口

    public function update( User $user, Request $request ) 
    {
        $this->authorize( 'update', $user );
        // 获取提交的用户数据
        $this->validate( $request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ] );

        // 向数据库更新用户的数据
        $data = [];
        $data['name'] = $request->name;
        if ( $request->password ) {
            $data['password'] = bcrypt( $request->password );
        }
        $user->update( $data );
        session()->flash( 'success', '更新成功！' );
        return redirect()->route( 'users.show', $user );
    }

    // 用户列表

    public function index() 
    {
        $users = User::paginate( 10 );
        return view( 'users.index', compact( 'users' ) );
    }

    // 删除用户

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '删除成功！');
        return back();
    }

    // 邮箱发送

    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'zhucelehaojiu@gmail.com';
        $name = 'Wuyoufu';
        $to = $user->email;
        $subject = '感谢注册Weibo应用！请确认你的邮箱。';

        MAil::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }


    // 邮件激活

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', $user->name . '恭喜你，激活成功');
        return redirect()->route('users.show', [$user]);
    }
}