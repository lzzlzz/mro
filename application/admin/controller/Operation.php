<?php
namespace app\admin\controller;
use think\Controller;

class Operation extends Base
{
    //销售情况的统计
    public function market()
    {  
        
    	$this->assign([
    		
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
