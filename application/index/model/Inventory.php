<?php
namespace app\index\model;
use think\Model;
class Inventory extends Model
{
	public function product(){
		return $this->belongsto('Product','ivt_pdt_id','id');
	}
}