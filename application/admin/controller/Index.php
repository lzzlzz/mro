<?php
namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
    	static $arr=[];
    	$arr[]=db('product')->count('id');
    	
    	$arr[]=db('supplier')->count('id');
    
    	
    	$arr[]=db('order')->sum('order_total_cost');
    	
    	$arr[]=db('in_storage')->count('id');
    	$arr[]=db('supply_list')->where('sl_storage',0)->count('id');
    	$arr[]=db('out_storage')->count('id');
    	$arr[]=db('order')->where('order_delivery',0)->count('id');
    	$arr[]=db('order')->where('order_finish',0)->sum('order_total_cost');
    	$arr[]=db('customer')->count('id');
    //	dump($arr);die();
        $this->assign([
        	'arr'=>$arr,
        ]);
       return view();
    }
   
}
