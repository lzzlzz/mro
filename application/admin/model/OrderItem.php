<?php
namespace app\admin\model;
use think\Model;
class OrderItem extends Model
{
    
	//从表属于主表
	public function order(){
		return $this->belongsto('Order','odt_order_id','id');
	}
	//
	// public function getCateById($id){
	// 	return self::with('cate')->find($id);
	// }


}