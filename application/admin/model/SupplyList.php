<?php
namespace app\admin\model;
use think\Model;
class SupplyList extends Model
{
	//从表属于主表
	public function supItem(){
		return $this->hasmany('SupItem','slt_sl_id','id');
	}
	//
	// public function getCateById($id){
	// 	return self::with('cate')->find($id);
	// }


}