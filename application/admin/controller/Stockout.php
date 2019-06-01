<?php
namespace app\admin\controller;
use think\Controller;

class Stockout extends Base
{
    public function lst()
    {  
        $skoRes=model('Stockout')->getPdtSko();
    	$this->assign([
    		'skoRes'=>$skoRes,
    	]);
       return view();
    }

    /**
     * 点击补货按钮将该条缺货记录加入补货清单 如果清单中存在相同类型 
     * 且尚未采购的补货单就合并 没有就新增
     */
    public function addrep($id,$pdtId){
//查出该产品对应的一级分类
    	$cateRes=db('product')->field('pdt_cate_id')->find($pdtId);
      //调用了Cate模型中的一个找顶级id的方法
      $ocateId=model('Cate')->getFather($cateRes['pdt_cate_id']);
    //  dump($ocateId);die();
    	$map['rep_cate_id']=$ocateId;
    	$map['rep_finish']=0;

    	$flag=db('replenish')->where($map)->find();
    		
    if($flag!=null){//如果存在合并的情况
    
      $res=db('stockout')->where('id',$id)->update(['sko_rep_id'=>$flag['id']]); 
    }else{//如果不存在就新增补货单
    	$rep=[
    		'rep_num'     => 'RE'.time(),
    		'rep_addtime' => time(),
    		'rep_cate_id' => $ocateId,

    	];

    	$repId=db('replenish')->insertGetId($rep);
    	$res=db('stockout')->where('id',$id)->update(['sko_rep_id'=>$repId]);
    }
	if($res){
      	$this->success('加入补货单成功',url('Purchase/replenish'));
      }else{
      	$this->error('加入补货单失败');
      }
    }
    
  
}
