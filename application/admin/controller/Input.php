<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
use app\admin\model;
class Input extends Controller
{
    public function lst()
    {
     $slModel=new model\SupplyList;

    $slRes=$slModel::with('Supplier')->where('sl_storage','=',0)->paginate(5);
       
    $this->assign([
    	'slRes'=>$slRes,
    ]);
       return view();
    }
    public function lsted(){
        $insModel=new model\InStorage;
        $insRes=$insModel::with('SupplyList')->paginate(4);
       // dump($insRes[0]['supply_list']);die();
       // 根据入库单中关联的供货单中的供应商id找到供应商姓名 //不知道如何嵌套关联所以现在只能这么写
        $sprRes=db('supplier')->field(['id','sp_name'])->select();
        static $arr=[];
        foreach ($sprRes as $key => $value) {
            $arr[$value['id']]=$value['sp_name'];
        }
        $this->assign([
            'insRes'=>$insRes,
            'spArr'=>$arr,
        ]);
        return view();
    }
    public function edit($id){
        $supList=new model\SupplyList;
        $itemRes=$supList::with('supItem')->find($id);
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
    		'itemRes'=>$itemRes['sup_item'],
            'pdtArr'=>$pdtArr,
            'whRes'=>$whRes,
    	]);
        // dump($itemRes['sup_item']);die();
    	if(request()->isPost()){
    		$data=input('post.');
           // dump($data);die();
            static $arr=[];//把前端提交过来的变量转化为合适的数组形式
            foreach ($data as $key => $value) {
                if($key!='in_sl_id'){
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
        $flag=$ivt->where('ivt_pdt_id','=',$v['ivt_pdt_id'])->select();
      // dump($flag);die();
        /**
         * 对于要送入库存表中的每条记录 先判断表中是否存在如果存在则合*并数量生成新价格使用原仓库如果不存在则新增
         */
        if($flag!=null){//对已有的更新数量与价格
            $flag[0]['ivt_original_cost']=$this->price($flag[0]['ivt_original_cost'],$flag[0]['ivt_quantity'],$v['ivt_original_cost'],$v['ivt_quantity']);
            //dump($flag[0]['ivt_original_cost']);die();
            $flag[0]['ivt_quantity']+=$v['ivt_quantity'];
            $res[$k]=$ivt->update($flag[0]);
        }else{//对没有的进行插入
            $res[$k]=$ivt->insert($v);
        }
    }
    //将供货单状态变更
    $res[]=db('supply_list')->where('id',$data['in_sl_id'])->update(['sl_storage'=>1]);
    //在入库流水账中记录
    $inStorage=[
        'in_num'=>'IS'.time(),
        'in_sl_id'=>$data['in_sl_id'],
        'in_time'=>time(),
    ];
    $res[]=db('in_storage')->insert($inStorage);
    //$res[]=0;
    //dump($res);die();
    if(in_array('0', $res)){
        throw new Exception('供货单入库失败');
        
    }
    Db::commit();
    $this->success('供货单入库成功',url('lsted'));
}catch (Exception $e){
    Db::rollback();
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
