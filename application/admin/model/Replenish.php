<?php
namespace app\admin\model;
use think\Model;
class Replenish extends Model
{
	//从表属于主表
	public function cate(){
		return $this->belongsto('cate','rep_cate_id','id');
	}

	public function getCateRep(){
		return self::with('cate')->paginate(10);
	}
//补货单与缺货单一对多的关系
	public function stockout(){
		return $this->hasmany('Stockout','sko_rep_id','id');
	}
//根据补货单的id找到缺货单的记录
	public function getSkoRep($id){
		return self::with('stockout')->find($id);
	}

	//补货单与补货单item一对多的关系
	public function replenishItem(){
		return $this->hasmany('ReplenishItem','rept_rep_id','id');
	}
//根据补货单的id找到缺货单的记录
	public function getReplenish($id){
		return self::with('replenishItem')->find($id);
	}




}