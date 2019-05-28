<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model;
class Supplier extends Controller
{
    public function lst()
    {
        $sp=new model\Supplier;
        $spRes=$sp::with('cate')->paginate(5);
    	//$spRes=db('supplier')->paginate(2);
    	$this->assign([
    		'spRes'=>$spRes,
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
    			$this->success('供应商信息审核结果提交成功',url('lst'));
    		}else{
    			$this->error('供应商信息审核结果提交失败');
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
  
}
