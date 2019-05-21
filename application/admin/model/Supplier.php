<?php
namespace app\admin\model;
use think\Model;
class Supplier extends Model
{
	//从表属于主表
	public function cate(){
		return $this->belongsto('Cate','sp_cate_id','id');
	}
	//
	public function getCateById($id){
		return self::with('cate')->find($id);
	}


}