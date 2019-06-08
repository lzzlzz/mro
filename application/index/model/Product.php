<?php
namespace app\index\model;
use think\Model;
class Product extends Model
{
	public function inventory(){
		return $this->hasOne('Inventory','ivt_pdt_id','id');
	}
	//产品与购物车中的信息一对一
	public function cart(){
		return $this->hasOne('Cart','cart_pdt_id','id');
	}
	public function getIvt($id){
		if($id==0){
			return self::with('inventory')->select();
		}else{
			$arr=model('Cate')->getChildIds($id);
			$arr[]=intval($id);
			//dump($arr);die();
			return self::with('inventory')->where('pdt_cate_id','in',$arr)->select();
		}
		
	}
}