<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Operation extends Base
{
    //销售情况的统计
    public function market()
    {  
        $order=Db::query("SELECT FROM_UNIXTIME(order_addtime,'%Y%m%d') days,SUM(b.odt_num) COUNT , b.odt_pdt_id FROM mro_order AS a LEFT JOIN mro_order_item AS b ON a.id = b.odt_order_id GROUP BY days,b.odt_pdt_id ");
       // dump($order);die();
       // 找到所有订单涉及的日期
        $data=Db::query("SELECT DISTINCT FROM_UNIXTIME(order_addtime,'%Y%m%d') days FROM mro_order");
      //  dump($data);die();
        $pdtRes=db('product')->field(['id','pdt_name'])->select();
        static $pdtName=[];
        foreach ($pdtRes as $k => $v) {
          $pdtName[$v['id']]=$v['pdt_name'];
        }
       // dump($order);die();
    	$this->assign([
    		    'order'=>json_encode($order),
            'data'=>json_encode($data),
            'pdtName'=>json_encode($pdtName),
    	]);
       return view();
    }
    //库存情况的统计
    public function storage()
    {  
        $ivtRes=model('Inventory')->getIvt();
        //dump($ivtRes);die();
        $this->assign([
            'res'=>json_encode($ivtRes),
        ]);
       return view();
    }
   
  
}
