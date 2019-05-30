<?php
namespace app\admin\model;
use think\Model;
class Stockout extends Model
{
	//从表属于主表
	public function product(){
		return $this->belongsto('Product','sko_pdt_id','id');
	}

	public function getPdtSko(){
		return self::with('product')->paginate(10);
	}


}