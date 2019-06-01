<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
class Order extends Base
{
    public function lst()
    {  
        $orderRes=model('Order')->getCusOrder();
    	$this->assign([
    		'orderRes'=>$orderRes,
    	]);
       return view();
    }
    
    //订单收款后进行确认 更新客户积分等级 还有订单的完成状态
    public function affirm($id){
    	//根据订单id找到订单信息
    	////从订单信息中获取客户id和交易总额
    	$order=db('order')->field(['order_cus_id','order_total_cost'])->find($id);
    	
    	//根据客户id找到客户信息 计算总积分
    	$scoreRes=db('customer')->field(['cus_score','cus_cls_id'])->find($order['order_cus_id']);
    	$score=$scoreRes['cus_score'];
    	$nscore=$score+intval($order['order_total_cost']);
    	//dump($nscore);die();
    	
   		$clsRes=Db::query("select * from mro_customer_class where cls_low_score<=? AND cls_high_score >?",[$nscore,$nscore]);
   		//dump($clsRes);die();
   		$nclsId=$clsRes[0]['id'];
   	try{
   		Db::startTrans();
   		static $res=[];

   		if($nclsId!=$scoreRes['cus_cls_id']){//如果id发生变化 更新积分与等级
   			$res[]=db('customer')->where('id',$order['order_cus_id'])->update(['cus_score'=>$nscore,'cus_cls_id'=>$nclsId]);
   		}else{//如果没有变化则只更新积分
   			$res[]=db('customer')->where('id',$order['order_cus_id'])->update(['cus_score'=>$nscore]);
   		}
   		//更新订单完成状态
   		$res[]=db('order')->where('id',$id)->update(['order_finish'=>1]);

   		if(in_array(0, $res)){
   			throw new Exception("确认订单失败，请重新尝试~");
   			
   		}
   		Db::commit();
   		$this->success('订单确认成功，同志辛苦了！');
   	}catch (Exception $e){
   		Db::rollback();
   		$this->error($e);
   		
    }
   	}
  
}
