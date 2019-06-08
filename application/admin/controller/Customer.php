<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\Model\Customer as CustomerModel;/*这个错误太低级了 
还是基础不牢 引入的应该是！！！admin下的model！！！不是think下的model*/
class Customer extends Base
{
    public function lst()
    {  /* 参照关系没有错 没有数据是因为在客户的分类id中出现了不在分类id中的情况*/
       $cusRes=CustomerModel::with('customerClass')->paginate(5);
      
    	//$cusRes=model('customer')->paginate(2);
    	$this->assign([
    		'cusRes'=>$cusRes,
    	]);
       return view();
    }
    public function edit($id){
    	$cusRes=db('customer')->find($id);
    	$this->assign([
    		'cusRes'=>$cusRes,
    	]);
    	if(request()->isPost()){
    		$data=input('post.');
    		$res=db('customer')->update($data);
    		if($res){
    			$this->success('用户信息修改成功',url('lst'));
    		}else{
    			$this->error('用户信息修改失败');
    		}
    	}
    	return view();
    }

    public function del($id){
    	$res=db('customer')->delete($id);
		if($res){
			$this->success('用户信息删除成功',url('lst'));
		}else{
			$this->error('用户信息删除失败');
		}
    }
  
}
