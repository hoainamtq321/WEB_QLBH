<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    function showForm()
    {
        return view('auth.formLogin');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $status = Auth::attempt(['username'=>$username,'password'=>$password]);

        if($status)
        {
            $user = Auth::user();
            $urlRedirect = "/admin";
            return redirect($urlRedirect);
        }
        return back()->with('msg','Tài khoản hoặc mật khẩu sai!');
    }
}
