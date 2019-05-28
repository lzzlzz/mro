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
	// 供货单与入库单一对一的关系
	public function inStorage(){
		return $this->hasone('InStorage','in_sl_id','id');
	}
    public function supplier(){
    	return $this->belongsto('Supplier','sl_sp_id','id');
    }

}