<?php
namespace app\index\model;
use think\Model;
class OrderItem extends Model
{
	public function order(){
		return $this->belongsto('Order','odt_order_id','id');
	}
}
	