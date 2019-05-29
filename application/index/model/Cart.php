<?php
namespace app\index\model;
use think\Model;
class Cart extends Model
{
	public function product(){
		return $this->belongsto('Product','cart_pdt_id','id');
	}
	//获得购物车中的产品信息
	public function getCartPdt(){
		return self::with('product')->select();
	}
}