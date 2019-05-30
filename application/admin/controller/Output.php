<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
use app\admin\model;
class Output extends Controller
{
    public function lst()
    {  
        $orderRes=model('Order')->getCusOrder();
        $this->assign([
            'orderRes'=>$orderRes,
        ]);
       return view();
    }
    public function lsted(){
        $outModel=new model\OutStorage;
        $outRes=$outModel::with('Order')->paginate(4);
       // dump($outRes[0]['supply_list']);die();
       // 根据入库单中关联的供货单中的供应商id找到供应商姓名 //不知道如何嵌套关联所以现在只能这么写
        $sprRes=db('customer')->field(['id','cus_name'])->select();
        static $arr=[];
        foreach ($sprRes as $key => $value) {
            $arr[$value['id']]=$value['cus_name'];
        }
        $this->assign([
            'outRes'=>$outRes,
            'cusArr'=>$arr,
        ]);
        return view();
    }
    public function edit($id){
        $order=new model\Order;
        $itemRes=$order::with('orderItem')->find($id);
       // dump($itemRes['sup_item']);die();
    	$pdtRes=db('product')->field(['id','pdt_name'])->select();
        static $pdtArr=[];
        foreach ($pdtRes as $k => $v) {
            $pdtArr[$v['id']]=$v['pdt_name'];
        }
        //dump($pdtRes);die();
        //volist的循环可以嵌套 
        $whRes=db('warehouse')->field(['id','wh_name'])->select();
    	$this->assign([
    		'itemRes'=>$itemRes['order_item'],
            'pdtArr'=>$pdtArr,
            'whRes'=>$whRes,
    	]);
        // dump($itemRes['order_item']);die();
    	if(request()->isPost()){
    		$data=input('post.');
           // dump($data);die();
            static $arr=[];//把前端提交过来的变量转化为合适的数组形式
            foreach ($data as $key => $value) {
                if($key!='out_order_id'){
                    $i=0;
                    foreach ($value as $k => $v) {
                        $arr[$i++][$key]=$v;
                    }
                }
                   
            }
try{
    Db::startTrans();//开始事务

    static $res=[];//记录各项操作是否成功
    $ivt=db('inventory');
    //对数组中每条数据进行处理
    foreach ($arr as $k => $v) {
        $oivt=$ivt->where('ivt_pdt_id','=',$v['order_pdt_id'])->find();
      // dump($flag);die();
        /**
         * 对于订单中的每个产品，先搜索库存记录 然后将已有库存与订单量进行对比
         * 如果库存量大于等于订单量则发货 小于订单量则产生缺货订单
         */
        $stockOut['sko_quantity']=intval($v['order_quantity'])-intval($oivt['ivt_quantity']);
        if($stockOut['sko_quantity']<=0){//库存量满足订单量
           
            $oivt['ivt_quantity']-=$v['order_quantity'];
            $res[$k]=$ivt->update($oivt);
        }else{//库存量不足 存入缺货单  抛出缺货异常 
           $need=intval($v['order_quantity']);
           throw new Exception('订单产品断货');
        }
    }
    
    //在出库流水账中记录
    $outStorage=[
        'out_num'=>'OS'.time(),
        'out_order_id'=>$data['out_order_id'],
        'out_time'=>time(),
    ];
    $lastId=db('out_storage')->insertGetId($outStorage);
    $res[]=$lastId;
    //dump($res);die();
    //将供货单状态变更
    $res[]=db('order')->where('id',$data['out_order_id'])->update(['order_delivery'=>$lastId]);
    if(in_array('0', $res)){
        throw new Exception('订单出库失败');
        
    }
    Db::commit();
    $this->success('订单出库成功',url('lsted'));
}catch (Exception $e){
    Db::rollback();
    //处理缺货异常 生成缺货单
    //如果缺货的产品id已经在缺货单中存在   ！！！而且尚未供货这个等候完善！！！
    $flag=db('stockout')->where('sko_pdt_id',$v['order_pdt_id'])->find();
    if($flag!=null){//说明缺货单中已存在 则将数量加上 对于更新的这种应该直接加订单量
        $flag['sko_quantity']+=$need;
        $ores=db('stockout')->update($flag);
    }else{//对于新插入的缺货记录 缺货量是订单量-库存量
        $stockOut['sko_pdt_id']=$v['order_pdt_id'];
        $stockOut['sko_num']="SKO".time();
        $stockOut['sko_addtime']=time();
        $ores=db('stockout')->insert($stockOut);
    }
    
    if($ores){
        $this->success('缺货单已生成，请及时补货',url('stockout/lst'));
    }else{
        $this->error('缺货单生成失败，请手动补货');
    }
    
    $this->error($e);//事务验证成功就是失败后会抛出一堆错误
}
    	// 	if($res1 && $res2){
    	// 		$this->success('供货单入库成功',url('lsted'));
    	// 	}else{
    	// 		$this->error('供货单入库失败');
    	// 	}
   }
    return view();
    
}

    public function del($id){
    	$res=db('supplier')->delete($id);
		if($res){
			$this->success('用户信息删除成功',url('lst'));
		}else{
			$this->error('用户信息删除失败');
		}
    }
/**
 * [price description]根据库存中已有的价格和数量 计算总价 然后计算新增总价
 * 最后加和取均值 取新旧产品的均值 按所占比例
 * @param  [type] $q0 [description]已有的数量
 * @param  [type] $p0 [description]原来的单价
 * @param  [type] $q1 [description]新增的数量
 * @param  [type] $p1 [description]新增的单价
 * @return [type]     [description]
 */
    public function price($p0,$q0,$p1,$q1){
        $q0=intval($q0);
        $p0=doubleval($p0);
        $q1=intval($q1);
        $p1=doubleval($p1);
       
        return ($q0*$p0+$q1*$p1)/($q0+$q1);
    }
  
}
