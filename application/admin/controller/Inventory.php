<?php
namespace app\admin\controller;
use think\Controller;

class Inventory extends Controller
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
