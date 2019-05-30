<?php
namespace app\admin\controller;
use think\Controller;

class Order extends Controller
{
    public function lst()
    {  
        $orderRes=model('Order')->getCusOrder();
    	$this->assign([
    		'orderRes'=>$orderRes,
    	]);
       return view();
    }
    
  
}
