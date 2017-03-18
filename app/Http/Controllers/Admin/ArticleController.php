<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class ArticleController extends CommonController
{
    //get.admin/article  全部文章列表
    public function index()
    {
        $article = Article::orderBy('art_id','desc')->paginate(5);
//        dd($article->links());
         return view('admin.article.index',compact('article'));

    }

    //get.admin/article/create   添加文章
    public function create()
    {
        $data = (new Category)->tree();
//        dd($categorys);
        return view('admin.article.add',compact('data'));
    }

    //post.admin/article  添加文章提交
    public function store()
    {
        $input= Input::except('_token');
        $input['art_time'] = time();
        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];

        $va = Validator::make($input,$rules,$message);
        if($va->passes())
        {
            $res = Article::create($input);
            // dd($res);
            if($res){
                return redirect('admin/article');
                // return back()->with('errors','密码修改成功!');
            }else{
                return back()->with('errors','修改失败!');
            }
        }else{
            return back()->withErrors($va);
            // dd($va -> errors()->all());
        }
    }

    //get.admin/article/{article}/edit  编辑文章
    public function edit($art_id)
    {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
//        dd($field);
        return view('admin.article.edit',compact('data','field'));
    }

    //put.admin/article/{article}   更新文章
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        if($input){
            $res = Article::where('art_id',$art_id)->update($input);
            if($res){
                return redirect('admin/article');
                // return back()->with('errors','密码修改成功!');
            }else{
                return back()->with('errors','修改失败!');
            }
        }
    }

    //delete.admin/article/{article}   删除文章
    public function destroy($art_id)
    {
        $res = Article::where('art_id',$art_id)->delete();
        if($res){
            $data = [
                'status'=> 0,
                'msg'=> '文章删除成功!',
            ];
        }else{
            $data = [
                'status'=> 1,
                'msg'=> '文章删除失败!',
            ];
        }
        return $data;
    }

}
