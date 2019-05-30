<?php
namespace app\index\model;
use think\Model;
class Order extends Model
{
	public function orderItem(){
		return $this->hasMany('OrderItem','odt_order_id','id');
	}

	//对订单进行关联插入 这个在模型中的添加暂时放一下 在控制器中实现了
	// public function addOrder($order,$item){
	// 	self->save($order);
	// 	$id=self->id;
	// 	$res=self::find($id)->orderItem()->saveAll($item);
	// 	if($res){
	// 		$this->success('订单插入成功！');
	// 	}else{
	// 		$this->error('订单插入失败');
	// 	}

	// }
}
	