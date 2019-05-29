<?php
namespace app\index\controller;
use think\Controller;
use app\index\model;
class Product extends Controller
{
    public function lst()
    {
        $pdtModel=new model\Product;
        $pdtRes=$pdtModel->getIvt();
        //dump($res);die();
        $this->assign([
        	'pdtRes'=>$pdtRes,
        ]);
    	
        return view();
    }
}
