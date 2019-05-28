<?php
namespace app\admin\model;
use think\Model;
class CustomerClass extends Model
{
	
	//从表属于主表
	public function customer(){
		return $this->hasmany('Customer','cus_cls_id','id');
	}
	//
	


}