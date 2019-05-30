<?php
namespace app\admin\model;
use think\Model;
class OutStorage extends Model
{
	//从表属于主表
	public function order(){
		return $this->belongsto('Order','out_order_id','id');
	}
	

}