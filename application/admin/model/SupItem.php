<?php
namespace app\admin\model;
use think\Model;
class SupItem extends Model
{
    //当模型名不与数据表名对应的时候声明一下这个变量
	protected $table='mro_supply_list_item';
	//从表属于主表
	public function supplyList(){
		return $this->belongsto('SupplyList','slt_sl_id','id');
	}
	//
	// public function getCateById($id){
	// 	return self::with('cate')->find($id);
	// }


}