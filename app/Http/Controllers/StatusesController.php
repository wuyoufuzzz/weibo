<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    //中间件过滤
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 发布微博
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:200'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        session()->flash('success', '发布成功');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return back();
    }
}
