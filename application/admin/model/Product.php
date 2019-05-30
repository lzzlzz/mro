<?php
namespace app\admin\model;
use think\Model;
class Product extends Model
{
	//从表属于主表
	public function cate(){
		return $this->belongsto('Cate','pdt_cate_id','id');
	}
	//
	public function getCateById($id){
		return self::with('cate')->find($id);
	}
	public function inventory(){
		return $this->hasone('inventory','ivt_pdt_id','id');
	}


}