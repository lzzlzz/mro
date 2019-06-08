<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Exception;
use think\Session;
use app\index\model;
class Cart extends Base
{
   
    public function lst()
    {
        $username=Session::get('username');
    $cusId=db('customer')->field('id')->where('cus_name',$username)->find();
        $cartRes=model('cart')->getCartPdt($cusId['id']);
       // dump($cusRes);die();
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
    $username=Session::get('username');
    $cusId=db('customer')->field('id')->where('cus_name',$username)->find();
            //既要看有没有这个商品 还要看这个商品是不是这个用户买的 //两个条件同时满足才可以
            $condition=[
                'cart_pdt_id'=>$data['cart_pdt_id'],
                'cart_cus_id'=>$cusId['id']
            ];
            $flag=db('cart')->where($condition)->find();
            if($flag!=null){//如果此前购物车已经有了这个用户要添加的东西
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

    //结算功能
    public function pay(){
       // dump(input('post.'));die();
        $data=input('post.');
        $order['order_cus_id']=session('uid');
        $order['order_total_cost']=$data['ordetTotalCost'];
        $order['order_num']='O'.time();
        $order['order_addtime']=time();
try{
    Db::startTrans();
    static $res=[];
    $orderModel=new model\Order;
    $res[]=$orderModel->save($order);
    $uid=$orderModel->id;
    $orderModel=$orderModel::find($uid);
    $res[]=$orderModel->orderItem()->saveAll($data['orderItem']);
    //添加完订单后 要把购物车中对应的清空
    $res[]=db('cart')->delete($data['cartId']);
    if(in_array('0', $res)){
        throw new Exception('购买失败');
        
    }
    Db::commit();
    $response=[
            'errno'=>0,
            'errmsg'=>'success',
            'data'=>true,
        ];
   
}catch (Exception $e){
    Db::rollback();
    $response=[
              'errno'=>1,
              'errmsg'=>'fail',
              'data'=>$e,
             ];//事务验证成功就是失败后会抛出一堆错误
}
  exit(json_encode($response));      
      
      
    }

}
