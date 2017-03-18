<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\DomCrawler\Link;

class LinksController extends Controller
{
    //get.admin/links  全部友情链接列表
    public function index()
    {
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.links.index')->with('data',$data);
    }

    public function changeOrder()
    {
        $input = Input::all();
        {
            $input = Input::all();
            $links = Links::find($input['link_id']);
            $links->link_order = $input['link_order'];
            $res = $links->update();
            if($res){
                $data = [
                    'status'=>0,
                    'msg'=>'友情链接排序更新成功',
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

    //post.admin/links  添加友情链接提交
    public function store()
    {
        $input = Input::except('_token');
        // dd($input);die;
        if($input = Input::all())
        {
            $rules = [
                'link_name'=>'required',
                'link_url'=>'required',
            ];
            $message = [
                'link_name.required'=>'友情链接名字不能为空',
                'link_url.required'=>'友情链接不能为空',
            ];

            $va = Validator::make($input,$rules,$message);
            if($va->passes())
            {
                $res = Links::create($input);
                // dd($res);
                if($res){
                    return redirect('admin/links');
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
    //get.admin/links/create   添加友情链接
    public function create()
    {
//        $links =  Category::where('link_id',0)->get();
        // dd($category);
        return view('admin/links/add');
    }

    //get.admin/links/{links}/edit  编辑友情链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    //put.admin/links/{links}    更新分类
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
//        dd($input);die;
        $res = Links::where('link_id',$link_id)->update($input);
        if($res){
            return redirect('admin/links');
        }else{
            return back()->with('errors','更新失败!');
        }
    }

    //delete.admin/category/{category}   删除友情链接
    public function destroy($link_id)
    {
        $res = Links::where('link_id',$link_id)->delete();
        if($res){
            $data = [
                'status'=> 0,
                'msg'=> '友情链接删除成功!',
            ];
        }else{
            $data = [
                'status'=> 1,
                'msg'=> '友情链接删除失败!',
            ];
        }
        return $data;
    }

}
