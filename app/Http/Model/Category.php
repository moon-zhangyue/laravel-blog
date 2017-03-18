<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table      = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps    = false;
    protected $guarded    = [];
	/**
	 * @return array
     */
	public function tree()
	{
		 $categorys = $this->orderBy('cate_order','asc')->get();
	     return $this->getTree($categorys,'cate_id','cate_pid', 'cate_name');
	}

	// public static function tree()
	// {
	// 	 $categorys = Category::all(); 
	//      return (new Category)->getTree($categorys,'cate_id','cate_pid', 'cate_name');
	// }

	public function getTree( $data , $field_id='id', $field_pid='pid' ,  $field_name , $pid = 0)
	{
	    foreach ($data as $key => $value) {
	        if($value->$field_pid == $pid ){
	                $data[$key][$field_name] = '--|'.$data[$key][$field_name];
	                $arr[] = $data[$key];
	            foreach ($data as $k => $v) {
	                if($v[$field_pid] == $value->$field_id ){
	                    $data[$k][$field_name] = '----|'.$data[$k][$field_name];
	                    $arr[] = $data[$k];
	                }
	            }
	        }
	    }
	    return $arr;
	}
}


