<?php
namespace app\admin\model;
use think\Model;
class ReplenishItem extends Model
{
    
	//从表属于主表
	public function replenish(){
		return $this->belongsto('Replenish','rept_rep_id','id');
	}
	//
	


}