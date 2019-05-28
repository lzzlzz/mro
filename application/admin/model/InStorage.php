<?php
namespace app\admin\model;
use think\Model;
class InStorage extends Model
{
	//从表属于主表
	public function supplyList(){
		return $this->belongsto('SupplyList','in_sl_id','id');
	}
	//
	public function getCateById($id){
		return self::with('cate')->find($id);
	}


}