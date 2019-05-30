<?php
namespace app\admin\model;
use think\Model;
class Inventory extends Model
{
	//从表属于主表
	public function product(){
		return $this->belongsto('Product','ivt_pdt_id','id');
	}

	public function getPdtIvt(){
		return self::with('product')->paginate(10);
	}

}