<?php
namespace app\admin\model;
use think\Model;
class Inventory extends Model
{
	//从表属于主表
	public function product(){
		return $this->belongsto('Product','ivt_pdt_id','id');
	}

	public function getPdtIvt(){
		return self::with('product')->paginate(10);
	}

	//为了获取饼状图
	public function getIvt(){
		
		$ivtRes=self::with('product')->select();

		static $arr=[];
		foreach ($ivtRes as $k => $v) {
			$arr[$v['product']['pdt_name']]=$v['ivt_quantity'];
		}
	   //dump($arr);die();
	    return $arr;
	}



}