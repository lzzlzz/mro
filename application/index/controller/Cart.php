<?php
namespace app\index\controller;
use think\Controller;
use app\index\model;
class Cart extends Base
{
    public function lst()
    {

        $cartRes=model('cart')->getCartPdt();
        $this->assign([
            'cartRes'=>$cartRes,
        ]);
        //dump($cartRes);die();
        return view();
    }
//更新购物车的数量
    public function qtyUpdate(){
        if(request()->isPost()){
            $data=input('post.');
            //dump($data);die();
            $res=db('Cart')->update($data);
            if($res){
                $response=[
                    'errno'=>0,
                    'errmsg'=>'success',
                    'data'=>true,
                ];
            }else{
                 $response=[
                    'errno'=>1,
                    'errmsg'=>'fail',
                    'data'=>false,
                ];
            }
            exit(json_encode($response));
        }
    }
    public function add(){//响应Ajax添加购物车的操作
        if(request()->isPost()){
            $data=input('post.');
            $data['cart_pdt_id']=(int)$data['cart_pdt_id'];
            $flag=db('cart')->where('cart_pdt_id',$data['cart_pdt_id'])->find();
            if($flag!=null){//如果此前购物车已经有了我们要添加的东西
                //数量累计
                $flag['cart_quantity']+=(int)$data['cart_quantity'];
                //价格更新
                $flag['cart_price']+=(int)$data['cart_price'];
                $res=db('cart')->update($flag);
            }else{//添加的是之前没有的
                $data['cart_quantity']=(int)$data['cart_quantity'];
                $data['cart_price']=(double)$data['cart_price'];
                $data['cart_addtime']=time();
                $data['cart_cus_id']=session('uid');
                $res=db('cart')->insert($data);
            }
           
            if($res){
                $response=[
                    'errno'=>0,
                    'errmsg'=>'success',
                    'data'=>true,
                ];
            }else{
                 $response=[
                    'errno'=>1,
                    'errmsg'=>'fail',
                    'data'=>false,
                ];
            }
            exit(json_encode($response));
        }
       
    }
}
