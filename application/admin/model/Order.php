<?php
namespace app\admin\model;
use think\Model;
class Order extends Model
{
	//从表属于主表
	public function customer(){
		return $this->belongsto('Customer','order_cus_id','id');
	}

	public function getCusOrder(){
		return self::with('customer')->paginate(10);
	}

	//一个订单有多个子订单
	public function orderItem(){
		return $this->hasMany('OrderItem','odt_order_id','id');
	}

	public function outStorage(){
		return $this->hasOne('OutStorage','out_order_id','id');
	}

}