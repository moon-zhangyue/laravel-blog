<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::all())
        {
            $code  = new \Code;
            $_code = $code->get();

            if(strtoupper($input['code']) != $_code)
            {
                return back()->with('msg','验证码错误！');
            }
            $user = User::first();

            if($user->user_name != $input['user_name'] && Crypt::decrypt($user->user_pass) != $input['user_pass'])
            {
                return back()->with('msg','账号或密码错误！');
            }
            // dump($user);
            // dd($user);
            session(['user'=>$user]); //存入session
            // dump(session('user'));
            return redirect('admin/index');
        }else{
            // session(['user'=>null]);
            return view('admin.login');
        }

    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    // public function crypt()
    // {
    //     $str  = '123';
    //     echo $pass  = Crypt::encrypt($str);
    //     echo '<pre>';
    //     echo $pass1 = Crypt::decrypt($pass);
    //     // dd($pass); 
    // }

    // public function getcode()
    // {
    //     $code = new \Code;
    //     echo $code->get();
    // }
}
