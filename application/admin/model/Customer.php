<?php
namespace app\admin\model;
use think\Model;
class Customer extends Model
{
	//从表属于主表
	public function customerClass(){
		return $this->belongsto('CustomerClass','cus_cls_id','id');
	}

	public function order(){
		return $this->hasMany('Order','order_cus_id','id');
	}

}