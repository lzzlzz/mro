<?php
namespace app\admin\controller;
use think\Controller;

class Inventory extends Base
{
    public function lst()
    {  
        $ivtRes=model('Inventory')->getPdtIvt();
    	$this->assign([
    		'ivtRes'=>$ivtRes,
    	]);
       return view();
    }
    
  
}
