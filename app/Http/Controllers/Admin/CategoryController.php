<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category  全部分类列表
    public function index()
    {
        // echo 'get.admin/category ';
        $categorys = (new Category)->tree();
        // $categorys = Category::tree();
        // $data = $this->getTree($categorys,'cate_id','cate_pid', 'cate_name');
        // dd($categorys);
        return view('admin.category.index')->with('data',$categorys);
    }


    public function changeOrder()
    {
        $input = Input::all();
        {
            $cate = Category::find($input['cate_id']);
            $cate->cate_order = $input['cate_order'];
            $res = $cate->update();
            if($res){
                $data = [
                    'status'=>0,
                    'msg'=>'分类排序更新成功',
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


    //get.admin/category/create   添加分类
    public function create()
    {
        $category =  Category::where('cate_pid',0)->get();
        // dd($category);
        return view('admin/category/add',compact('category'));
    }

    //post.admin/category  添加分类提交 
    public function store()
    {
        $input = Input::except('_token');
        // dd($input);die;
        if($input = Input::all())
        {
            $rules = [
                'cate_name'=>'required',
            ];
            $message = [
                'cate_name.required'=>'分类名称不能为空',
            ];

            $va = Validator::make($input,$rules,$message);
            if($va->passes())
            {
                $res = Category::create($input);
                // dd($res);
                if($res){
                    return redirect('admin/category');
                    // return back()->with('errors','密码修改成功!');
                }else{
                    return back()->with('errors','修改失败!');
                }
            }else{
                return back()->withErrors($va);
                // dd($va -> errors()->all()); 
            }
        }else{
            return view('admin.pass');
        }       
    }


    //get.admin/category/{category}/edit  编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $category =  Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','category'));
    }

    //put.admin/category/{category}    更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if($res){
            return redirect('admin/category');
            // return back()->with('errors','密码修改成功!');
        }else{
            return back()->with('errors','修改失败!');
        }
    }

    //get.admin/category/{category}  显示单个分类信息
    public function show()
    {

    }

    //delete.admin/category/{category}   删除单个分类
    public function destroy($cate_id)
    {
        $res = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=> 0]);
        if($res){
            $data = [
                'status'=> 0,
                'msg'=> '分类删除成功!',
            ];
        }else{
            $data = [
                'status'=> 1,
                'msg'=> '分类删除失败!',
            ];
        }
        return $data;
    }



}
