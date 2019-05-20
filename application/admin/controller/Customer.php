<?php
namespace app\admin\controller;
use think\Controller;
class Customer extends Controller
{
    public function lst()
    {
    	$cusRes=db('customer')->paginate(2);
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
