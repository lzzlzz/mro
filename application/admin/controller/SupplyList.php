<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Exception;
use app\admin\model;
class SupplyList extends Controller
{
    public function add(){
        //获取系统中全部供应商
        $supplierRes=db('supplier')->where('sp_checked','=',1)->select();
        //获取所有产品
        $pdtRes=db('product')->select();
        $jsonRes=json_encode($pdtRes);
        $this->assign([
            'supplierRes'=>$supplierRes,
            'pdtRes'=>$pdtRes,
            'jsonRes'=>$jsonRes,

        ]);
        if(request()->isPost()){
            $data=input('post.');
           // dump($data);die();
            $sl=new model\SupplyList;
            $sl->sl_num='SL'.time();
            $sl->sl_addtime=time();
            $sl->sl_sp_id=$data['sl_sp_id'];
            //根据各项的总价加总供货单总价
            $a=0;
            foreach ($data['slt_total_amount'] as $k => $v) {
                $a+=(double)$v;
            }
            $sl->sl_total_amount=$a;
            //将单项对应的数组转化成 各数组中的一项组合数组
            static $arr=[];
            foreach ($data as $key => $value) {
                if($key!='sl_sp_id'){
                    $i=0;
                    foreach ($value as $k => $v) {
                        $arr[$i++][$key]=$v;
                    }
                }
            }
           // dump($arr);die();
           // 将主供货单信息插入 并返回id
            try{
                Db::startTrans();
                static $res=[];
                $res[]=$sl->save();
                $uid=$sl->id;
                $sl=$sl::find($uid);

                /*用find找到刚插入的那条订单 好像如果用get也不会再次插入新的那么刚才总表为什么会插入两次呢*/
                $res[]=$sl->supItem()->saveAll($arr);
                if(in_array('0', $res)!=null){
                    throw new Exception('供货单添加失败');
                }
                Db::commit();
                $this->success('供货单信息添加成功',url('lst'));
            }catch(Exception $e){
                Db::rollback();
                $this->error('供货单信息添加失败');
            }
            
        }
        return view();
    }
    public function lst()
    {
        $sl=new model\SupplyList;
        $slRes=$sl::with('Supplier')->paginate(2);
    	//$spRes=db('supplier')->paginate(2);
    	$this->assign([
    		'slRes'=>$slRes,
    	]);
       return view();
    }
    public function edit($id){
        // $test=new Cate();
        // $res=$test->getSpId($id);
        // dump($res['supplier'][0]['sp_name']);die();
        // 一个一对多的关系 根据主表的id 可以找到从表中参考该id的所有记录
        // 现在要实现根据外键 找主表中的数据
        // $test=new SupplierModel();
        // $res=$test->getCateById($id);
        // dump($res['cate']['cate_name']);die();
        // 有了这个参照关系就可以直接连锁查到相关表的信息了 不需要再根据id去自己查
    	$spRes=model('supplier')->getCateById($id);
        $cateRes=db('cate')->where('pid','=','0')->select();
    	$this->assign([
    		'spRes'=>$spRes,
            'cateRes'=>$cateRes,
    	]);
    	if(request()->isPost()){
    		$data=input('post.');
    		$res=db('supplier')->update($data);
    		if($res){
    			$this->success('供应商信息审核成功',url('lst'));
    		}else{
    			$this->error('供应商信息审核失败');
    		}
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
    //处理前端的ajax请求
   public function getpdt()
    { 
        //获取供应商id
        $spId= intval(input('post.spId')); 
        //根据供应商id找一级分类
        $cateID=db('supplier')->field('sp_cate_id')->find($spId);
       // dump($cateID);die();
        //根据一级分类找该分类下对应的所有分类
        $cate=new model\Cate;
        //此处使用ORM一对多连表查询 大大简化步骤 直接在找分类的时候把产品一并找出
        //不需要先找所有分类 在根据分类找产品
        $data=$cate::with('product')->select();
        //dump($data['relation']);die();
        $pdtArr=$this->sortcate($data,$cateID['sp_cate_id']);
        exit(json_encode($pdtArr)); 
    }


//这个方法是递归的找某一个分类其下的所有子类
        public function sortcate($data,$pid){
            static $arr=[];
            foreach ($data as $k => $v) { //找顶级栏目  v是他的值
                if ($v['pid']==$pid) {//如果是顶级栏目就将其放进数组里
                    $arr[]=$v;
                    $this->sortcate($data,$v['id']);//找到顶级栏目后找其他栏目
                }
            }
            return $arr;
        }

}
