<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
        // $pdo = DB::connection()->getPdo();
        // dd($pdo);
        
    }

    public function info()
    {
        return view('admin.info');
    }

    //更改超级管理员密码
    public function pass()
    {
        if($input = Input::all())
        {
        	$rules = [
        		'password'=>'required|between:5,10|confirmed',
        	];
        	$message = [
        		'password.required'=>'新密码不能为空',
        		'password.between'=>'新密码必须在5-10位',
        		'password.confirmed'=>'新密码与确认密码不匹配',
        	];
  
        	$va = Validator::make($input,$rules,$message);
        	if($va->passes())
        	{
        		$user = User::first();
        		$_password = Crypt::decrypt($user->user_pass);
        		if($input['password_o']==$_password){
        			$user->user_pass = Crypt::encrypt($input['password']);
        			$user->update();
//        			return redirect('admin/index');
					return back()->with('errors','密码修改成功!');
        		}else{
        			return back()->with('errors','原密码错误!');
        		}
        	}else{
        		return back()->withErrors($va);
        		// dd($va -> errors()->all()); 
        	}
        }else{
        	return view('admin.pass');
        }       
    }
}
