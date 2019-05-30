<?php
namespace app\admin\controller;
use think\Controller;

class Stockout extends Controller
{
    public function lst()
    {  
        $skoRes=model('Stockout')->getPdtSko();
    	$this->assign([
    		'skoRes'=>$skoRes,
    	]);
       return view();
    }
    
  
}
