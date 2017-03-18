<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\DomCrawler\Link;

class NavsController extends Controller
{
    //get.admin/navs  全部自定义导航列表
    public function index()
    {
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index')->with('data',$data);
    }

    public function changeOrder()
    {
        $input = Input::all();
        {
            $input = Input::all();
            $navs = Navs::find($input['nav_id']);
            $navs->nav_order = $input['nav_order'];
            $res = $navs->update();
            if($res){
                $data = [
                    'status'=>0,
                    'msg'=>'自定义导航排序更新成功',
                ];
            }else{
                $data = [
                    'status'=>1,
                    'msg'=>'更新失败',
                ];
            }
            return $data;
        }
    }

    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }

    //post.admin/navs  添加自定义导航提交
    public function store()
    {
        $input = Input::except('_token');
        // dd($input);die;
        if($input = Input::all())
        {
            $rules = [
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message = [
                'nav_name.required'=>'自定义导航名字不能为空',
                'nav_url.required'=>'自定义导航不能为空',
            ];

            $va = Validator::make($input,$rules,$message);
            if($va->passes())
            {
                $res = Navs::create($input);
                // dd($res);
                if($res){
                    return redirect('admin/navs');
                    // return back()->with('errors','密码修改成功!');
                }else{
                    return back()->with('errors','添加失败!');
                }
            }else{
                return back()->withErrors($va);
                // dd($va -> errors()->all());
            }
        }else{
            return view('admin.pass');
        }
    }
    //get.admin/navs/create   添加自定义导航
    public function create()
    {
//        $navs =  Category::where('nav_id',0)->get();
        // dd($category);
        return view('admin/navs/add');
    }

    //get.admin/navs/{navs}/edit  编辑自定义导航
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    //put.admin/navs/{navs}    更新分类
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
//        dd($input);die;
        $res = Navs::where('nav_id',$nav_id)->update($input);
        if($res){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','更新失败!');
        }
    }

    //delete.admin/category/{category}   删除自定义导航
    public function destroy($nav_id)
    {
        $res = Navs::where('nav_id',$nav_id)->delete();
        if($res){
            $data = [
                'status'=> 0,
                'msg'=> '自定义导航删除成功!',
            ];
        }else{
            $data = [
                'status'=> 1,
                'msg'=> '自定义导航删除失败!',
            ];
        }
        return $data;
    }

}
