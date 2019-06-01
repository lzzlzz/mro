<?php
namespace app\index\controller;
use think\Controller;
use app\index\model;
class Product extends Base
{
    //用户登录后 从session中获取用户id 找到对应的客户等级 //然后去分类表中找到该等级对应的折扣bilv
    public function lst()
    {
        $pdtModel=new model\Product;
        $pdtRes=$pdtModel->getIvt();
        //dump($res);die();
        $uid=session('uid');
        $cusRes=db('customer')->field('cus_cls_id')->find($uid);
        $clsRes=db('customer_class')->field('cls_discount')->find($cusRes['cus_cls_id']);
       // dump($clsRes['cls_discount']);die();
        $this->assign([
        	'pdtRes'=>$pdtRes,
            'discount'=>$clsRes['cls_discount'],
        ]);
    	
        return view();
    }
}
